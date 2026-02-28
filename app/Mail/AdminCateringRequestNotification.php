<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\CateringRequest;

class AdminCateringRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $catering;

    public function __construct(CateringRequest $catering)
    {
        $this->catering = $catering;
    }

    public function build()
    {
        return $this->subject('New Catering Request Received')
                    ->view('emails.catering-request'); // ✅ Make sure this Blade view exists
    }
}
