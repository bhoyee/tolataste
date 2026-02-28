<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\BreadcrumbImage;
use App\Models\BannerImage;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Setting;
use Cart;
use Session;
use Auth;

class CartController extends Controller
{

    public function cart(){
        $cart_contents = Cart::content();


        return view('cart')->with(['cart_contents' => $cart_contents],200);
    }

    public function add_to_cart(Request $request)
    {
        $product = Product::find($request->product_id);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        // Handle optional items
        $optional_items = [];
        $optional_item_price = 0;
        if ($request->optional_items) {
            foreach ($request->optional_items as $optional) {
                $arr = explode('(::)', $optional);
                $optional_items[] = [
                    'optional_name' => $arr[0],
                    'optional_price' => $arr[1]
                ];
                $optional_item_price += $arr[1];
            }
        }
    
        // Handle protein items
        $protein_items = [];
        $protein_item_price = 0;
        if ($request->protein_items) {
            foreach ($request->protein_items as $protein) {
                $arr = explode('__', $protein);
                if (count($arr) === 2) {
                    $protein_items[] = [
                        'protein_name' => $arr[0],
                        'protein_price' => $arr[1]
                    ];
                    $protein_item_price += $arr[1];
                }
            }
        }
        

         // Soup Items
         $soup_items = [];
         $soup_item_price = 0;
         if ($request->soup_items) {
             foreach ($request->soup_items as $soup) {
                 [$name, $price] = explode('__', $soup);
                 $price = (float) $price;
                 $soup_items[] = ['soup_name' => $name, 'soup_price' => $price];
                 $soup_item_price += $price;
             }
         }
         $soup_items = array_values($soup_items); // ✅ flatten array keys
         

        // Wrap Items
        $wrap_items = [];
        $wrap_item_price = 0;
        if ($request->wrap_items) {
            foreach ($request->wrap_items as $wrap) {
                [$name, $price] = explode('__', $wrap);
                $price = (float) $price;
                $wrap_items[] = ['wrap_name' => $name, 'wrap_price' => $price];
                $wrap_item_price += $price;
            }
        }
        $wrap_items = array_values($wrap_items);
        

        // Drink Items
        $drink_items = [];
        $drink_item_price = 0;
        if ($request->drink_items) {
            foreach ($request->drink_items as $drink) {
                [$name, $price] = explode('__', $drink);
                $price = (float) $price;
                $drink_items[] = ['drink_name' => $name, 'drink_price' => $price];
                $drink_item_price += $price;
            }
        }
        $drink_items = array_values($drink_items);
        
    
        // Handle size/variant
        $variant_array = [null, $request->variant_price];
        if ($request->has('size_variant')) {
            $variant_array = explode('(::)', $request->size_variant);
            if (count($variant_array) < 2) {
                $variant_array[1] = $request->variant_price;
            }
        } else {
            $variant_array[0] = null;
        }
    
        // Check for duplicates
        foreach (Cart::content() as $cart_content) {
            if ($cart_content->id == $request->product_id && $cart_content->options->size == $variant_array[0]) {
                return response()->json(['message' => trans('Item already added')], 403);
            }
        }
    
        // Total price

        $base_price = $request->variant_price;
        $total_price = $base_price + $optional_item_price + $protein_item_price + $soup_item_price + $wrap_item_price + $drink_item_price;
    
        // Add to cart
        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $total_price,
            'weight' => 1,
            'options' => [
                'image' => $product->thumb_image,
                'slug' => $product->slug,
                'size' => $variant_array[0],
                'size_price' => $variant_array[1],
                'optional_items' => $optional_items,
                'optional_item_price' => $optional_item_price,
                'protein_items' => $protein_items,
                'protein_item_price' => $protein_item_price,
                'soup_items' => $soup_items,
                'soup_item_price' => $soup_item_price,
                'wrap_items' => $wrap_items,
                'wrap_item_price' => $wrap_item_price,
                'drink_items' => $drink_items,
                'drink_item_price' => $drink_item_price,
                'food_instruction' => $request->food_instruction ?? ''
            ]
        ]);
    
        // ✅ Return the original mini cart view that worked
        return response()->json([
            'html' => view('mini_single_item')->render(), // this view already includes everything needed
            'count' => Cart::count(),
        ]);

    }
    
    

    public function cart_quantity_update(Request $request){

        Cart::update($request->rowid, ['qty' => $request->quantity]);

        $notification = trans('Item updated successfully');
        return response()->json(['message' => $notification]);

    }

    public function remove_cart_item($rowId)
    {
        try {
            Cart::remove($rowId);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid cart item.',
                'error' => true
            ], 422);
        }
    
        $html = view('mini_single_item')->render(); // Adjust this to your correct partial view name
    
        return response()->json([
            'message' => trans('user.Item removed successfully'),
            'html' => $html,
            'count' => Cart::count(),
        ]);
    }
    

    public function cart_clear(){
        Cart::destroy();
        Session::forget('coupon_price');
        Session::forget('offer_type');

        $notification = trans('Cart clear successfully');
        return response()->json(['message' => $notification]);
    }


    public function load_cart_item(){
        return view('mini_single_item');
    }



    public function editCartItem($rowId)
    {
        try {
            $cartItem = Cart::get($rowId);
    
            // Dummy available proteins for now — replace with actual DB fetch if needed
            $availableProteins = [
                (object)['name' => 'Goat', 'price' => 6],
                (object)['name' => 'Tilapia', 'price' => 35],
                (object)['name' => 'Chicken', 'price' => 10],
            ];
    
            return response()->json([
                'html' => view('edit-cart-form', [
                    'cartItem' => $cartItem,
                    'availableProteins' => $availableProteins,
                    'currency_icon' => '$' // Or fetch from config
                ])->render()
            ]);
        } catch (\Exception $e) {
            \Log::error('Edit cart error: '.$e->getMessage());
            return response()->json([
                'message' => 'Server Error'
            ], 500);
        }
    }
    


    public function updateCartItem(Request $request, $rowId)
    {
        try {
            Log::info("Updating cart item: " . $rowId);
    
            $cartItem = Cart::get($rowId);
    
            if (!$cartItem) {
                Log::warning("Cart item not found for rowId: " . $rowId);
                return response()->json(['message' => 'Item not found'], 404);
            }
    
            $protein_items = [];
            $protein_item_price = 0;
    
            if ($request->has('protein_items')) {
                foreach ($request->protein_items as $protein) {
                    $arr = explode('__', $protein);
                    if (count($arr) === 2) {
                        $protein_items[] = [
                            'protein_name' => $arr[0],
                            'protein_price' => $arr[1]
                        ];
                        $protein_item_price += $arr[1];
                    }
                }
            }
    
            $updatedOptions = [
                ...$cartItem->options->toArray(),
                'protein_items' => $protein_items,
                'protein_item_price' => $protein_item_price,
                'food_instruction' => $request->food_instruction
            ];
    
            $updatedPrice = $cartItem->options->size_price + $protein_item_price;
    
            Cart::update($rowId, [
                'qty' => $cartItem->qty,
                'price' => $updatedPrice,
                'options' => $updatedOptions
            ]);
    
            Log::info("Cart item updated: " . $rowId);
            return response()->json(['message' => 'Cart updated']);
    
        } catch (\Throwable $e) {
            Log::error('Update Cart Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'Server Error'], 500);
        }
    }
    

    public function apply_coupon(Request $request){
        if($request->coupon == null){
            $notification = trans('Coupon field is required');
            return response()->json(['message' => $notification],403);
        }

        $user = Auth::guard('web')->user();

        $coupon = Coupon::where(['code' => $request->coupon, 'status' => 1])->first();

        if(!$coupon){
            $notification = trans('Invalid Coupon');
            return response()->json(['message' => $notification],403);
        }

        if($coupon->expired_date < date('Y-m-d')){
            $notification = trans('Coupon already expired');
            return response()->json(['message' => $notification],403);
        }

        if($coupon->apply_qty >=  $coupon->max_quantity ){
            $notification = trans('Sorry! You can not apply this coupon');
            return response()->json(['message' => $notification],403);
        }

        if($coupon->offer_type == 1){
            $coupon_price = $coupon->discount;
            Session::put('coupon_price', $coupon_price);
            Session::put('offer_type', 1);
            Session::put('coupon_name', $request->coupon);
        }else {
            $coupon_price = $coupon->discount;
            Session::put('coupon_price', $coupon_price);
            Session::put('offer_type', 2);
            Session::put('coupon_name', $request->coupon);
        }

        return response()->json(['message' => trans('Coupon applied successfully'), 'discount' => $coupon->discount, 'offer_type' => $coupon->offer_type]);

    }

    public function apply_coupon_from_checkout(Request $request){
        if($request->coupon == null){
            $notification = trans('Coupon field is required');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $user = Auth::guard('web')->user();

        $coupon = Coupon::where(['code' => $request->coupon, 'status' => 1])->first();

        if(!$coupon){
            $notification = trans('Invalid Coupon');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        if($coupon->expired_date < date('Y-m-d')){
            $notification = trans('Coupon already expired');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        if($coupon->apply_qty >=  $coupon->max_quantity ){
            $notification = trans('Sorry! You can not apply this coupon');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        if($coupon->offer_type == 1){
            $coupon_price = $coupon->discount;
            Session::put('coupon_price', $coupon_price);
            Session::put('offer_type', 1);
            Session::put('coupon_name', $request->coupon);
        }else {
            $coupon_price = $coupon->discount;
            Session::put('coupon_price', $coupon_price);
            Session::put('offer_type', 2);
            Session::put('coupon_name', $request->coupon);
        }

        $notification = array('messege'=> trans('Coupon applied successfully') ,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
}
