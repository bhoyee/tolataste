<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        try {
            return [
                'id' => $this->id,
                'order_status' => $this->order_status,
                'payment_status' => $this->payment_status,
                'order_type' => $this->order_type,
                'customer_name' => optional($this->user)->name ?? optional($this->guest)->name ?? 'Guest',
                'created_at' => optional($this->created_at)->toDateTimeString(),
            ];
        } catch (\Throwable $e) {
            Log::error('Error in OrderResource transformation', [
                'order_id' => $this->id ?? null,
                'error' => $e->getMessage(),
            ]);
            return [];
        }
    }
}
