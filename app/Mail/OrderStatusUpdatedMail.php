<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $statusLabel;
    public $customerName; // ✅ Add this

    public function __construct($order, $statusLabel, $customerName)
    {
        $this->order = $order;
        $this->statusLabel = $statusLabel;
        $this->customerName = $customerName; // ✅ Save name
    }

    public function build()
    {
        return $this->subject('Your Order Status Has Been Updated')
                    ->view('emails.order_status_updated')
                    ->with([
                        'order' => $this->order,
                        'statusLabel' => $this->statusLabel,
                        'customerName' => $this->customerName, // ✅ Pass it to view
                    ]);
    }
}
