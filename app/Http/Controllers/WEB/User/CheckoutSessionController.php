<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class CheckoutSessionController extends Controller
{
    public function save(Request $request)
    {
        Session::put('sub_total', $request->sub_total);
        Session::put('final_total', $request->grand_total);
        Session::put('calculated_tax', $request->tax);
        Session::put('delivery_charge', $request->delivery_charge);
        Session::put('coupon_price', $request->coupon_price);
        Session::put('tip_amount', $request->input('tip_amount', 0));


        return response()->json(['status' => 'success']);
    }
}
