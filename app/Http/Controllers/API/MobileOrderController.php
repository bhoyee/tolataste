<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;

class MobileOrderController extends Controller
{
 
    
    public function activeOrders(Request $request)
    {
        try {
            \Log::info('Fetching active orders');
    
            // Show all pending (0) and in-progress (1) orders regardless of date
            $orders = Order::with(['user:id,name', 'guest:id,name'])
                ->whereIn('order_status', [0, 1])
                ->orderBy('created_at', 'desc')
                ->get();
    
            $data = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_id' => $order->order_id, // Optional: for backward compatibility with old keys
                    'status' => $this->getStatusText($order->order_status), // Return as string
                    'payment_status' => $order->payment_status,
                    'order_type' => $order->order_type,
                    'customer_name' => optional($order->user)->name ?? optional($order->guest)->name ?? 'Guest',
                    'created_at' => $order->created_at->toDateTimeString(),
                ];
            });
    
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            \Log::error('Active Orders Fetch Failed: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    
            return response()->json([
                'success' => false,
                'message' => 'Error fetching orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Convert numeric order status to readable string
     */
    private function getStatusText($status)
    {
        return match ((int) $status) {
            0 => 'Pending',
            1 => 'In Progress',
            2 => 'Delivered',
            3 => 'Completed',
            4 => 'Declined',
            default => 'Unknown',
        };
    }
    
 
    public function orderDetailByOrderId($order_id)
    {
        try {
            $order = Order::with(['user:id,name,email', 'guest:id,name,email', 'orderProducts', 'orderAddress'])
                ->where('order_id', $order_id)
                ->firstOrFail();
    
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $order->id,
                    'order_id' => $order->order_id,
                    'status' => $this->getStatusText($order->order_status),
                    'payment_status' => $order->payment_status,
                    'grand_total' => $order->grand_total,
                    'order_type' => $order->order_type,
                    'customer_name' => optional($order->user)->name ?? optional($order->guest)->name ?? 'Guest',
                    'customer_email' => optional($order->user)->email ?? optional($order->guest)->email ?? '',
                    'created_at' => $order->created_at->toDateTimeString(),
                    'products' => $order->orderProducts->map(function ($product) {
                        return [
                            'name' => $product->product_name ?? 'N/A',
                            'quantity' => $product->qty,
                            'price' => $product->price,
                            'food_instruction' => $product->food_instruction,
                        ];
                    }),
                    'address' => $order->orderAddress ? [
                        'street' => $order->orderAddress->street ?? '',
                        'city' => $order->orderAddress->city ?? '',
                        'state' => $order->orderAddress->state ?? '',
                        'zip' => $order->orderAddress->postal_code ?? '',
                    ] : null
                ]
            ]);
        } catch (\Throwable $e) {
            \Log::error('Order Detail Fetch Failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    // Route: POST /api/update-status
    
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'status' => 'required|in:pending,in_progress,delivered,completed,declined',
        ]);
    
        $statusMap = [
            'pending' => 0,
            'in_progress' => 1,
            'delivered' => 2,
            'completed' => 3,
            'declined' => 4,
        ];
    
        $order = Order::with(['user', 'guest'])->where('order_id', $request->order_id)->first(); // ✅ eager load user & guest
    
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }
    
        $order->order_status = $statusMap[$request->status];
        $order->save();
    
        // ✅ Get customer name and email
        $customerName = optional($order->user)->name ?? optional($order->guest)->name ?? 'Guest';
        $email = optional($order->user)->email ?? optional($order->guest)->email ?? $order->customer_email;
    
        if ($email) {
            Mail::to($email)->send(new OrderStatusUpdatedMail($order, strtoupper($request->status), $customerName));
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully.',
            'data' => [
                'order_id' => $order->order_id,
                'new_status' => $order->order_status,
            ],
        ]);
    }

}
