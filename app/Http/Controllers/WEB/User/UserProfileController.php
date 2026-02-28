<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;

use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\OrderProduct;
use App\Models\Wishlist;
use App\Models\ProductReport;
use App\Models\GoogleRecaptcha;
use App\Models\BannerImage;
use App\Models\DeliveryArea;
use App\Models\User;
use App\Models\CompareProduct;
use App\Models\Address;
use App\Models\Reservation;
use App\Rules\Captcha;
use Image;
use File;
use Str;
use Hash;
use Slug;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReservationNotification;
use App\Jobs\SendReservationNotification;


use App\Models\OrderAddress;

class UserProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web')->except(['store_reservation']);
    }
    

    public function dashboard(){

        $user = Auth::guard('web')->user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        $total_order = $orders->count();
        $complete_order = $orders->where('order_status',3)->count();
        $pending_order = $orders->where('order_status',0)->count();
        $declined_order = $orders->where('order_status',4)->count();

        $personal_info = User::select('id','name','phone','email','image','address')->find($user->id);

        $addresses = Address::with('deliveryArea')->where(['user_id' => $user->id])->get();

        $wishlists = Wishlist::where(['user_id' => $user->id])->get();
        $wishlist_products = array();

        foreach($wishlists as $wishlist){
            $wishlist_products[] = $wishlist->product_id;
        }
        $products = Product::whereIn('id', $wishlist_products)->get();

        $reviews = ProductReview::with('product')->orderBy('id','desc')->where(['user_id' => $user->id])->get();
        $delivery_areas = DeliveryArea::where('status', 1)->get();

        $reservations = Reservation::with('user')->where('user_id', $user->id)->orderBy('id','desc')->get();

        return view('user.dashboard')->with([
            'personal_info' => $personal_info,
            'total_order' => $total_order,
            'complete_order' => $complete_order,
            'pending_order' => $pending_order,
            'declined_order' => $declined_order,
            'addresses' => $addresses,
            'products' => $products,
            'reviews' => $reviews,
            'orders' => $orders,
            'delivery_areas' => $delivery_areas,
            'reservations' => $reservations,
        ]);
    }


    public function update_profile(Request $request){
        $user = Auth::guard('web')->user();
        $rules = [
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$user->id,
            'phone'=>'required',
            'address'=>'required',
        ];
        $customMessages = [
            'name.required' => trans('user_validation.Name is required'),
            'email.required' => trans('user_validation.Email is required'),
            'email.unique' => trans('user_validation.Email already exist'),
            'phone.required' => trans('user_validation.Phone is required'),
            'address.required' => trans('user_validation.Address is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();

        if($request->file('image')){
            $old_image=$user->image;
            $user_image=$request->image;
            $extention=$user_image->getClientOriginalExtension();
            $image_name= Str::slug($request->name).date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $image_name='uploads/custom-images/'.$image_name;

            Image::make($user_image)
                ->save(public_path().'/'.$image_name);

            $user->image=$image_name;
            $user->save();
            if($old_image){
                if(File::exists(public_path().'/'.$old_image))unlink(public_path().'/'.$old_image);
            }
        }

        $notification = trans('user_validation.Update Successfully');
        return response()->json(['user' => $user, 'message' => $notification]);
    }

    public function update_password(Request $request){
        $rules = [
            'current_password'=>'required',
            'password'=>'required|min:4|confirmed',
        ];
        $customMessages = [
            'current_password.required' => trans('user_validation.Current password is required'),
            'password.required' => trans('user_validation.Password is required'),
            'password.min' => trans('user_validation.Password minimum 4 character'),
            'password.confirmed' => trans('user_validation.Confirm password does not match'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password = Hash::make($request->password);
            $user->save();
            $notification = 'Password change successfully';
            return response()->json(['message' => $notification]);
        }else{
            $notification = trans('user_validation.Current password does not match');
            return response()->json(['message' => $notification],403);
        }
    }

 public function upload_user_avatar(Request $request)
{
    $user = Auth::guard('web')->user();

    if ($request->hasFile('image')) {
        $old_image = $user->image;
        $user_image = $request->file('image');
        $extension = $user_image->getClientOriginalExtension();
        $image_name = Str::slug($user->name) . date('-Y-m-d-H-i-s-') . rand(999, 9999) . '.' . $extension;

        // Save to public_html/uploads/custom-images
        $destination = base_path('../public_html/uploads/custom-images/');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $user_image->move($destination, $image_name);

        $user->image = 'uploads/custom-images/' . $image_name;
        $user->save();

        if ($old_image && file_exists(base_path('../public_html/' . $old_image))) {
            @unlink(base_path('../public_html/' . $old_image));
        }
    }

    $notification = trans('user_validation.Update Successfully');
    return response()->json(['message' => $notification]);
}


    public function add_to_wishlist($id){
        $user = Auth::guard('web')->user();

        $is_exist = Wishlist::where(['product_id' => $id, 'user_id' => $user->id])->count();
        if($is_exist == 0){
            $wishlist = new Wishlist();
            $wishlist->user_id = $user->id;
            $wishlist->product_id = $id;
            $wishlist->save();
            return response()->json(['message' => trans('user_validation.Wishlist added successfully')]);
        }else{
            return response()->json(['message' => trans('user_validation.Item already added on the wishlist')],403);
        }


    }

    public function remove_to_wishlist($id){
        $user = Auth::guard('web')->user();
        Wishlist::where(['product_id' => $id, 'user_id' => $user->id])->delete();

        $notification= trans('user_validation.Wishlist removed successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }

    public function store_review(Request $request){
        $rules = [
            'rating'=>'required',
            'review'=>'required',
            'product_id'=>'required',
            'g-recaptcha-response'=>new Captcha()
        ];
        $customMessages = [
            'rating.required' => trans('user_validation.Rating is required'),
            'review.required' => trans('user_validation.Review is required'),
            'product_id.required' => trans('user_validation.Product is required'),
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();
        $isExistOrder = false;
        $orders = Order::where(['user_id' => $user->id])->get();
        foreach ($orders as $key => $order) {
            foreach ($order->orderProducts as $key => $orderProduct) {
                if($orderProduct->product_id == $request->product_id){
                    $isExistOrder = true;
                }
            }
        }

        if(!$isExistOrder){
            $message = trans('user_validation.You have to purchase first');
            return response()->json(['message' => $message],403);
        }

        $isReview = ProductReview::where(['product_id' => $request->product_id, 'user_id' => $user->id])->count();
        if($isReview > 0){
            $message = trans('user_validation.You have already submited review');
            return response()->json(['message' => $message],403);
        }

        $product = Product::find($request->product_id);
        $review = new ProductReview();
        $review->user_id = $user->id;
        $review->rating = $request->rating;
        $review->review = $request->review;
        $review->product_id = $request->product_id;
        $review->save();

        $message = trans('user_validation.Review added successfully');
        return response()->json(['message' => $message]);
    }


    public function single_order($id){
        $order = Order::with('orderProducts','orderAddress')->find($id);

        return view('user.order_show', compact('order'));
    }
    
     public function store_reservation(Request $request)
    {
        $user = Auth::guard('web')->user();
    
        $rules = [
            'reserve_date' => 'required|date',
            'reserve_time' => 'required',
            'person' => 'required|integer|min:1',
        ];
    
        // If guest
        if (!$user) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'nullable|email|max:255';
            $rules['guest_phone'] = 'required|string|max:20';
        }
    
        $request->validate($rules);
    
        $reservation = new Reservation();
    
        if ($user) {
            $reservation->user_id = $user->id;
            $reservation->reserve_date = $request->reserve_date;
            $reservation->reserve_time = $request->reserve_time;
            $reservation->person_qty = $request->person;
            
            // Update user phone if not already set
            if (!$user->phone && $request->phone) {
                $user->phone = $request->phone;
                $user->save();
            }
        } else {
            $reservation->user_id = 0; // or null, depending on your DB rules
            $reservation->guest_name = $request->guest_name;
            $reservation->guest_email = $request->guest_email;
            $reservation->guest_phone = $request->guest_phone;
            $reservation->reserve_date = $request->reserve_date;
            $reservation->reserve_time = $request->reserve_time;
            $reservation->person_qty = $request->person;
        }
    
        $reservation->save();

        // ✅ Send WhatsApp alert to admin
        $message = "📅 *New Reservation Request*\n\n"
        . "*Name:* " . ($user ? $user->name : $request->guest_name) . "\n"
        . "*Email:* " . ($user ? $user->email : $request->guest_email) . "\n"
        . "*Phone:* " . ($user ? $user->phone : $request->guest_phone) . "\n"
        . "*Date:* {$request->reserve_date}\n"
        . "*Time:* {$request->reserve_time}\n"
        . "*Guests:* {$request->person}\n\n"
        . "👉 Please check the dashboard.";

        sendWhatsAppOrderNotification($message);

     
            // Dispatch email notification after response
            SendReservationNotification::dispatch($reservation);

    
        return redirect()->back()->with([
            'messege' => trans('user_validation.Reservation requeste submited'),
            'alert-type' => 'success'
        ]);
    }

//   public function store_reservation(Request $request)
//     {
//         $user = Auth::guard('web')->user();
    
//         $rules = [
//             'reserve_date' => 'required|date',
//             'reserve_time' => 'required',
//             'person' => 'required|integer|min:1',
//         ];
    
//         // If guest
//         if (!$user) {
//             $rules['guest_name'] = 'required|string|max:255';
//             $rules['guest_email'] = 'nullable|email|max:255';
//             $rules['guest_phone'] = 'required|string|max:20';
//         }
    
//         $request->validate($rules);
    
//         $reservation = new Reservation();
    
//         if ($user) {
//             $reservation->user_id = $user->id;
//             $reservation->reserve_date = $request->reserve_date;
//             $reservation->reserve_time = $request->reserve_time;
//             $reservation->person_qty = $request->person;
            
//             // Update user phone if not already set
//             if (!$user->phone && $request->phone) {
//                 $user->phone = $request->phone;
//                 $user->save();
//             }
//         } else {
//             $reservation->user_id = 0; // or null, depending on your DB rules
//             $reservation->guest_name = $request->guest_name;
//             $reservation->guest_email = $request->guest_email;
//             $reservation->guest_phone = $request->guest_phone;
//             $reservation->reserve_date = $request->reserve_date;
//             $reservation->reserve_time = $request->reserve_time;
//             $reservation->person_qty = $request->person;
//         }
    
//         $reservation->save();

     
//             // Dispatch email notification after response
//             SendReservationNotification::dispatch($reservation);

    
//         return redirect()->back()->with([
//             'messege' => trans('user_validation.Reservation requeste submited'),
//             'alert-type' => 'success'
//         ]);
//     }
    

    public function delete_account(){

        if(env('APP_MODE') == 0){
            $notification = trans('This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $user = Auth::guard('web')->user();

        $user_image = $user->image;

        if($user_image){
            if(File::exists(public_path().'/'.$user_image))unlink(public_path().'/'.$user_image);
        }
        ProductReport::where('user_id',$user->id)->delete();
        ProductReview::where('user_id',$user->id)->delete();
        Address::where('user_id',$user->id)->delete();
        Wishlist::where('user_id',$user->id)->delete();

        $orders = Order::where('user_id',$user->id)->orderBy('id','desc')->get();
        foreach($orders as $order){
            $orderProducts = OrderProduct::where('order_id',$order->id)->get();
            $orderAddress = OrderAddress::where('order_id',$order->id)->first();
            OrderAddress::where('order_id',$order->id)->delete();

            $order->delete();
        }

        $user->delete();

        Auth::guard('web')->logout();

        $notification = trans('admin_validation.Delete Successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('home')->with($notification);

    }

}
