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

        // twilio | cloud | none
        $driver = strtolower($cleanupEnv(env('WHATSAPP_DRIVER')) ?: 'twilio');

        $toNumber = $cleanupEnv(env('WHATSAPP_ADMIN_NUMBER')) ?: $cleanupEnv(env('MY_WHATSAPP_NUMBER'));
        if (!$toNumber) {
            \Log::warning('WhatsApp notification skipped (missing destination number)', [
                'driver' => $driver,
            ]);
            return;
        }

        if ($driver === 'none') {
            \Log::info('WhatsApp notifications disabled (WHATSAPP_DRIVER=none)');
            return;
        }

        // Meta WhatsApp Cloud API (no Twilio), via Graph API.
        // Env:
        // - WHATSAPP_DRIVER=cloud
        // - WHATSAPP_CLOUD_TOKEN=...
        // - WHATSAPP_CLOUD_PHONE_NUMBER_ID=...
        // - WHATSAPP_CLOUD_API_VERSION=v19.0 (optional)
        // - WHATSAPP_ADMIN_NUMBER=whatsapp:+15551234567 (or +15551234567)
        if ($driver === 'cloud') {
            $token = $cleanupEnv(env('WHATSAPP_CLOUD_TOKEN'));
            $phoneNumberId = $cleanupEnv(env('WHATSAPP_CLOUD_PHONE_NUMBER_ID'));
            $apiVersion = $cleanupEnv(env('WHATSAPP_CLOUD_API_VERSION')) ?: 'v19.0';

            if (!$token || !$phoneNumberId) {
                \Log::warning('WhatsApp Cloud API skipped (missing env)', [
                    'has_token' => (bool) $token,
                    'has_phone_number_id' => (bool) $phoneNumberId,
                ]);
                return;
            }

            $normalizeTo = function (string $value): string {
                $value = trim($value);
                $value = str_replace('whatsapp:', '', $value);
                return preg_replace('/\D+/', '', $value);
            };

            $to = $normalizeTo($toNumber);
            if (!$to) {
                \Log::warning('WhatsApp Cloud API skipped (invalid destination number)', [
                    'to' => $toNumber,
                ]);
                return;
            }

            $url = "https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages";

            try {
                $http = new \GuzzleHttp\Client([
                    'timeout' => 15,
                    'connect_timeout' => 10,
                ]);

                $res = $http->post($url, [
                    'headers' => [
                        'Authorization' => "Bearer {$token}",
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'messaging_product' => 'whatsapp',
                        'to' => $to,
                        'type' => 'text',
                        'text' => [
                            'preview_url' => false,
                            'body' => $message,
                        ],
                    ],
                ]);

                $body = (string) $res->getBody();
                $decoded = json_decode($body, true);
                $messageId = $decoded['messages'][0]['id'] ?? null;

                \Log::info('WhatsApp order notification sent successfully (Cloud API)', [
                    'to' => $to,
                    'message_id' => $messageId,
                    'http_status' => $res->getStatusCode(),
                ]);
            } catch (\Throwable $e) {
                \Log::error('Failed to send WhatsApp order notification (Cloud API)', [
                    'to' => $to,
                    'exception' => $e,
                ]);
            }

            return;
        }

        // Default: Twilio WhatsApp
        $sid = $cleanupEnv(env('TWILIO_SID'));
        $token = $cleanupEnv(env('TWILIO_AUTH_TOKEN'));
        $twilioNumber = $cleanupEnv(env('TWILIO_WHATSAPP_NUMBER'));

        if (!$sid || !$token || !$twilioNumber) {
            \Log::warning('WhatsApp notification skipped (missing Twilio env)', [
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

            \Log::info('WhatsApp order notification sent successfully (Twilio)', [
                'to' => $toNumber,
                'from' => $twilioNumber,
                'sid' => $msg->sid ?? null,
                'status' => $msg->status ?? null,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to send WhatsApp order notification (Twilio): ' . $e->getMessage());
        }
    }
}

