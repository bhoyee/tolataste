<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\Guest;
use App\Models\OrderProduct;
use App\Models\OrderAddress;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $orders = Order::with('user')->orderBy('id','desc')->get();
        $title = trans('admin_validation.All Orders');
        $setting = Setting::first();

        return view('admin.order', compact('orders','title','setting'));

    }

    public function pendingOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',0)->get();
        $title = trans('admin_validation.Pending Orders');
        $setting = Setting::first();

        return view('admin.order', compact('orders','title','setting'));
    }

    public function pregressOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',1)->get();
        $title = trans('admin_validation.Pregress Orders');
        $setting = Setting::first();

        return view('admin.order', compact('orders','title','setting'));
    }

    public function deliveredOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',2)->get();
        $title = trans('admin_validation.Delivered Orders');
        $setting = Setting::first();

        return view('admin.order', compact('orders','title','setting'));
    }

    public function completedOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',3)->get();
        $title = trans('admin_validation.Completed Orders');
        $setting = Setting::first();
        return view('admin.order', compact('orders','title','setting'));
    }

    public function declinedOrder(){
        $orders = Order::with('user')->orderBy('id','desc')->where('order_status',4)->get();
        $title = trans('admin_validation.Declined Orders');
        $setting = Setting::first();
        return view('admin.order', compact('orders','title','setting'));
    }

    public function cashOnDelivery(){
        $orders = Order::with('user')->orderBy('id','desc')->where('cash_on_delivery',1)->get();
        $title = trans('admin_validation.Cash On Delivery');
        $setting = Setting::first();
        return view('admin.order', compact('orders','title','setting'));
    }

    public function show($id){
        $order = Order::with('user','orderProducts','orderAddress')->find($id);
        $setting = Setting::first();

        return view('admin.show_order',compact('order','setting'));
    }


public function updateOrderStatus(Request $request, $id)
{
    $rules = [
        'order_status' => 'required',
        'payment_status' => 'required',
    ];
    $this->validate($request, $rules);

    // Eager load user and guest relationships
    $order = Order::with(['user', 'guest'])->find($id);

    if (!$order) {
        Log::error("Order not found when trying to update status", [
            'order_id' => $id
        ]);
        return redirect()->back()->withErrors(['error' => 'Order not found.']);
    }

    // Map numeric statuses to labels
    $statusLabels = [
        0 => 'Pending',
        1 => 'In Progress',
        2 => 'Delivered',
        3 => 'Completed',
        4 => 'Declined',
    ];

    // Update order status and related dates
    if ($request->order_status == 0) {
        $order->order_status = 0;
    } elseif ($request->order_status == 1) {
        $order->order_status = 1;
        $order->order_approval_date = date('Y-m-d');
    } elseif ($request->order_status == 2) {
        $order->order_status = 2;
        $order->order_delivered_date = date('Y-m-d');
    } elseif ($request->order_status == 3) {
        $order->order_status = 3;
        $order->order_completed_date = date('Y-m-d');
    } elseif ($request->order_status == 4) {
        $order->order_status = 4;
        $order->order_declined_date = date('Y-m-d');
    }

    // Update payment status and date if necessary
    if ($request->payment_status == 0) {
        $order->payment_status = 0;
    } elseif ($request->payment_status == 1) {
        $order->payment_status = 1;
        $order->payment_approval_date = date('Y-m-d');
    }

    $order->save();

    // Get customer name and email from user, guest or fallback to order fields
    $customerName = optional($order->user)->name ?? optional($order->guest)->name ?? $order->customer_name ?? 'Customer';
    $email = optional($order->user)->email ?? optional($order->guest)->email ?? $order->customer_email;

    $statusLabel = $statusLabels[$order->order_status] ?? 'Unknown';

    if ($email) {
        try {
            Mail::to($email)->send(new OrderStatusUpdatedMail($order, $statusLabel, $customerName));
            Log::info("Order status email sent successfully", [
                'order_id' => $order->id,
                'email' => $email,
                'new_status' => $statusLabel
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to send order status email", [
                'order_id' => $order->id,
                'email' => $email,
                'new_status' => $statusLabel,
                'error' => $e->getMessage(),
            ]);
        }
    } else {
        Log::warning("No customer email found to send order status update", [
            'order_id' => $order->id,
        ]);
    }

    $notification = trans('admin_validation.Order Status Updated successfully');
    $notification = ['messege' => $notification, 'alert-type' => 'success'];

    return redirect()->back()->with($notification);
}

    public function destroy($id){
        $order = Order::find($id);
        $order->delete();
        $orderProducts = OrderProduct::where('order_id',$id)->get();
        $orderAddress = OrderAddress::where('order_id',$id)->first();
        OrderAddress::where('order_id',$id)->delete();

        $notification = trans('admin_validation.Delete successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.all-order')->with($notification);
    }

    public function reservation(){
        $reservations = Reservation::with('user')->orderBy('id','desc')->get();

        return view('admin.reservation', compact('reservations'));
    }

    public function update_reservation_status(Request $request, $id){

        $reservation = Reservation::find($id);
        $reservation->reserve_status = $request->reserve_status;
        $reservation->save();

        $notification = trans('admin_validation.Status updated successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function delete_reservation($id){

        $reservation = Reservation::find($id);
        $reservation->delete();

        $notification = trans('admin_validation.Deleted successfully');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
    
    
    



}
