<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Log;


class BulkSmsHelper
{
    public static function send($to, $message)
    {
        $username = config('services.bulksms.username');
        $password = config('services.bulksms.password');

        $url = 'https://api.bulksms.com/v1/messages?auto-unicode=true&longMessageMaxParts=30';

        $messages = [
            [
                'to' => $to,
                'body' => $message,
            ]
        ];

        $post_body = json_encode($messages);
        $headers = [
            'Content-Type:application/json',
            'Authorization:Basic ' . base64_encode("$username:$password")
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $server_response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($http_status !== 201) {
            \Log::error("📵 BulkSMS error: HTTP $http_status - $error - Response: $server_response");
            return false;
        }

        \Log::info("📲 BulkSMS sent successfully. Response: $server_response");
        return true;
    }
}
