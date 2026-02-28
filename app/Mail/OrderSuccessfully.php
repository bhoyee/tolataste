<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderSuccessfully extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;
    public $subject;
    public $viewTemplate;
    public $payment_status;

    /**
     * Create a new message instance.
     *
     * @param mixed $order
     * @param mixed $user
     * @param string $subject
     * @param string $viewTemplate
     * @param string|null $payment_status
     */
    public function __construct($order, $user, $subject, $viewTemplate = 'user.order_email_template', $payment_status = null)
    {
        $this->order = $order;
        $this->user = $user;
        $this->subject = $subject;
        $this->viewTemplate = $viewTemplate;
        $this->payment_status = $payment_status;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view($this->viewTemplate)
                    ->with([
                        'order' => $this->order,
                        'user' => $this->user,
                        'payment_status' => $this->payment_status,
                    ]);
    }
}
