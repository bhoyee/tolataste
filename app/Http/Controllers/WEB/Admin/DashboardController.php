<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Vendor;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Admin;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashobard(){

        $today_orders = Order::orderBy('id','desc')->whereDay('created_at', now()->day)->get();
        $today_total_earning = $today_orders->where('payment_status',1)->sum('grand_total');

        $monthly_orders = Order::orderBy('id','desc')->whereMonth('created_at', now()->month)->get();
        $monthly_total_earning = $monthly_orders->where('payment_status',1)->sum('grand_total');

        $yearly_orders = Order::orderBy('id','desc')->whereYear('created_at', now()->year)->get();
        $yearly_total_earning = number_format(
    $yearly_orders->where('payment_status', 1)->sum('grand_total'), 
    2, 
    '.', 
    ''
);

        $total_orders = Order::orderBy('id','desc')->get();
        $total_earning = number_format(
    $total_orders->where('payment_status', 1)->sum('grand_total'), 
    2, 
    '.', 
    ''
);

        $total_users = User::count();
        $total_blog = Blog::count();
        $total_admin = Admin::count();
        $total_subscriber = Subscriber::where('is_verified',1)->count();

        return view('admin.dashboard')->with([
            'today_orders' => $today_orders,
            'today_total_earning' => $today_total_earning,
            'monthly_orders' => $monthly_orders,
            'monthly_total_earning' => $monthly_total_earning,
            'yearly_orders' => $yearly_orders,
            'yearly_total_earning' => $yearly_total_earning,
            'total_orders' => $total_orders,
            'total_earning' => $total_earning,
            'total_users' => $total_users,
            'total_blog' => $total_blog,
            'total_admin' => $total_admin,
            'total_subscriber' => $total_subscriber,
        ]);

    }
    
// DashboardController.php

public function getDashboardStats()
{
    return response()->json([
        'today_orders' => Order::today()->count(),
        'today_total_earning' => number_format(Order::today()->sum('grand_total'), 2, '.', ''),
        'monthly_orders' => Order::thisMonth()->count(),
        'monthly_total_earning' => number_format(Order::thisMonth()->sum('grand_total'), 2, '.', ''),
        'yearly_orders' => Order::thisYear()->count(),
        'yearly_total_earning' => number_format(Order::thisYear()->sum('grand_total'), 2, '.', ''),
        'total_orders' => Order::count(),
        'total_earning' => number_format(Order::sum('grand_total'), 2, '.', ''),
        'total_users' => User::count(),
        'total_admin' => Admin::count(),
        'total_subscriber' => Subscriber::count(),
    ]);
}

public function todayOrdersHtml()
{
    $orders = Order::today()->where('order_status', 0)->get();
    $currency = config('settings.currency_icon', '$');

    $tableRows = '';
    $modals = '';

    foreach ($orders as $index => $order) {
        $tableRows .= '<tr>';
        $tableRows .= '<td>' . ($index + 1) . '</td>';
      if ($order->user_id && $order->user) {
    $customerName = $order->user->name;
} elseif ($order->guest) {
    $customerName = '<span class="text-muted">' . $order->guest->name . ' (Guest)</span>';
} else {
    $customerName = '<span class="text-danger">Unknown</span>';
}
$tableRows .= '<td>' . $customerName . '</td>';

        $tableRows .= '<td>' . $order->order_id . '</td>';
        $tableRows .= '<td>' . $order->created_at->format('d F, Y') . '</td>';
        $tableRows .= '<td>' . $order->product_qty . '</td>';
        $tableRows .= '<td>' . $currency . $order->grand_total . '</td>';
        $tableRows .= '<td><span class="badge badge-' . ($order->is_preorder ? 'info' : 'secondary') . '">' . ($order->is_preorder ? 'Yes' : 'No') . '</span></td>';
        $tableRows .= '<td><span class="badge badge-' . ($order->order_status == 0 ? 'danger' : 'success') . '">' . ($order->order_status == 0 ? 'Pending' : 'In Progress') . '</span></td>';
        $tableRows .= '<td><span class="badge badge-' . ($order->payment_status == 1 ? 'success' : 'danger') . '">' . ($order->payment_status == 1 ? 'Success' : 'Pending') . '</span></td>';
        $tableRows .= '<td>
            <a href="' . route('admin.order-show', $order->id) . '" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
            <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger btn-sm" onclick="deleteData(' . $order->id . ')"><i class="fa fa-trash"></i></a>
            <a href="javascript:;" data-toggle="modal" data-target="#orderModalId-' . $order->id . '" class="btn btn-warning btn-sm"><i class="fas fa-truck"></i></a>
        </td>';
        $tableRows .= '</tr>';

        $modals .= '<div class="modal fade" id="orderModalId-' . $order->id . '" tabindex="-1" role="dialog" aria-hidden="true">';
        $modals .= '  <div class="modal-dialog" role="document">';
        $modals .= '    <form action="' . route('admin.update-order-status', $order->id) . '" method="POST">';
        $modals .= '    ' . csrf_field() . method_field('PUT');
        $modals .= '      <div class="modal-content">';
        $modals .= '        <div class="modal-header">';
        $modals .= '          <h5 class="modal-title">Order Status</h5>';
        $modals .= '          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>';
        $modals .= '        </div>';
        $modals .= '        <div class="modal-body">';
        $modals .= '          <div class="form-group">';
        $modals .= '            <label>Payment</label>';
        $modals .= '            <select name="payment_status" class="form-control">';
        $modals .= '              <option value="0"' . ($order->payment_status == 0 ? ' selected' : '') . '>Pending</option>';
        $modals .= '              <option value="1"' . ($order->payment_status == 1 ? ' selected' : '') . '>Success</option>';
        $modals .= '            </select>';
        $modals .= '          </div>';
        $modals .= '          <div class="form-group">';
        $modals .= '            <label>Order</label>';
        $modals .= '            <select name="order_status" class="form-control">';
        $modals .= '              <option value="0"' . ($order->order_status == 0 ? ' selected' : '') . '>Pending</option>';
        $modals .= '              <option value="1"' . ($order->order_status == 1 ? ' selected' : '') . '>In Progress</option>';
        $modals .= '              <option value="2"' . ($order->order_status == 2 ? ' selected' : '') . '>Delivered</option>';
        $modals .= '              <option value="3"' . ($order->order_status == 3 ? ' selected' : '') . '>Completed</option>';
        $modals .= '              <option value="4"' . ($order->order_status == 4 ? ' selected' : '') . '>Declined</option>';
        $modals .= '            </select>';
        $modals .= '          </div>';
        $modals .= '        </div>';
        $modals .= '        <div class="modal-footer">';
        $modals .= '          <button type="submit" class="btn btn-primary">Update Status</button>';
        $modals .= '          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
        $modals .= '        </div>';
        $modals .= '      </div>';
        $modals .= '    </form>';
        $modals .= '  </div>';
        $modals .= '</div>';
    }

    return response()->json([
        'tableRows' => $tableRows,
        'modals' => $modals
    ]);
}

}
