<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReservationNotification;


class SendReservationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
 

    public $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function handle()
    {
        $to = config('mail.admin_address'); // pulls from config (safe with caching)
        \Log::info("📧 Sending reservation email to: " . $to); // optional: log for debug
    
        Mail::to($to)->send(new AdminReservationNotification($this->reservation));
    }

    /**
     * Execute the job.
     *
     * @return void
     */

}
