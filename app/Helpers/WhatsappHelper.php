<?php

use Twilio\Rest\Client;

if (!function_exists('sendWhatsAppOrderNotification')) {
    function sendWhatsAppOrderNotification($message)
    {
        $cleanupEnv = function (?string $value): ?string {
            if ($value === null) {
                return null;
            }
            $value = trim($value);
            $value = preg_split('/\s+#/', $value, 2)[0];
            return trim($value);
        };

        $sid = $cleanupEnv(env('TWILIO_SID'));
        $token = $cleanupEnv(env('TWILIO_AUTH_TOKEN'));
        $twilioNumber = $cleanupEnv(env('TWILIO_WHATSAPP_NUMBER'));
        $toNumber = $cleanupEnv(env('WHATSAPP_ADMIN_NUMBER')) ?: $cleanupEnv(env('MY_WHATSAPP_NUMBER'));

        if (!$sid || !$token || !$twilioNumber || !$toNumber) {
            \Log::warning('⚠️ WhatsApp notification skipped (missing Twilio env)', [
                'has_sid' => (bool) $sid,
                'has_token' => (bool) $token,
                'has_from' => (bool) $twilioNumber,
                'has_to' => (bool) $toNumber,
            ]);
            return;
        }

        $client = new Client($sid, $token);

        try {
            $msg = $client->messages->create($toNumber, [
                'from' => $twilioNumber,
                'body' => $message,
            ]);

            \Log::info('✅ WhatsApp order notification sent successfully.', [
                'to' => $toNumber,
                'from' => $twilioNumber,
                'sid' => $msg->sid ?? null,
                'status' => $msg->status ?? null,
            ]);
        } catch (\Exception $e) {
            \Log::error('❌ Failed to send WhatsApp order notification: ' . $e->getMessage());
        }
    }
}
