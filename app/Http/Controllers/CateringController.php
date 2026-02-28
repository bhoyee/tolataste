<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CateringRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App; // ✅ ADD THIS LINE
use App\Mail\AdminCateringRequestNotification;

class CateringController extends Controller
{
    public function index()
    {
        return view('catering');
    }
    
     public function submit(Request $request)
    {
           // 🧠 Rate limit per IP
    $ip = $request->ip();
    $key = 'contact_form_' . $ip;

    if (cache()->has($key)) {
        return redirect()->back()->withErrors(['error' => 'Please wait a minute before submitting again.'])->withInput();
    }

    cache()->put($key, true, now()->addMinutes(1)); // Block resubmissions for 1 min

    // 🕳️ Honeypot field check
    if ($request->filled('website')) {
        \Log::warning('🚫 Spam detected via honeypot.', ['ip' => $ip]);
        return redirect()->back()->withErrors(['error' => 'Spam detected.'])->withInput();
    }
        $data = $request->validate([
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'delivery_address' => 'required',
            'event_date' => 'required|date',
            'catering_type' => 'required',
            'guest_count' => 'required|integer',
            'menu_items' => 'required|string',
            'occasion' => 'nullable|string',
            'event_start_time' => 'nullable',
            'dropoff_time' => 'nullable',
        ]);

        $catering = CateringRequest::create($data);

        $response = back()->with('success', 'Your catering request has been submitted successfully!');

        App::terminating(function () use ($catering) {
            // ✅ Send email to admin
            Mail::to(config('mail.admin_address', 'support@tolatasteofafrica.com'))
                ->send(new AdminCateringRequestNotification($catering));
        
            // ✅ Send WhatsApp message (only essential info)
            $message = "🍽️ *New Catering Request*\n\n"
                . "*Name:* {$catering->full_name}\n"
                . "*Phone:* {$catering->phone}\n"
                . "*Date:* {$catering->event_date}\n"
                . "*Guests:* {$catering->guest_count}\n"
                . "*Catering Type:* {$catering->catering_type}\n\n"
                . "📍 *Address:* {$catering->delivery_address}\n"
                . "👉 Please check your dashboard.";
        
            sendWhatsAppOrderNotification($message);
        });
        

        return $response;
    }

    // public function submit(Request $request)
    // {
    //     $data = $request->validate([
    //         'full_name' => 'required',
    //         'email' => 'required|email',
    //         'phone' => 'required',
    //         'delivery_address' => 'required',
    //         'event_date' => 'required|date',
    //         'catering_type' => 'required',
    //         'guest_count' => 'required|integer',
    //         'menu_items' => 'required|string',
    //         'occasion' => 'nullable|string',
    //         'event_start_time' => 'nullable',
    //         'dropoff_time' => 'nullable',
    //     ]);

    //     $catering = CateringRequest::create($data);

    //     $response = back()->with('success', 'Your catering request has been submitted successfully!');

    //     App::terminating(function () use ($catering) {
    //         Mail::to(config('mail.admin_address', 'admin@example.com'))
    //             ->send(new AdminCateringRequestNotification($catering));
    //     });

    //     return $response;
    // }
}
