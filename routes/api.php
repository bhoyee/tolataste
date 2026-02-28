<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\MobileOrderController;
use App\Http\Controllers\API\MobileMiscController;

Route::post('/admin-login', [AdminAuthController::class, 'login']);


Route::get('/orders', [MobileOrderController::class, 'activeOrders']);

Route::get('/orders-by-order-id/{order_id}', [MobileOrderController::class, 'orderDetailByOrderId']);

Route::post('/update-status', [MobileOrderController::class, 'updateOrderStatus']);

Route::post('/save-admin-token', [MobileMiscController::class, 'saveAdminFcmToken']);


Route::post('/save-fcm-direct', function (Illuminate\Http\Request $request) {
    $adminId = $request->admin_id;
    $token = $request->fcm_token;

    if (!$adminId || !$token) {
        return response()->json(['message' => 'Missing parameters'], 400);
    }

    $admin = \App\Models\Admin::find($adminId);
    if (!$admin) {
        return response()->json(['message' => 'Admin not found'], 404);
    }

    $admin->fcm_token = $token;
    $admin->save();

    return response()->json(['message' => 'Token saved successfully']);
});






