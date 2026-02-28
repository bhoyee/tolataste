<?php

use Illuminate\Support\Facades\Log;

function sendFcmNotification($token, $title, $body)
{
    $serverKey = env('FCM_SERVER_KEY');

    $data = [
        "to" => $token,
        "notification" => [
            "title" => $title,
            "body" => $body,
            "sound" => "default"
        ],
        "priority" => "high"
    ];

    $headers = [
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $result = curl_exec($ch);
    curl_close($ch);

    Log::info('📩 FCM Test Notification Sent', ['response' => $result]);

    return $result;
}
