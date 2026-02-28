<?php

namespace App\Jobs;

use App\Helpers\MailHelper;
use App\Models\Guest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderPlacedNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $orderId;
    public ?int $userId;
    public ?array $guest;
    public string $paymentMethod;
    public int $paymentStatus;

    public function __construct(int $orderId, ?int $userId, ?array $guest, string $paymentMethod, int $paymentStatus)
    {
        $this->orderId = $orderId;
        $this->userId = $userId;
        $this->guest = $guest;
        $this->paymentMethod = $paymentMethod;
        $this->paymentStatus = $paymentStatus;
    }

    public function handle(): void
    {
        Log::info('📨 SendOrderPlacedNotifications started', [
            'order_id' => $this->orderId,
            'user_id' => $this->userId,
            'payment_method' => $this->paymentMethod,
            'payment_status' => $this->paymentStatus,
        ]);

        $order = Order::find($this->orderId);
        if (!$order) {
            Log::error('📨 SendOrderPlacedNotifications: order not found', ['order_id' => $this->orderId]);
            return;
        }

        $user = null;
        if ($this->userId) {
            $user = User::find($this->userId);
        } elseif (!empty($order->guest_id)) {
            $user = Guest::find($order->guest_id);
        } elseif (!empty($this->guest)) {
            $user = (object) [
                'id' => null,
                'name' => $this->guest['name'] ?? 'Guest',
                'email' => $this->guest['email'] ?? null,
                'phone' => $this->guest['phone'] ?? '',
            ];
        }

        $emailTo = $user?->email ?? null;
        $phoneTo = $user?->phone ?? null;

        try {
            MailHelper::setMailConfig();
        } catch (\Throwable $e) {
            Log::error('📨 Mail config setup failed', ['exception' => $e]);
        }

        $paymentStatusText = $this->paymentStatus === 1 ? 'Success' : 'Pending';
        $userSubject = "✅ Order Confirmation - #{$order->order_id}";
        $adminSubject = "📩 New Order Placed - #{$order->order_id}";

        if ($emailTo) {
            try {
                Mail::to($emailTo)->send(new \App\Mail\OrderSuccessfully(
                    $order,
                    $user,
                    $userSubject,
                    'user.order_email_template'
                ));
                Log::info('📨 User order email sent', ['to' => $emailTo, 'order_id' => $order->id]);
            } catch (\Throwable $e) {
                Log::error('📨 User email send failed', ['to' => $emailTo, 'order_id' => $order->id, 'exception' => $e]);
            }
        } else {
            Log::warning('📨 User email missing; skipping', ['order_id' => $order->id]);
        }

        $adminEmail = config('mail.admin_address') ?: env('MAIL_ADMIN_ADDRESS');
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new \App\Mail\OrderSuccessfully(
                    $order,
                    $user,
                    $adminSubject,
                    'admin.order_email_template',
                    $paymentStatusText
                ));
                Log::info('📨 Admin order email sent', ['to' => $adminEmail, 'order_id' => $order->id]);
            } catch (\Throwable $e) {
                Log::error('📨 Admin email send failed', ['to' => $adminEmail, 'order_id' => $order->id, 'exception' => $e]);
            }
        } else {
            Log::warning('📨 Admin email missing; skipping', ['order_id' => $order->id]);
        }

        $adminMessage = "🛒 New Order Placed\n"
            . "Order ID: {$order->order_id}\n"
            . "Name: " . ($user?->name ?? 'Guest') . "\n"
            . "Phone: " . ($user?->phone ?? '') . "\n"
            . "Amount: {$order->grand_total}\n"
            . "Payment: {$this->paymentMethod} ({$paymentStatusText})";

        if (function_exists('sendWhatsAppOrderNotification')) {
            try {
                sendWhatsAppOrderNotification($adminMessage);
            } catch (\Throwable $e) {
                Log::error('📨 WhatsApp notification failed', ['order_id' => $order->id, 'exception' => $e]);
            }
        } else {
            Log::warning('📨 WhatsApp helper missing; skipping', ['order_id' => $order->id]);
        }

        try {
            $formatPhone = function (?string $number, string $cc = '+1'): ?string {
                if (!$number) {
                    return null;
                }
                return preg_match('/^\\+/', $number)
                    ? $number
                    : $cc . preg_replace('/\\D+/', '', $number);
            };

            if (!empty($phoneTo) && class_exists(\App\Helpers\BulkSmsHelper::class)) {
                $userMessage = "Hi " . ($user?->name ?? 'Customer') . ", your order #{$order->order_id} of \${$order->grand_total} has been successfully placed via {$this->paymentMethod}. Thank you!";
                \App\Helpers\BulkSmsHelper::send($formatPhone($phoneTo) ?? $phoneTo, $userMessage);
            }

            $adminPhone = env('ADMIN_PHONE') ?: '+14433253708';
            if ($adminPhone && class_exists(\App\Helpers\BulkSmsHelper::class)) {
                \App\Helpers\BulkSmsHelper::send($adminPhone, $adminMessage);
            }
        } catch (\Throwable $e) {
            Log::error('📨 SMS notification failed', ['order_id' => $order->id, 'exception' => $e]);
        }

        Log::info('📨 SendOrderPlacedNotifications finished', ['order_id' => $order->id]);
    }
}
