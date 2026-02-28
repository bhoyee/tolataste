<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class MobileMiscController extends Controller
{
    /**
     * Save FCM token for the (single) admin using a pre-shared key.
     * POST /api/save-admin-token
     * body: { "token": "...", "key": "APP_PSK value" }
     */
    public function saveAdminFcmToken(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'key'   => 'required|string',
            ]);

            // Verify PSK
            if ($request->key !== config('services.app_psk')) {
                Log::warning('saveAdminFcmToken: invalid PSK provided');
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized.',
                ], 401);
            }

            // Fetch your single admin (or pick by email/id if you prefer)
            $admin = Admin::orderBy('id')->first();

            if (!$admin) {
                Log::error('saveAdminFcmToken: no admin found to attach token');
                return response()->json([
                    'success' => false,
                    'message' => 'Admin not found.',
                ], 404);
            }

            $admin->fcm_token = $request->token;
            $admin->save();

            Log::info('saveAdminFcmToken: token saved for admin_id='.$admin->id);

            return response()->json([
                'success' => true,
                'message' => 'Token saved.',
            ]);
        } catch (\Throwable $e) {
            Log::error('saveAdminFcmToken failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to save token.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
