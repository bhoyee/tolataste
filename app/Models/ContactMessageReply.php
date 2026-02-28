<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessageReply extends Model
{
    protected $fillable = ['contact_message_id', 'reply'];

    public function contactMessage()
    {
        return $this->belongsTo(ContactMessage::class);
    }
}
