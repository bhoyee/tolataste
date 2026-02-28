<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderProductVariant;
use App\Models\OrderAddress;
use App\Models\Product;
use App\Models\Setting;
use App\Models\StripePayment;
use App\Mail\OrderSuccessfully;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use App\Models\RazorpayPayment;
use App\Models\Flutterwave;
use App\Models\PaystackAndMollie;
use App\Models\InstamojoPayment;
use App\Models\Coupon;
use App\Models\ProductVariantItem;
use App\Models\DeliveryArea;
use App\Models\Shipping;
use App\Models\Address;
use App\Models\SslcommerzPayment;
use App\Models\PaypalPayment;
use App\Models\ShoppingCartVariant;
use App\Models\BankPayment;
use App\Helpers\BulkSmsHelper;
use App\Services\FcmService;
use App\Models\Admin;


use Mail;
Use Stripe;
use Cart;
use Session;
use Str;
use Razorpay\Api\Api;
use Exception;
use Redirect;
use Auth;
use Stripe\PaymentIntent;
use App\Jobs\SendOrderPlacedNotifications;

use App\Helpers\FCMv1Helper;



use App\Library\SslCommerz\SslCommerzNotification;
use Mollie\Laravel\Facades\Mollie;

class PaymentController extends Controller
{
 public function __construct()
{
    $this->middleware('auth:web')->except([
        'stripe_payment', 
        'createPaymentIntent', // ✅ ADD THIS LINE
        'molliePaymentSuccess',
        'set_delivery_charge',
        'instamojoResponse',
        'sslcommerz_success',
        'sslcommerz_failed',
        'checkout',
    ]);
}



    public function checkout()
    {
        if (!auth()->check() && !session()->has('guest_user')) {
            return redirect()->route('cart')->with('error', 'Please login or continue as guest to checkout.');
        }
    
        if (Cart::count() == 0) {
            return redirect()->route('products')->with([
                'messege' => trans('user_validation.Your cart is empty!'),
                'alert-type' => 'error',
            ]);
        }
    
        // Determine if logged in user or guest
        $user = auth()->user();
    
        if (!$user && session()->has('guest_user')) {
            \Log::info('Guest Session Check at checkout', ['guest_user' => session('guest_user')]);

            $guest = session('guest_user');
    
            $user = (object)[
                'id' => null,
                'name' => $guest['name'],
                'email' => $guest['email'],
                'phone' => $guest['phone'] ?? '',
            ];
        }
    
        // Don't reassign $user here again!
        $addresses = $user->id
            ? Address::with('deliveryArea')->where('user_id', $user->id)->get()
            : collect();
    
        $cart_contents = Cart::content();
        $delivery_areas = DeliveryArea::where('status', 1)->get();
    
        $sub_total = 0;
        foreach ($cart_contents as $cart_content) {
            $qty = $cart_content->qty;
            $base_price = $cart_content->price * $qty;
            $optional_price = $cart_content->options->optional_item_price ?? 0;
            $protein_price = $cart_content->options->protein_item_price ?? 0;
            $soup_price = $cart_content->options->soup_item_price ?? 0;
            $wrap_price = $cart_content->options->wrap_item_price ?? 0;
            $drink_price = $cart_content->options->drink_item_price ?? 0;
    
            $sub_total += $base_price + $optional_price + $protein_price + $soup_price + $wrap_price + $drink_price;
        }
    
        $tax = round($sub_total * 0.06, 2);
        Session::put('calculated_tax', $tax);
    
        $stripePaymentInfo = \App\Models\StripePayment::first();
    
        return view('checkout')->with([
            'addresses' => $addresses,
            'cart_contents' => $cart_contents,
            'delivery_areas' => $delivery_areas,
            'tax' => $tax,
            'stripePaymentInfo' => $stripePaymentInfo,
        ]);
    }
    
    

    public function payment(){

        if(Cart::count() == 0){
            $notification = trans('user_validation.Your cart is empty!');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('products')->with($notification);
        }

        $user = Auth::guard('web')->user();
        $cart_contents = Cart::content();

        $stripePaymentInfo = StripePayment::first();
        $razorpayPaymentInfo = RazorpayPayment::first();
        $flutterwavePaymentInfo = Flutterwave::first();
        $paypalPaymentInfo = PaypalPayment::first();
        $bankPaymentInfo = BankPayment::first();
        $paystackAndMollie = PaystackAndMollie::first();
        $instamojo = InstamojoPayment::first();
        $sslcommerz = SslcommerzPayment::first();

        $calculate_amount = $this->calculate_amount(12);

        return view('payment')->with([
            'user' => $user,
            'cart_contents' => $cart_contents,
            'calculate_amount' => $calculate_amount,
            'bankPaymentInfo' => $bankPaymentInfo,
            'stripePaymentInfo' => $stripePaymentInfo,
            'paypalPaymentInfo' => $paypalPaymentInfo,
            'razorpayPaymentInfo' => $razorpayPaymentInfo,
            'flutterwavePaymentInfo' => $flutterwavePaymentInfo,
            'paystackAndMollie' => $paystackAndMollie,
            'instamojo' => $instamojo,
            'sslcommerz' => $sslcommerz,
        ]);
    }

