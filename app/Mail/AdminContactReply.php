<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminContactReply extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $replyMessage;
    public $userMessage; // ✅ New property

    public function __construct($name, $replyMessage, $userMessage)
    {
        $this->name = $name;
        $this->replyMessage = $replyMessage;
        $this->userMessage = $userMessage; // ✅ Assign the user’s original message
    }

    public function build()
    {
        return $this->subject('Reply to your message')
                    ->view('emails.admin_contact_reply')
                    ->with([
                        'name' => $this->name,
                        'replyMessage' => $this->replyMessage,
                        'userMessage' => $this->userMessage, // ✅ Pass it to the view
                    ]);
    }
}
