<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FcmService
{
    public static function send(string $token, string $title, string $body, array $data = [])
    {
        $serverKey = config('services.fcm.server_key'); // from .env via config/services.php
        if (empty($serverKey) || empty($token)) {
            return false;
        }

        $url = 'https://fcm.googleapis.com/fcm/send';

        return Http::withHeaders([
            'Authorization' => 'key=' . $serverKey,
            'Content-Type'  => 'application/json',
        ])->post($url, [
            'to'           => $token,
            'notification' => [
                'title' => $title,
                'body'  => $body,
                'sound' => 'default',
            ],
            'data' => array_merge([
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ], $data),
        ])->json();
    }
}
