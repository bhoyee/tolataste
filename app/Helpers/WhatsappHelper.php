<?php

use Twilio\Rest\Client;

if (!function_exists('sendWhatsAppOrderNotification')) {
    function sendWhatsAppOrderNotification($message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_WHATSAPP_NUMBER');
        $myNumber = env('MY_WHATSAPP_NUMBER');

        $client = new Client($sid, $token);

        try {
            $client->messages->create(
                $myNumber, // Your WhatsApp
                [
                    'from' => $twilioNumber,
                    'body' => $message,
                ]
            );

            \Log::info('✅ WhatsApp order notification sent successfully.');
        } catch (\Exception $e) {
            \Log::error('❌ Failed to send WhatsApp order notification: ' . $e->getMessage());
        }
    }
}
