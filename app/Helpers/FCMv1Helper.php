<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FCMv1Helper
{
    public static function sendNotification($token, $title, $body, $orderId = null)
    {
        $projectId = config('services.fcm.project_id');
        $jsonKeyPath = '/home/tolatast/public_html/tolatasteapp-18679f87a31b.json';

        if (!file_exists($jsonKeyPath)) {
            \Log::error('FCMv1Helper: JSON key file not found');
            return false;
        }

        $client = new \Google\Client();
        $client->setAuthConfig($jsonKeyPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $accessToken = $client->fetchAccessTokenWithAssertion()['access_token'];

        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $response = Http::withToken($accessToken)->post($url, [
            'message' => [
                'token' => $token,
                'notification' => [ // ✅ this shows notifications on Android & iOS background
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => [ // ✅ this is for Flutter foreground handling
                    'title' => $title,
                    'body' => $body,
                    'order_id' => (string) ($orderId ?? '0'),
                ],
                'android' => [
                    'priority' => 'high',
                    'notification' => [
                        'sound' => 'default',
                    ],
                ],
                'apns' => [
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                    'payload' => [
                        'aps' => [
                            'sound' => 'default',
                        ],
                    ],
                ],
            ]

        ]);

        \Log::info('📦 FCMv1 Response', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return $response->json();
    }
}