    public function set_delivery_charge(Request $request)
    {
        \Log::debug('💡 set_delivery_charge called', [
            'charge' => $request->charge,
            'delivery_id' => $request->delivery_id,
            'session_user' => auth()->check() ? auth()->user()->id : 'guest'
        ]);
    
        Session::put('delivery_id', $request->delivery_id);
        Session::put('delivery_charge', $request->charge);
    
        return response()->json([
            'status' => 'success',
            'delivery_id' => $request->delivery_id,
            'charge' => $request->charge
        ]);
    }
    
    
    public function handcash_payment(){

        if(env('APP_MODE') == 0){
            $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $user = Auth::guard('web')->user();
        $cart_contents = Cart::content();

        $calculate_amount = $this->calculate_amount(7);
        $order_result = $this->orderStore($request, $user, $calculate_amount,  'Cash on Delivery', 'cash_on_delivery', 0, 1, 7);

        $this->sendOrderSuccessMail($user, $order_result, 'Cash on Delivery', 0);

        $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('dashboard')->with($notification);
    }

    public function bank_payment(Request $request){

        if(env('APP_MODE') == 0){
            $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $rules = [
            'tnx_info'=>'required'
        ];
        $customMessages = [
            'tnx_info.required' => trans('user_validation.Transaction is required')
        ];
        $this->validate($request, $rules,$customMessages);

        $user = Auth::guard('web')->user();
        $cart_contents = Cart::content();

        $calculate_amount = $this->calculate_amount(7);
        $order_result = $this->orderStore($request, $user, $calculate_amount,  'Bank Payment', $request->tnx_info, 0, 0, 7);

        $this->sendOrderSuccessMail($user, $order_result, 'Bank Payment', 0);

        $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('dashboard')->with($notification);

    }
    
    
public function createPaymentIntent(Request $request)
{
    \Log::info('💳 createPaymentIntent() called', $request->all());

    try {
        $stripe = StripePayment::firstOrFail();
        \Stripe\Stripe::setApiKey($stripe->stripe_secret);

        $tip = floatval($request->input('tip', 0));
        $baseAmount = floatval(session('final_total'));

        // Fallback calculation if session missing
        if ($baseAmount <= 0) {
            \Log::warning("⚠️ session('final_total') is missing. Running fallback calculation.");
            $calc = $this->calculate_amount(7, $tip); // assuming delivery type 7
            $baseAmount = $calc['sub_total'] ?? 0;

            // Log fallback details
            \Log::info("🔁 Fallback subtotal used: $baseAmount");
        }

        // Grand total
        $grandTotal = $baseAmount + $tip;
        $payableAmount = round($grandTotal * $stripe->currency_rate, 2);

        \Log::info('💵 Stripe Amount Calculation', [
            'tip' => $tip,
            'baseAmount' => $baseAmount,
            'grandTotal' => $grandTotal,
            'payableAmount' => $payableAmount,
            'currency_rate' => $stripe->currency_rate,
        ]);

        // Abort if amount is invalid
        if ($payableAmount <= 0) {
            \Log::error("❌ Invalid payable amount: $payableAmount");
            return response()->json([
                'message' => 'Invalid payment amount. Please refresh the page.'
            ], 400);
        }

        // Create PaymentIntent
        $intent = \Stripe\PaymentIntent::create([
            'amount' => intval($payableAmount * 100), // Convert to cents
            'currency' => $stripe->currency_code,
            'metadata' => [
                'tip' => $tip,
                'user_name' => $request->input('name', 'Guest'),
                'source' => 'Laravel Checkout',
            ],
        ]);

        \Log::info('✅ Stripe PaymentIntent created', [
            'id' => $intent->id,
            'amount' => $intent->amount,
            'client_secret' => $intent->client_secret
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret
        ], 200);

    } catch (\Exception $e) {
        \Log::error('❌ createPaymentIntent Error: ' . $e->getMessage());

        return response()->json([
            'message' => 'PaymentIntent creation failed. ' . $e->getMessage()
        ], 500);
    }
}


public function stripe_payment(Request $request)
{
    $user = Auth::guard('web')->user();

    // ✅ Handle Guest Session or Fallback
    if (!$user) {
        if (session()->has('guest_user')) {
            \Log::info('✅ Guest found via session.', ['guest_user' => session('guest_user')]);
            $guest = session('guest_user');
            $user = (object)[
                'id' => null,
                'name' => $guest['name'],
                'email' => $guest['email'],
                'phone' => $guest['phone'] ?? '',
            ];
        } elseif ($request->filled(['guest_name', 'guest_email'])) {
            \Log::info('✅ Guest fallback from request payload.');
            $user = (object)[
                'id' => null,
                'name' => $request->guest_name,
                'email' => $request->guest_email,
                'phone' => $request->guest_phone ?? '',
            ];
            session(['guest_user' => [
                'name' => $request->guest_name,
                'email' => $request->guest_email,
                'phone' => $request->guest_phone,
            ]]);
        } else {
            return redirect()->route('checkout')->with([
                'messege' => 'Guest information missing. Please restart checkout.',
                'alert-type' => 'error'
            ]);
        }
    }

    if (Cart::count() === 0) {
        return redirect()->route('cart')->with([
            'messege' => trans('user_validation.Your cart is empty!'),
            'alert-type' => 'error'
        ]);
    }

    $tip_amount = floatval($request->input('tip', 0));
    Session::put('tip_amount', $tip_amount);
    $calculate_amount = $this->calculate_amount(7, $tip_amount); // delivery type 7 assumed

    if ($calculate_amount['grand_total'] <= 0) {
        \Log::error('❌ Invalid grand_total during calculation', $calculate_amount);
        return redirect()->route('checkout')->with([
            'messege' => 'Something went wrong. Total is invalid.',
            'alert-type' => 'error'
        ]);
    }

    $stripe = StripePayment::first();
    \Stripe\Stripe::setApiKey($stripe->stripe_secret);
    $payableAmount = round($calculate_amount['grand_total'] * $stripe->currency_rate, 2);

    if ($payableAmount <= 0) {
        \Log::error('❌ Invalid payableAmount after conversion', ['amount' => $payableAmount]);
        return redirect()->route('checkout')->with([
            'messege' => 'Payment amount is invalid.',
            'alert-type' => 'error'
        ]);
    }

    // ✅ Preorder datetime fallback if needed
    if ($request->is_preorder == 0 && $request->has('flat_time_only')) {
        $today = now()->format('Y-m-d');
        $request->merge([
            'flat_datetime' => $today . ' ' . $request->flat_time_only
        ]);
    }

    // ✅ Fix flat_time_only missing format issue (extract from flat_datetime)
    if ($request->is_preorder == 1 && !$request->filled('flat_time_only') && $request->filled('flat_datetime')) {
        try {
            $parsedTime = \Carbon\Carbon::parse($request->flat_datetime)->format('H:i');
            $request->merge(['flat_time_only' => $parsedTime]);
        } catch (\Exception $e) {
            \Log::error("❌ Failed to parse flat_time_only from flat_datetime", [
                'flat_datetime' => $request->flat_datetime,
                'error' => $e->getMessage()
            ]);
        }
    }

    try {
        $paymentIntentId = $request->input('payment_intent_id');
        if (!$paymentIntentId) {
            return redirect()->route('checkout')->with([
                'messege' => 'Missing payment intent ID.',
                'alert-type' => 'error'
            ]);
        }

        $intent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
        \Log::info('📦 PaymentIntent status', ['id' => $intent->id, 'status' => $intent->status]);

        if ($intent->status !== 'succeeded') {
            return redirect()->route('checkout')->with([
                'messege' => 'Payment was not successful.',
                'alert-type' => 'error'
            ]);
        }

        \Log::info('📝 Calling orderStore after successful Stripe intent');

        $order_result = $this->orderStore(
            $request,
            $user,
            $calculate_amount,
            'Stripe',
            $intent->id,
            1,
            0,
            7
        );

        if (!$order_result) {
            \Log::error('❌ Order store failed — result empty/null');
            return redirect()->route('checkout')->with([
                'messege' => 'Failed to save order.',
                'alert-type' => 'error'
            ]);
        }

        $guest = session('guest_user');
        SendOrderPlacedNotifications::dispatch(
            (int) $order_result->id,
            $user->id ?? null,
            is_array($guest) ? $guest : null,
            'Stripe',
            1
        )->afterResponse();

        return redirect()->route(auth()->check() ? 'dashboard' : 'home')->with([
            'messege' => trans('user_validation.Order submited successfully. please wait for admin approval'),
            'alert-type' => 'success'
        ]);
    } catch (\Exception $e) {
        \Log::error('❌ Stripe PaymentIntent Flow Failed: ' . $e->getMessage());
        return redirect()->route('checkout')->with([
            'messege' => 'Stripe payment failed. ' . $e->getMessage(),
            'alert-type' => 'error'
        ]);
    }
}

    // public function stripe_payment(Request $request)
    // {
    //     $user = Auth::guard('web')->user();
    
    //     // 🧾 Handle guest fallback
    //     if (!$user) {
    //         if (session()->has('guest_user')) {
    //             \Log::info('✅ Guest found via session.', ['guest_user' => session('guest_user')]);
    //             $guest = session('guest_user');
    //             $user = (object)[
    //                 'id' => null,
    //                 'name' => $guest['name'],
    //                 'email' => $guest['email'],
    //                 'phone' => $guest['phone'] ?? '',
    //             ];
    //         } elseif ($request->filled(['guest_name', 'guest_email'])) {
    //             \Log::info('✅ Guest fallback from request payload.');
    //             $user = (object)[
    //                 'id' => null,
    //                 'name' => $request->guest_name,
    //                 'email' => $request->guest_email,
    //                 'phone' => $request->guest_phone ?? '',
    //             ];
    //             session(['guest_user' => [
    //                 'name' => $request->guest_name,
    //                 'email' => $request->guest_email,
    //                 'phone' => $request->guest_phone,
    //             ]]);
    //         } else {
    //             return redirect()->route('checkout')->with([
    //                 'messege' => 'Guest information missing. Please restart checkout.',
    //                 'alert-type' => 'error'
    //             ]);
    //         }
    //     }
    
    //     if (Cart::count() === 0) {
    //         return redirect()->route('cart')->with([
    //             'messege' => trans('user_validation.Your cart is empty!'),
    //             'alert-type' => 'error'
    //         ]);
    //     }
    
    //     // 🧾 Get tip value
    //     $tip_amount = floatval($request->input('tip', 0));
    //     Session::put('tip_amount', $tip_amount); // Optional for UI tracking
    
    //     // 🧮 Build calculation array
    //     // $calculate_amount = [
    //     //     'grand_total' => floatval(Session::get('final_total', 0)) + $tip_amount,
    //     //     'sub_total' => floatval(Session::get('sub_total', 0)),
    //     //     'tax' => floatval(Session::get('calculated_tax', 0)),
    //     //     'delivery_charge' => floatval(Session::get('delivery_charge', 0)),
    //     //     'coupon_price' => floatval(Session::get('coupon_price', 0)),
    //     //     'tip' => $tip_amount,
    //     // ];
    //     $calculate_amount = $this->calculate_amount(7, $tip_amount);

    
    //     \Log::debug('💰 stripe_payment tip + totals debug:', $calculate_amount);
    
    //     if ($calculate_amount['grand_total'] <= 0) {
    //         return redirect()->route('checkout')->with([
    //             'messege' => 'Something went wrong. Total is invalid.',
    //             'alert-type' => 'error'
    //         ]);
    //     }
    
    //     $stripe = StripePayment::first();
    //     $payableAmount = round($calculate_amount['grand_total'] * $stripe->currency_rate, 2);
    
    //     if ($payableAmount <= 0) {
    //         return redirect()->route('checkout')->with([
    //             'messege' => 'Something went wrong. Payment amount invalid.',
    //             'alert-type' => 'error'
    //         ]);
    //     }
    
    //     // 🛠 Ensure datetime fallback if needed
    //     if ($request->is_preorder == 0 && $request->has('flat_time_only')) {
    //         $today = now()->format('Y-m-d');
    //         $request->merge([
    //             'flat_datetime' => $today . ' ' . $request->flat_time_only
    //         ]);
    //     }
    
    //     try {
    //         \Stripe\Stripe::setApiKey($stripe->stripe_secret);
    
    //         $result = \Stripe\Charge::create([
    //             "amount" => $payableAmount * 100,
    //             "currency" => $stripe->currency_code,
    //             "source" => $request->stripeToken,
    //             "description" => env('APP_NAME'),
    //         ]);
    
    //         $order_result = $this->orderStore(
    //             $request,
    //             $user,
    //             $calculate_amount,
    //             'Stripe',
    //             $result->balance_transaction,
    //             1, // payment_status
    //             0, // cash_on_delivery
    //             7  // address_id dummy/fixed if needed
    //         );
    
    //         // 📧 Notify
    //         // dispatch(function () use ($user, $order_result) {
    //         //     $this->sendOrderSuccessMail($user, $order_result, 'Stripe', 1);
    //         //     // $message = "🛒 *New Order!*\n\n"
    //         //     //     . "*Order ID:* {$order_result->order_id}\n"
    //         //     //     . "*Name:* {$user->name}\n"
    //         //     //     . "*Phone:* {$user->phone}\n"
    //         //     //     . "*Grand Total:* \${$order_result->grand_total}\n"
    //         //     //     . "*Payment:* Stripe\n\n"
    //         //     //     . "👉 Please check the dashboard for full details.";
    //         //     // sendWhatsAppOrderNotification($message);
    //         //               $message = "Hi {$user->name}, your order #{$order_result->order_id} of \${$order_result->grand_total} has been successfully placed via Stripe. Thank you!";
    //         //     $phoneNumber = $user->phone;

    //         //     // Ensure the number starts with country code
    //         //     if (!str_starts_with($phoneNumber, '+')) {
    //         //         $phoneNumber = '+1' . ltrim($phoneNumber, '0'); // Example for UK numbers
    //         //     }

    //         //     BulkSmsHelper::send($phoneNumber, $message);

    //         //     $adminPhone = env('ADMIN_PHONE');                 
    //         //     $messageToAdmin = "🛒 New Order Placed\nOrder ID: {$order_result->order_id}\nName: {$user->name}\nPhone: {$user->phone}\nAmount: \${$order_result->grand_total}";

    //         //     BulkSmsHelper::send($adminPhone, $messageToAdmin);
    //         // })->afterResponse();
            
    //         dispatch(function () use ($user, $order_result) {
    //             $this->sendOrderSuccessMail($user, $order_result, 'Stripe', 1);
            
    //             // Format SMS content
    //             $message = "Hi {$user->name}, your order #{$order_result->order_id} of \${$order_result->grand_total} has been successfully placed via Stripe. Thank you!";
    //             $messageToAdmin = "🛒 New Order Placed\nOrder ID: {$order_result->order_id}\nName: {$user->name}\nPhone: {$user->phone}\nAmount: \${$order_result->grand_total}";
            
    //             // Phone number formatter
    //             $formatPhoneForSMS = function ($number, $defaultCountryCode = '+1') {
    //                 $digitsOnly = preg_replace('/\D+/', '', $number);
    //                 if (str_starts_with($digitsOnly, '1') && strlen($digitsOnly) === 11) {
    //                     return '+' . $digitsOnly;
    //                 }
    //                 if (strlen($digitsOnly) === 10) {
    //                     return $defaultCountryCode . $digitsOnly;
    //                 }
    //                 return '+' . $digitsOnly;
    //             };
            
    //             // Format phone numbers
    //             $userPhone = $formatPhoneForSMS($user->phone); // e.g., (410) 949-1811 => +14109491811
    //             // $adminPhone = '+447776735799'; 
    //             $adminPhone = '+14433253708';
            
    //             // Send SMS
    //             \App\Helpers\BulkSmsHelper::send($userPhone, $message);
    //             \App\Helpers\BulkSmsHelper::send($adminPhone, $messageToAdmin);
    //         })->afterResponse();

    
    //         return redirect()->route(auth()->check() ? 'dashboard' : 'home')->with([
    //             'messege' => trans('user_validation.Order submited successfully. please wait for admin approval'),
    //             'alert-type' => 'success'
    //         ]);
    
    //     } catch (\Exception $e) {
    //         \Log::error('❌ Stripe Payment Failed: ' . $e->getMessage());
    
    //         return redirect()->route('checkout')->with([
    //             'messege' => 'Stripe payment failed. ' . $e->getMessage(),
    //             'alert-type' => 'error'
    //         ]);
    //     }
    // }
    

    public function razorpay_payment(Request $request){

        if(env('APP_MODE') == 0){
            $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $razorpay = RazorpayPayment::first();
        $input = $request->all();
        $api = new Api($razorpay->key,$razorpay->secret_key);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $payId = $response->id;

                $user = Auth::guard('web')->user();
                $calculate_amount = $this->calculate_amount(7);

                $order_result = $this->orderStore($request, $user, $calculate_amount,  'Razorpay', $payId, 1, 0, 7);

                $this->sendOrderSuccessMail($user, $order_result, 'Razorpay', 1);

                $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
                $notification = array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->route('dashboard')->with($notification);

            }catch (Exception $e) {
                $notification = trans('user_validation.Payment Faild');
                $notification = array('messege'=>$notification,'alert-type'=>'error');
                return redirect()->route('payment')->with($notification);
            }

        }else{
            $notification = trans('user_validation.Payment Faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('payment')->with($notification);
        }
    }

    public function razorpay_flutterwave(Request $request){

        if(env('APP_MODE') == 0){
            $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $flutterwave = Flutterwave::first();
        $curl = curl_init();
        $tnx_id = $request->tnx_id;
        $url = "https://api.flutterwave.com/v3/transactions/$tnx_id/verify";
        $token = $flutterwave->secret_key;
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);


        if($response->status == 'success'){
            $user = Auth::guard('web')->user();
            $calculate_amount = $this->calculate_amount(7);

            $order_result = $this->orderStore($request, $user, $calculate_amount,  'Flutterwave', $tnx_id, 1, 0, 7);

            $this->sendOrderSuccessMail($user, $order_result, 'Flutterwave', 1);

            $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
            return response()->json(['message' => $notification]);
        }else{
            $notification = trans('user_validation.Payment Faild');
            return response()->json(['message' => $notification],403);
        }
    }

    public function pay_with_mollie(){

        if(env('APP_MODE') == 0){
            $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $user = Auth::guard('web')->user();
        $cart_contents = Cart::content();

        $calculate_amount = $this->calculate_amount(7);


        $amount_real_currency = $calculate_amount['grand_total'];
        $mollie = PaystackAndMollie::first();
        $price = $amount_real_currency * $mollie->mollie_currency_rate;
        $price = sprintf('%0.2f', $price);

        $mollie_api_key = $mollie->mollie_key;
        $currency = strtoupper($mollie->mollie_currency_code);
        Mollie::api()->setApiKey($mollie_api_key);
        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => $currency,
                'value' => ''.$price.'',
            ],
            'description' => env('APP_NAME'),
            'redirectUrl' => route('mollie-payment-success'),
        ]);

        $payment = Mollie::api()->payments()->get($payment->id);
        session()->put('payment_id',$payment->id);
        session()->put('calculate_amount',$calculate_amount);
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function mollie_payment_success(Request $request){
        $mollie = PaystackAndMollie::first();
        $mollie_api_key = $mollie->mollie_key;
        Mollie::api()->setApiKey($mollie_api_key);
        $payment = Mollie::api()->payments->get(session()->get('payment_id'));
        if ($payment->isPaid()){
            $user = Auth::guard('web')->user();
            $calculate_amount = Session::get('calculate_amount');
            $order_result = $this->orderStore($request, $user, $calculate_amount,  'Mollie', session()->get('payment_id'), 1, 0, 7);

            $this->sendOrderSuccessMail($user, $order_result, 'Mollie', 1);

            $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('dashboard')->with($notification);
        }else{
            $notification = trans('user_validation.Payment faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('payment')->with($notification);
        }
    }

    public function pay_with_paystack(Request $request){

        if(env('APP_MODE') == 0){
            $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $paystack = PaystackAndMollie::first();

        $reference = $request->reference;
        $transaction = $request->tnx_id;
        $secret_key = $paystack->paystack_secret_key;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/$reference",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST =>0,
            CURLOPT_SSL_VERIFYPEER =>0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $secret_key",
                "Cache-Control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $final_data = json_decode($response);
        if($final_data->status == true) {

            $user = Auth::guard('web')->user();
            $cart_contents = Cart::content();

            $calculate_amount = $this->calculate_amount(7);
            $order_result = $this->orderStore($request, $user, $calculate_amount,  'Paystack', $transaction, 1, 0, 7);

            $this->sendOrderSuccessMail($user, $order_result, 'Paystack', 1);

            $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
            return response()->json(['message' => $notification]);

        }else{
            $notification = trans('user_validation.Payment Faild');
            return response()->json(['message' => $notification],403);
        }
    }

    public function pay_with_instamojo(){

        if(env('APP_MODE') == 0){
            $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $user = Auth::guard('web')->user();

        $calculate_amount = $this->calculate_amount(7);
        Session::push('calculate_amount', $calculate_amount);

        $amount_real_currency = $calculate_amount['grand_total'];
        $instamojoPayment = InstamojoPayment::first();
        $price = $amount_real_currency * $instamojoPayment->currency_rate;
        $price = round($price,2);


        $environment = $instamojoPayment->account_mode;
        $api_key = $instamojoPayment->api_key;
        $auth_token = $instamojoPayment->auth_token;


        if($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url.'payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"));
        $payload = Array(
            'purpose' => env("APP_NAME"),
            'amount' => $price,
            'phone' => '918160651749',
            'buyer_name' => Auth::user()->name,
            'redirect_url' => route('instamojo-response'),
            'send_email' => true,
            'webhook' => 'http://www.example.com/webhook/',
            'send_sms' => true,
            'email' => Auth::user()->email,
            'allow_repeated_payments' => false
        );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        return redirect($response->payment_request->longurl);
    }

    public function instamojo_response(Request $request){
        $input = $request->all();

        $instamojoPayment = InstamojoPayment::first();
        $environment = $instamojoPayment->account_mode;
        $api_key = $instamojoPayment->api_key;
        $auth_token = $instamojoPayment->auth_token;

        if($environment == 'Sandbox') {
            $url = 'https://test.instamojo.com/api/1.1/';
        } else {
            $url = 'https://www.instamojo.com/api/1.1/';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'payments/'.$request->get('payment_id'));
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:$api_key",
                "X-Auth-Token:$auth_token"));
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $notification = trans('user_validation.Payment faild');
            $notification = array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->route('payment')->with($notification);
        } else {
            $data = json_decode($response);
        }

        if($data->success == true) {
            if($data->payment->status == 'Credit') {
                $user = Auth::guard('web')->user();
                $calculate_amount = Session::get('calculate_amount');
                $order_result = $this->orderStore($request, $user, $calculate_amount,  'Instamojo', $request->get('payment_id'), 1, 0, 7);

                $this->sendOrderSuccessMail($user, $order_result, 'Instamojo', 1);

                $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
                $notification = array('messege'=>$notification,'alert-type'=>'success');
                return redirect()->route('dashboard')->with($notification);
            }
        }
    }

    public function sslcommerz(Request $request)
    {

        if(env('APP_MODE') == 0){
            $notification = trans('user_validation.This Is Demo Version. You Can Not Change Anything');
            $notification=array('messege'=>$notification,'alert-type'=>'error');
            return redirect()->back()->with($notification);
        }

        $user = Auth::guard('web')->user();
        $calculate_amount = $this->calculate_amount(7);
        Session::put('calculate_amount', $calculate_amount);
        $total_price = $calculate_amount['grand_total'];

        $sslcommerzPaymentInfo = SslcommerzPayment::first();
        $payableAmount = round($total_price * $sslcommerzPaymentInfo->currency_rate,2);

        $post_data = array();
        $post_data['total_amount'] = $payableAmount; # You cant not pay less than 10
        $post_data['currency'] = $sslcommerzPaymentInfo->currency_code;
        $post_data['tran_id'] = uniqid();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $user->name;
        $post_data['cus_email'] = $user->email ? $user->email : 'johndoe@gmail.com';
        $post_data['cus_add1'] = '';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Country";
        $post_data['cus_phone'] =  $user->phone ? $user->phone : '123456789';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "";
        $post_data['ship_add1'] = "";
        $post_data['ship_add2'] = "";
        $post_data['ship_city'] = "";
        $post_data['ship_state'] = "";
        $post_data['ship_postcode'] = "";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = 'Test Product';
        $post_data['product_category'] = "Package";
        $post_data['product_profile'] = "Package";

        config(['sslcommerz.apiCredentials.store_id' => $sslcommerzPaymentInfo->store_id]);
        config(['sslcommerz.apiCredentials.store_password' => $sslcommerzPaymentInfo->store_password]);
        config(['sslcommerz.success_url' => '/sslcommerz-success']);
        config(['sslcommerz.failed_url' => '/sslcommerz-failed']);

        $sslc = new SslCommerzNotification(config('sslcommerz'));

        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        $data = json_decode($payment_options);
        return redirect()->to($data->data);


    }

    public function sslcommerz_success(Request $request)
    {

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $payment_id = $request->get('payment_id');

        $sslcommerzPaymentInfo = SslcommerzPayment::first();

        config(['sslcommerz.apiCredentials.store_id' => $sslcommerzPaymentInfo->store_id]);
        config(['sslcommerz.apiCredentials.store_password' => $sslcommerzPaymentInfo->store_password]);
        config(['sslcommerz.success_url' => '/user/checkout/sslcommerz-success']);
        config(['sslcommerz.failed_url' => '/user/checkout/sslcommerz-failed']);

        $sslc = new SslCommerzNotification(config('sslcommerz'));

        $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

        if ($validation == TRUE) {
            $transaction_id = $payment_id;

            $user = Auth::guard('web')->user();

            $calculate_amount = Session::get('calculate_amount');
            $order_result = $this->orderStore($request, $user, $calculate_amount,  'SslCommerz', $transaction_id, 1, 0, 7);

            $this->sendOrderSuccessMail($user, $order_result, 'SslCommerz', 1);

            $notification = trans('user_validation.Order submited successfully. please wait for admin approval');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('dashboard')->with($notification);

        } else {
            $notification = trans('user_validation.Payment faild');
            $notification = array('messege'=>$notification,'alert-type'=>'success');
            return redirect()->route('payment')->with($notification);
        }

    }

    public function sslcommerz_failed(Request $request)
    {
        $notification = trans('user_validation.Payment faild');
        $notification = array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('payment')->with($notification);
    }

    public function calculate_amount($address_id, $tip = 0)
    {
        $delivery_charge = Session::get('delivery_charge') ?? 0;
        $sub_total = 0;
        $coupon_price = 0.00;
    
        $cart_contents = Cart::content();
        foreach ($cart_contents as $cart_content){
            $item_price = $cart_content->price * $cart_content->qty;
            $item_total = $item_price + ($cart_content->options->optional_item_price ?? 0) + ($cart_content->options->protein_item_price ?? 0);
            $sub_total += $item_total;
        }
    
        if(Session::get('coupon_price') && Session::get('offer_type')){
            if(Session::get('offer_type') == 1) {
                $coupon_price = ($sub_total * Session::get('coupon_price')) / 100;
            } else {
                $coupon_price = Session::get('coupon_price');
            }
        }
    
        $sub_total_after_coupon = $sub_total - $coupon_price;
    
        // ✅ Correct tax calculation
        if (Session::get('order_type') == 'delivery') {
            $taxable_amount = $sub_total_after_coupon + $delivery_charge;
        } else {
            $taxable_amount = $sub_total_after_coupon;
        }
    
        $tax = round($taxable_amount * 0.06, 2); // VAT 6%
        $grand_total = $taxable_amount + $tax + $tip; // ✅ Add tip to grand total
    
        return [
            'sub_total' => $sub_total,
            'coupon_price' => $coupon_price,
            'delivery_charge' => $delivery_charge,
            'tax' => $tax,
            'tip' => $tip, // ✅ Include tip in returned array
            'grand_total' => $grand_total,
        ];
    }
    
    
    public function orderStore(Request $request, $user, $calculate_amount, $payment_method, $transaction_id, $payment_status, $cash_on_delivery, $address_id)
    {
        \Log::debug('📥 orderStore() tip value check:', [
            'tip_in_calculation' => $calculate_amount['tip'] ?? 'MISSING',
            'full_calculate_amount' => $calculate_amount,
        ]);
    
        \Log::debug('📦 Incoming request to orderStore:', $request->all());
    
        // ✅ Wrap validation to catch issues early
        try {
            $validated = $request->validate([
                'is_preorder' => 'required|in:0,1',
                'flat_datetime' => 'required_if:is_preorder,1|date',
                'flat_time_only' => 'required_if:is_preorder,0|date_format:H:i',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ Validation failed in orderStore', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return redirect()->route('checkout')->with([
                'messege' => 'Order validation failed. Please check date/time fields.',
                'alert-type' => 'error'
            ]);
        }
    
        \Log::info('Guest Session Check at orderstore', ['guest_user' => session('guest_user')]);
    
        $guest = session('guest_user');
        $order = new Order();
    
        // ✅ Handle guest user creation
        if ((empty($user->id) || is_null($user->id)) && $guest) {
            \Log::info('✅ Creating guest record in guests table...');
            $guestRecord = \App\Models\Guest::create([
                'name' => $guest['name'],
                'email' => $guest['email'] ?? null,
                'phone' => $guest['phone'] ?? null,
            ]);
            $order->guest_id = $guestRecord->id;
        }
    
        // ✅ Common order details
        $order->order_id = substr(rand(0, time()), 0, 10);
        $order->user_id = $user->id ?? null;
        $order->grand_total = $calculate_amount['grand_total'];
        $order->delivery_charge = $calculate_amount['delivery_charge'];
        $order->coupon_price = $calculate_amount['coupon_price'];
        $order->tax = $calculate_amount['tax'];
        $order->sub_total = $calculate_amount['sub_total'];
        $order->product_qty = Cart::count();
        $order->payment_method = $payment_method;
        $order->transection_id = $transaction_id;
        $order->payment_status = $payment_status;
        $order->order_status = 0;
        $order->cash_on_delivery = $cash_on_delivery;
        $order->order_type = Session::get('order_type') ?? 'pickup';
        $order->tip = $calculate_amount['tip'] ?? 0;
    
        // ✅ Schedule info
        $order->is_preorder = $request->is_preorder == 1 ? 1 : 0;
        if ($request->is_preorder == 1) {
            $order->schedule_time = $request->flat_datetime;
        } else {
            $today = now()->format('Y-m-d');
            $order->schedule_time = $today . ' ' . $request->flat_time_only;
        }
    
        try {
            $minimumTime = now()->addMinutes(59);
            $scheduleTime = \Carbon\Carbon::parse($order->schedule_time);
    
            \Log::debug('🕒 Order schedule time debug', [
                'now_plus_59' => $minimumTime->toDateTimeString(),
                'user_selected_time' => $scheduleTime->toDateTimeString(),
                'order_type' => Session::get('order_type'),
                'is_preorder' => $request->is_preorder,
            ]);
    
            if ($scheduleTime->lessThan($minimumTime)) {
                return redirect()->back()->with([
                    'messege' => 'Time must be at least 1 hour from now.',
                    'alert-type' => 'error'
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('⛔ Invalid schedule time passed to orderStore', [
                'raw_schedule_time' => $order->schedule_time,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with([
                'messege' => 'Something went wrong with the schedule time. Please select a valid time.',
                'alert-type' => 'error'
            ]);
        }
    
        $order->save();
        \Log::info('✅ Order inserted successfully into orders table.', ['order_id' => $order->id]);


           // ✅ Send push notification to all admins with FCM tokens
        $adminTokens = Admin::whereNotNull('fcm_token')->pluck('fcm_token')->unique();
        
               foreach ($adminTokens as $token) {
            try {
                FCMv1Helper::sendNotification(
                    $token,
                    'New Order 🚀',
                    'Check the admin panel for details.'
                );
            } catch (\Throwable $e) {
                \Log::error('❌ FCM v1 push failed', [
                    'token' => $token,
                    'error' => $e->getMessage(),
                ]);
            }
        }

    
        // ✅ Save products to OrderProduct
        foreach (Cart::content() as $cart_content) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $cart_content->id;
            $orderProduct->product_name = $cart_content->name;
            $orderProduct->unit_price = $cart_content->price;
            $orderProduct->qty = $cart_content->qty;
            $orderProduct->product_size = $cart_content->options->size;
            $orderProduct->optional_price = $cart_content->options->optional_item_price ?? 0;
            $orderProduct->optional_item = json_encode($cart_content->options->optional_items ?? []);
            $orderProduct->protein_item = json_encode($cart_content->options->protein_items ?? []);
            $orderProduct->soup_item = json_encode($cart_content->options->soup_items ?? []);
            $orderProduct->wrap_item = json_encode($cart_content->options->wrap_items ?? []);
            $orderProduct->drink_item = json_encode($cart_content->options->drink_items ?? []);
            $orderProduct->food_instruction = $cart_content->options->food_instruction ?? null;
            $orderProduct->save();
        }
    
        // ✅ Save delivery address
        if (Session::get('order_type') === 'delivery') {
            $typed_address = Session::get('typed_address');
            $typed_distance = Session::get('typed_distance');
            $typed_fee = Session::get('typed_fee');
    
            $orderAddress = new OrderAddress();
            $orderAddress->order_id = $order->id;
            $orderAddress->name = $user->name ?? $guest['name'];
            $orderAddress->email = $user->email ?? $guest['email'];
            $orderAddress->phone = $user->phone ?? $guest['phone'];
            $orderAddress->address = $typed_address ?? 'N/A';
            $orderAddress->delivery_time = '45-60';
            $orderAddress->miles_cover = $typed_distance ?? null;
            $orderAddress->fee = $typed_fee ?? null;
            $orderAddress->save();
        }
    
        // ✅ Clear session and cart
        Session::forget([
            'delivery_id',
            'delivery_charge',
            'coupon_price',
            'offer_type',
            'typed_address',
            'typed_distance',
            'order_type'
        ]);
        Cart::destroy();
    
        return $order;
    }
    
    
public function sendOrderSuccessMail($user, $order_result, $payment_method, $payment_status)
{
    try {
        \Log::info('🔍 Sending Order Success Mail Debug Info', [
            'user' => $user,
            'order_result' => $order_result,
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
        ]);

        try {
            MailHelper::setMailConfig();
        } catch (\Throwable $e) {
            \Log::error('Mail config setup failed', ['exception' => $e]);
        }

        $setting = \App\Models\Setting::first();
        $currency = $setting->currency_icon ?? '$';
        $payment_status_text = $payment_status == 1 ? 'Success' : 'Pending';
        $order_date = optional($order_result->created_at)->format('d F, Y') ?? now()->format('d F, Y');

        $userSubject = "✅ Order Confirmation - #{$order_result->order_id}";
        $adminSubject = "📩 New Order Placed - #{$order_result->order_id}";

        // Send email to user/guest
        $emailTo = data_get($user, 'email') ?: data_get(session('guest_user'), 'email');
        if ($emailTo) {
            \Mail::to($emailTo)->send(new \App\Mail\OrderSuccessfully(
                $order_result,
                $user,
                $userSubject,
                'user.order_email_template' // View for user
            ));
            \Log::info("✅ Order confirmation email sent to user: {$emailTo}");
        }

        // Send email to admin
        $adminEmail = config('mail.admin_address') ?: env('MAIL_ADMIN_ADDRESS');
        if (!$adminEmail) {
            \Log::warning('Admin email not configured; skipping admin order email', [
                'order_id' => $order_result->id ?? null,
            ]);
            return;
        }

        \Mail::to($adminEmail)->send(new \App\Mail\OrderSuccessfully(
            $order_result,
            $user,
            $adminSubject,
            'admin.order_email_template',  // View for admin
            $payment_status_text           // Optional: useful in view
        ));
        \Log::info("✅ Admin notified of new order: {$adminEmail}");

    } catch (\Exception $e) {
        \Log::error('📨 Email Sending Failed: ' . $e->getMessage());
    }
}

    
    //   public function sendOrderSuccessMail($user, $order_result, $payment_method, $payment_status)
    // {
    //     try {
    //         \Log::info('🔍 Sending Order Success Mail Debug Info', [
    //             'user' => $user,
    //             'order_result' => $order_result,
    //             'payment_method' => $payment_method,
    //             'payment_status' => $payment_status,
    //         ]);
    
    //         $setting = \App\Models\Setting::first();
    //         $template = \App\Models\EmailTemplate::find(6); // order success template for customer
    
    //         if (!$template || !$order_result) {
    //             throw new \Exception('Missing email template or order result.');
    //         }
    
    //         $currency = $setting->currency_icon ?? '$';
    //         $payment_status_text = $payment_status == 1 ? 'Success' : 'Pending';
    //         $order_date = optional($order_result->created_at)->format('d F, Y') ?? now()->format('d F, Y');
    
    //         // === USER EMAIL ===
    //         $userSubject = $template->subject ?? 'Order Successfully';
    //         $userMessage = $template->description ?? '';
    //         $userMessage = str_replace('{{user_name}}', $user->name ?? 'Customer', $userMessage);
    //         $userMessage = str_replace('{{total_amount}}', $currency . ($order_result->grand_total ?? '0.00'), $userMessage);
    //         $userMessage = str_replace('{{payment_method}}', $payment_method ?? 'N/A', $userMessage);
    //         $userMessage = str_replace('{{payment_status}}', $payment_status_text, $userMessage);
    //         $userMessage = str_replace('{{order_status}}', 'Pending', $userMessage);
    //         $userMessage = str_replace('{{order_date}}', $order_date, $userMessage);
    
    //         $emailTo = $user->email ?? (session('guest_user.email') ?? null);
    //         if ($emailTo) {
    //             \Mail::to($emailTo)->send(new \App\Mail\OrderSuccessfully($userMessage, $userSubject));
    //             \Log::info("✅ Order confirmation email sent to user: {$emailTo}");
    //         }
    
    //         // === ADMIN EMAIL ===
    //         // $adminEmail = env('MAIL_ADMIN_ADDRESS');
    //         $adminEmail = config('mail.admin_address');

    //         if (!$adminEmail) {
    //             throw new \Exception('Admin email not configured in .env (MAIL_ADMIN_ADDRESS).');
    //         }
    
    //         $adminSubject = '📩 New Order Notification - ' . $order_result->order_id;
    //         $adminMessage = "
    //             A new order has been placed by {$user->name}.
    
    //             ▪ Order ID: {$order_result->order_id}
    //             ▪ Total: {$currency}{$order_result->grand_total}
    //             ▪ Payment: {$payment_method} ({$payment_status_text})
    //             ▪ Date: {$order_date}
    
    //             Login to the admin panel to view full details.
    //         ";
    
    //         \Mail::to($adminEmail)->send(new \App\Mail\OrderSuccessfully(nl2br($adminMessage), $adminSubject));
    //         \Log::info("✅ Admin notified of new order: {$adminEmail}");
    
    //     } catch (\Exception $e) {
    //         \Log::error('📨 Email Sending Failed: ' . $e->getMessage());
    //     }
    // }
    
    
    
}


