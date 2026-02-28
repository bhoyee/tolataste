<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DeliverySetting;

class DeliverySettingController extends Controller
{
    public function edit()
    {
        $deliverySetting = DeliverySetting::first();

        // If no record exists, create one with default values
        if (!$deliverySetting) {
            $deliverySetting = DeliverySetting::create([
                'base_fee_per_mile' => 0,
                'mid_fee_per_mile' => 0,
                'long_fee_per_mile' => 0,
            ]);
        }

        return view('admin.delivery_settings.edit', compact('deliverySetting'));
    }

    public function update(Request $request)
    {
        // ✅ Updated validation for new per-mile fields
        $request->validate([
            'base_fee_per_mile' => 'required|numeric|min:0',
            'mid_fee_per_mile' => 'required|numeric|min:0',
            'long_fee_per_mile' => 'required|numeric|min:0',
        ]);

        $deliverySetting = DeliverySetting::first();

        if (!$deliverySetting) {
            $deliverySetting = new DeliverySetting();
        }

        // ✅ Assign per-mile values
        $deliverySetting->base_fee_per_mile = $request->base_fee_per_mile;
        $deliverySetting->mid_fee_per_mile = $request->mid_fee_per_mile;
        $deliverySetting->long_fee_per_mile = $request->long_fee_per_mile;
        $deliverySetting->save();

        return back()->with('success', 'Delivery settings updated successfully.');
    }
}
