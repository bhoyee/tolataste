<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestCheckoutController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required',
        ]);

        session([
            'guest_user' => [
                'name' => $request->guest_name,
                'email' => $request->guest_email,
                'phone' => $request->guest_phone,
            ]
        ]);

        return response()->json(['success' => true, 'redirect_url' => route('checkout')]);
    }

}
