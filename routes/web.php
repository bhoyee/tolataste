<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\Admin\DashboardController;
use App\Http\Controllers\WEB\Admin\Auth\AdminLoginController;
use App\Http\Controllers\WEB\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\WEB\Admin\AdminProfileController;
use App\Http\Controllers\WEB\Admin\ProductCategoryController;
use App\Http\Controllers\WEB\Admin\TestimonialController;
use App\Http\Controllers\WEB\Admin\OurChefController;
use App\Http\Controllers\WEB\Admin\ProductController;
use App\Http\Controllers\WEB\Admin\ProductGalleryController;
use App\Http\Controllers\WEB\Admin\ServiceController;
use App\Http\Controllers\WEB\Admin\AboutUsController;
use App\Http\Controllers\WEB\Admin\ContactPageController;
use App\Http\Controllers\WEB\Admin\CustomPageController;
use App\Http\Controllers\WEB\Admin\TermsAndConditionController;
use App\Http\Controllers\WEB\Admin\PrivacyPolicyController;
use App\Http\Controllers\WEB\Admin\BlogCategoryController;
use App\Http\Controllers\WEB\Admin\BlogController;
use App\Http\Controllers\WEB\Admin\PopularBlogController;
use App\Http\Controllers\WEB\Admin\BlogCommentController;
use App\Http\Controllers\WEB\Admin\ProductVariantController;
use App\Http\Controllers\WEB\Admin\SettingController;
use App\Http\Controllers\WEB\Admin\SubscriberController;
use App\Http\Controllers\WEB\Admin\ContactMessageController;
use App\Http\Controllers\WEB\Admin\EmailConfigurationController;
use App\Http\Controllers\WEB\Admin\EmailTemplateController;
use App\Http\Controllers\WEB\Admin\AdminController;
use App\Http\Controllers\WEB\Admin\FaqController;
use App\Http\Controllers\WEB\Admin\GalleryController;
use App\Http\Controllers\WEB\Admin\ProductReviewController;
use App\Http\Controllers\WEB\Admin\CustomerController;
use App\Http\Controllers\WEB\Admin\ErrorPageController;
use App\Http\Controllers\WEB\Admin\ContentController;
use App\Http\Controllers\WEB\Admin\PaymentMethodController;
use App\Http\Controllers\WEB\Admin\SliderController;
use App\Http\Controllers\WEB\Admin\CounterController;
use App\Http\Controllers\WEB\Admin\PartnerController;
use App\Http\Controllers\WEB\Admin\OrderController;
use App\Http\Controllers\WEB\Admin\CouponController;
use App\Http\Controllers\WEB\Admin\FooterController;
use App\Http\Controllers\WEB\Admin\FooterSocialLinkController;
use App\Http\Controllers\WEB\Admin\LanguageController;
use App\Http\Controllers\WEB\Admin\AdvertisementController;
use App\Http\Controllers\WEB\Admin\HomepageController;
use App\Http\Controllers\WEB\Admin\DeliveryAreaCotroller;
use App\Http\Controllers\WEB\Admin\CateringRequestController;
use App\Http\Controllers\WEB\Admin\DeliverySettingController;
use Gloudemans\Shoppingcart\Facades\Cart;



use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CateringController;
use App\Http\Controllers\GuestCheckoutController;



use App\Http\Controllers\WEB\User\UserProfileController;
use App\Http\Controllers\WEB\User\AddressCotroller;
use App\Http\Controllers\WEB\User\PaymentController;
use App\Http\Controllers\WEB\User\PaypalController;
use App\Http\Controllers\WEB\User\CheckoutSessionController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WEB\Admin\AboutUsTranslationController;
use App\Http\Controllers\WEB\Admin\AdvertisementTranslationController;
use App\Http\Controllers\WEB\Admin\BlogTranslationController;
use App\Http\Controllers\WEB\Admin\CategoryTranslationController;
use App\Http\Controllers\WEB\Admin\CounterTranslationController;
use App\Http\Controllers\WEB\Admin\CustomPageTranslationController;
use App\Http\Controllers\WEB\Admin\FaqTranslationController;
use App\Http\Controllers\WEB\Admin\FooterTranslationController;
use App\Http\Controllers\WEB\Admin\HomepageTranslationController;
use App\Http\Controllers\WEB\Admin\LanguageManagerController;
use App\Http\Controllers\WEB\Admin\OurChefTranslationController;
use App\Http\Controllers\WEB\Admin\PrivacyPolicyTranslationController;
use App\Http\Controllers\WEB\Admin\ProductCategoryTranslationController;
use App\Http\Controllers\WEB\Admin\ProductTranslationController;
use App\Http\Controllers\WEB\Admin\ServiceTranslationController;
use App\Http\Controllers\WEB\Admin\SettingsTranslationController;
use App\Http\Controllers\WEB\Admin\TermsAndConditionTranslationController;
use App\Http\Controllers\WEB\Admin\TestimonialTranslationController;

use App\Models\BlogTranslation;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Artisan;
use App\Helpers\FCMv1Helper;
use App\Models\Admin;
use App\Http\Controllers\WEB\Admin\MenuVisibilityController;



Route::get('/debug-email-source', function() {
    // Check where the support email is coming from
    \Log::info('Checking email config source');
    
    $config = [
        'env_username' => env('MAIL_USERNAME'),
        'config_username' => config('mail.mailers.smtp.username'),
        'env_from' => env('MAIL_FROM_ADDRESS'),
        'config_from' => config('mail.from.address'),
        'admin_address' => config('mail.admin_address'),
    ];
    
    \Log::info('Email config: ' . json_encode($config));
    
    return $config;
});

Route::get('/run-migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return '✅ Migration completed successfully.';
    } catch (\Exception $e) {
        return '❌ Migration failed: ' . $e->getMessage();
    }
});

Route::get('/run-migration', function () {
    \Artisan::call('migrate', ['--force' => true]);
    return 'Migration run successfully!';
});

Route::get('/test-fcm', function () {
    $admin = Admin::whereNotNull('fcm_token')->first();

    if (!$admin) {
        return '❌ No admin with FCM token found.';
    }

    $token = $admin->fcm_token;

    try {
        $response = FCMv1Helper::sendNotification(
            $token,
            '🔔 Test Notification',
            'This is a test push from Laravel using HTTP v1!'
        );

        return response()->json([
            'message' => '✅ Test notification sent!',
            'token' => $token,
            'fcm_response' => $response,
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'message' => '❌ Failed to send notification',
            'error' => $e->getMessage(),
        ], 500);
    }
});

Route::get('/app', function () {
    return view('app');
});

// in routes/web.php
Route::get('/clear-cache', function () {
    Artisan::call('optimize:clear');
    return '✅ Laravel cache cleared!';
});


  // In routes/web.php
Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent'])
    ->name('create-payment-intent')
    ->withoutMiddleware([\App\Http\Middleware\Authenticate::class]);



Route::get('/fix-laravel', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return '✔ Laravel cache cleared.';
});

Route::get('/hard-fix-laravel', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    Artisan::call('clear-compiled');
    exec('composer dump-autoload');

    return '✔ Laravel caches cleared and autoload dumped.';
});

Route::get('/menu-visibility', [MenuVisibilityController::class, 'index'])->name('menu.visibility');


Route::get('/api/contact-message-toggle', function () {
    return response()->json([
        'enabled' => \App\Models\Setting::first()->enable_save_contact_message
    ]);
});




Route::get('admin/dashboard/today-orders-html', [DashboardController::class, 'todayOrdersHtml'])
    ->name('admin.dashboard.today_orders_html');

Route::get('/admin/dashboard-stats', [\App\Http\Controllers\WEB\Admin\DashboardController::class, 'getDashboardStats'])->name('admin.dashboard.stats');


Route::get('/api/openrouteservice-key', function () {
    return response()->json(['key' => config('services.openrouteservice.key')]);
});


// ✅ Make sure NO auth middleware is applied here
Route::get('/set-delivery-charge', [PaymentController::class, 'set_delivery_charge'])
    ->name('set-delivery-charge')
    ->middleware('web'); // 'web' is fine, but NOT 'auth'

// web.php
Route::get('/set-order-type', function (Request $request) {
    $order_type = $request->order_type;
    if (!in_array($order_type, ['pickup', 'delivery'])) {
        return response()->json(['status' => 'error', 'message' => 'Invalid order type.'], 400);
    }

    session(['order_type' => $order_type]);
    return response()->json(['status' => 'success']);
});

// web.php
Route::get('/api/delivery-settings', function () {
    $setting = \App\Models\DeliverySetting::first();

    return Response::json([
        'base_fee_per_mile' => $setting->base_fee_per_mile,
        'mid_fee_per_mile' => $setting->mid_fee_per_mile,
        'long_fee_per_mile' => $setting->long_fee_per_mile,
    ]);
});



Route::get('admin/test-delivery-setting', function () {
    return \App\Models\DeliverySetting::first();
});


// Save checkout totals to session
Route::post('/save-checkout-session', [CheckoutSessionController::class, 'save'])->name('save.checkout.session');

Route::post('/set-typed-delivery-address', function (Request $request) {
    session([
        'typed_address' => $request->address,
        'typed_distance' => $request->distance,
        'typed_fee' => $request->fee, // ✅ capture fee here too
    ]);

    return response()->json(['status' => 'success']);
});


Route::get('/catering', [CateringController::class, 'index'])->name('catering');
Route::post('/catering-submit', [CateringController::class, 'submit'])->name('catering.submit');

Route::post('/guest-checkout-start', [GuestCheckoutController::class, 'store'])->name('guest.checkout.start');


Route::post('/guest-checkout-session', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'guest_name' => 'required|string|max:100',
        'guest_email' => 'required|email',
        'guest_phone' => 'required|string|max:20',
    ]);

    session([
        'guest_user' => [
            'name' => $request->guest_name,
            'email' => $request->guest_email,
            'phone' => $request->guest_phone,
        ],
    ]);

    return response()->json(['redirect' => route('checkout')]);
})->name('guest.checkout.session');



Route::get('/get-cart-item-details/{rowId}', [CartController::class, 'getCartItemDetails'])->name('cart.getDetails');
// Route::post('/update-cart-item/{rowId}', [CartController::class, 'updateCartItem'])->name('cart.update');

Route::group(['middleware' => ['XSS', 'setLocale']], function () {

    Route::group(['middleware' => ['maintainance', 'HtmlSpecialchars']], function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/about-us', [HomeController::class, 'about_us'])->name('about-us');
        Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
        Route::post('/send-contact-us', [HomeController::class, 'send_contact_message'])->name('send-contact-us');
        Route::get('/blogs', [HomeController::class, 'blogs'])->name('blogs');
        Route::get('/blog/{slug}', [HomeController::class, 'show_blog'])->name('show-blog');
        Route::post('/blog-comment', [HomeController::class, 'blog_comment'])->name('blog-comment');
        Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
        Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
        
        Route::get('/page/{slug}', [HomeController::class, 'custom_page'])->name('show-page');
        Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
        Route::get('/terms-and-condition', [HomeController::class, 'terms_and_condition'])->name('terms-and-condition');
        Route::get('/privacy-policy', [HomeController::class, 'privacy_policy'])->name('privacy-policy');
        Route::get('/products', [HomeController::class, 'products'])->name('products');
        Route::get('/product/{slug}', [HomeController::class, 'show_product'])->name('show-product');
        Route::get('/load-product-modal/{id}', [HomeController::class, 'load_product_model'])->name('load-product-modal');

        Route::get('/our-chef', [HomeController::class, 'our_chef'])->name('our-chef');
        Route::get('/testimonial', [HomeController::class, 'testimonial'])->name('testimonial');

        Route::post('/subscribe-request', [HomeController::class, 'subscribeRequest'])->name('subscribe-request');
        Route::get('/subscriber-verification/{token}', [HomeController::class, 'subscriberVerifcation'])->name('subscriber-verification');


        Route::get('/login', [LoginController::class, 'login_page'])->name('login');
        Route::post('/store-login', [LoginController::class, 'store_page'])->name('store-login');
        Route::get('/user-logout', [LoginController::class, 'user_logout'])->name('user-logout');

        Route::get('/forget-password', [LoginController::class, 'forget_page'])->name('forget-password');
        Route::post('/send-forget-password', [LoginController::class, 'send_reset_link'])->name('send-forget-password');
        Route::get('/reset-password/{id}', [LoginController::class, 'reset_password'])->name('reset-password');
        Route::post('/store-reset-password/{id}', [LoginController::class, 'store_reset_password'])->name('store-reset-password');

        Route::get('/register', [RegisterController::class, 'register_page'])->name('register');
        Route::post('/store-register', [RegisterController::class, 'store_register'])->name('store-register');
        Route::get('/verify-register/{token}', [RegisterController::class, 'verify_register'])->name('verify-register');

        Route::get('/dashboard', [UserProfileController::class, 'dashboard'])->name('dashboard');
        Route::post('/update-profile', [UserProfileController::class, 'update_profile'])->name('update-profile');
        Route::post('/update-password', [UserProfileController::class, 'update_password'])->name('update-password');
        Route::post('/upload-user-avatar', [UserProfileController::class, 'upload_user_avatar'])->name('upload-user-avatar');
        Route::get('/add-to-wishlist/{id}', [UserProfileController::class, 'add_to_wishlist'])->name('add-to-wishlist');
        Route::delete('/remove-to-wishlist/{id}', [UserProfileController::class, 'remove_to_wishlist'])->name('remove-to-wishlist');
        Route::post('/submit-review', [UserProfileController::class, 'store_review'])->name('submit-review');
        Route::get('/single-order/{order_id}', [UserProfileController::class, 'single_order'])->name('single-order');

        Route::post('/store-reservation', [UserProfileController::class, 'store_reservation'])->name('store-reservation');

        Route::get('/delete-account', [UserProfileController::class, 'delete_account'])->name('delete-account');

// In web.php
Route::get('/test-logging', function () {
    \Log::channel('custom_edit')->info('✅ Custom logging is working!');
    return 'Logged!';
});
// Route::get('/edit-cart-item-debug/{rowId}', [CartController::class, 'editCartItem'])->name('cart.edit');
// Route::get('/edit-cart-item/{rowId}', [CartController::class, 'editCartItem'])->name('cart.edit');
// Route::get('/edit-cart-item/{rowId}', [\App\Http\Controllers\CartController::class, 'editCartItem'])->name('cart.edit');

Route::get('/cart/edit/{rowId}', [TestController::class, 'editCartPage'])->name('cart.edit.page');
Route::post('/cart/update/{rowId}', [TestController::class, 'updateCart'])->name('cart.update');




// Route::post('/cart/update/{rowId}', [CartController::class, 'updateCart'])->name('cart.update');

// Route::get('/test-edit-cart', function () {
//     return view('edit-cart-form'); // ❌ This does NOT pass $allProteins
// });


// Route::get('/test-edit-cart', function () {
//     $cartItem = (object) [
//         'rowId' => 'test123',
//         'name' => 'Hyderabadi Biryani',
//         'options' => (object) [
//             'protein_items' => [
//                 ['protein_name' => 'Acheke Fish', 'protein_price' => 20],
//                 ['protein_name' => 'Tilapia', 'protein_price' => 10],
//             ],
//             'food_instruction' => 'No onions please.',
//         ],
//     ];

//     $allProteins = [
//         ['item' => 'Tilapia', 'price' => 10],
//         ['item' => 'Acheke Fish', 'price' => 20],
//         ['item' => 'Turkey', 'price' => 5],
//     ];

//     return view('edit-cart-form', compact('cartItem', 'allProteins'));
// });

// Route::get('/get-cart-item-details/{rowId}', [TestController::class, 'getCartItemDetails'])->name('cart.getDetails');

Route::get('/debug-cart', function () {
    return \Cart::content();
});
Route::get('/debug-session', function () {
    return session()->all();
});

        

        Route::resource('address', AddressCotroller::class);
        Route::post('store-address-from-checkout', [AddressCotroller::class, 'store_address_from_checkout'])->name('store-address-from-checkout');

        Route::get('cart', [CartController::class, 'cart'])->name('cart');
        Route::get('add-to-cart', [CartController::class, 'add_to_cart'])->name('add-to-cart');
        Route::get('remove-cart-item/{rowId}', [CartController::class, 'remove_cart_item'])->name('remove-cart-item');
        Route::get('cart-clear', [CartController::class, 'cart_clear'])->name('cart-clear');
        Route::get('cart-quantity-update', [CartController::class, 'cart_quantity_update'])->name('cart-quantity-update');
        // Route::get('/edit-cart-item/{rowId}', [CartController::class, 'editCartItem'])->name('cart.edit');


   
        Route::get('/get-cart-item-details/{rowId}', [CartController::class, 'getCartItemDetails'])->name('cart.getDetails');

//         Route::get('/test-details/{rowId}', function ($rowId) {
//     return response()->json(['message' => 'This is a test!', 'rowId' => $rowId]);
// })->name('cart.testDetails');

        // Route::middleware(['web'])->group(function () {
        //     Route::get('/edit-cart-item/{rowId}', [CartController::class, 'editCartItem']);
        // });

        // Route::post('/update-cart-item/{rowId}', [CartController::class, 'updateCartItem'])->name('cart.update');

        
        Route::get('load-cart-item', [CartController::class, 'load_cart_item'])->name('load-cart-item');
        Route::get('apply-coupon', [CartController::class, 'apply_coupon'])->name('apply-coupon');
        Route::get('apply-coupon-from-checkout', [CartController::class, 'apply_coupon_from_checkout'])->name('apply-coupon-from-checkout');

        Route::get('checkout', [PaymentController::class, 'checkout'])->name('checkout');
        Route::get('payment', [PaymentController::class, 'payment'])->name('payment');
        Route::get('handcash-payment', [PaymentController::class, 'handcash_payment'])->name('handcash-payment');
        Route::post('bank-payment', [PaymentController::class, 'bank_payment'])->name('bank-payment');
        Route::post('stripe-payment', [PaymentController::class, 'stripe_payment'])->name('stripe-payment');





        Route::post('pay-with-razorpay', [PaymentController::class, 'razorpay_payment'])->name('pay-with-razorpay');
        Route::post('pay-with-flutterwave', [PaymentController::class, 'razorpay_flutterwave'])->name('pay-with-flutterwave');

        Route::get('/pay-with-mollie', [PaymentController::class, 'pay_with_mollie'])->name('pay-with-mollie');
        Route::get('/mollie-payment-success', [PaymentController::class, 'mollie_payment_success'])->name('mollie-payment-success');
        Route::post('/pay-with-paystack', [PaymentController::class, 'pay_with_paystack'])->name('pay-with-paystack');

        Route::get('/pay-with-instamojo', [PaymentController::class, 'pay_with_instamojo'])->name('pay-with-instamojo');
        Route::get('/instamojo-response', [PaymentController::class, 'instamojo_response'])->name('instamojo-response');

        Route::get('/sslcommerz-pay',     [PaymentController::class, 'sslcommerz'])->name('sslcommerz-pay');
        Route::post('/sslcommerz-success', [PaymentController::class, 'sslcommerz_success'])->name('sslcommerz-success');
        Route::post('/sslcommerz-failed', [PaymentController::class,   'sslcommerz_failed'])->name('sslcommerz-failed');

        Route::get('/pay-with-paypal', [PaypalController::class, 'payWithPaypal'])->name('pay-with-paypal');
        Route::get('/paypal-payment-success', [PaypalController::class, 'paypalPaymentSuccess'])->name('paypal-payment-success');
        Route::get('/paypal-payment-cancled', [PaypalController::class, 'paypalPaymentCancled'])->name('paypal-payment-cancled');



     

        Route::get('/set-language/{code?}', [HomeController::class, 'setlanguage'])->name('set-language');
    });

    Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
        Route::get('/catering-requests', [CateringRequestController::class, 'index'])->name('admin.catering.index');
        Route::get('/catering-requests/{id}', [CateringRequestController::class, 'show'])->name('admin.catering.show'); // Plural
        Route::delete('/catering-requests/{id}', [CateringRequestController::class, 'destroy'])->name('admin.catering.destroy'); // ✅ Use plural here

        Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery.index');
        Route::post('/gallery/upload', [GalleryController::class, 'store'])->name('admin.gallery.store');
        Route::delete('/gallery/delete/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.delete');
    });

    // start admin routes
    Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
        // start auth route
        Route::get('login', [AdminLoginController::class, 'adminLoginPage'])->name('login');
        Route::post('login', [AdminLoginController::class, 'storeLogin'])->name('login');
        Route::post('logout', [AdminLoginController::class, 'adminLogout'])->name('logout');
        Route::get('forget-password', [AdminForgotPasswordController::class, 'forgetPassword'])->name('forget-password');
        Route::post('send-forget-password', [AdminForgotPasswordController::class, 'sendForgetEmail'])->name('send.forget.password');
        Route::get('reset-password/{token}', [AdminForgotPasswordController::class, 'resetPassword'])->name('reset.password');
        Route::post('password-store/{token}', [AdminForgotPasswordController::class, 'storeResetData'])->name('store.reset.password');

        Route::get('delivery-setting', [DeliverySettingController::class, 'edit'])->name('delivery-setting.edit');
        Route::post('delivery-setting', [DeliverySettingController::class, 'update'])->name('delivery-setting.update');

        // end auth route

        // Route::get('/catering-requests', [CateringRequestController::class, 'index'])->name('admin.catering.index');
        // Route::get('/catering-request/{id}', [CateringRequestController::class, 'show'])->name('admin.catering.show');

        Route::get('/', [DashboardController::class, 'dashobard'])->name('dashboard');
        
        Route::get('dashboard', [DashboardController::class, 'dashobard'])->name('dashboard');
        Route::get('profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::put('profile-update', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::resource('product-category', ProductCategoryController::class);
        Route::put('product-category-status/{id}', [ProductCategoryController::class, 'changeStatus'])->name('product.category.status');

        Route::resource('testimonial', TestimonialController::class);
        Route::put('testimonial-status/{id}', [TestimonialController::class, 'changeStatus'])->name('testimonial.status');

        Route::resource('our-chef', OurChefController::class);
        Route::put('our-chef-status/{id}', [OurChefController::class, 'changeStatus'])->name('our-chef.status');

        Route::resource('product', ProductController::class);
        Route::get('app.create-product-info', [ProductController::class, 'create'])->name('create-product-info');
        Route::put('product-status/{id}', [ProductController::class, 'changeStatus'])->name('product.status');

        Route::get('product-variant/{id}', [ProductVariantController::class, 'index'])->name('product-variant');
        Route::get('create-product-variant/{id}', [ProductVariantController::class, 'create'])->name('create-product-variant');
        Route::post('store-product-variant/{id}', [ProductVariantController::class, 'store'])->name('store-product-variant');
        Route::post('store-optional-item/{id}', [ProductVariantController::class, 'store_optional_item'])->name('store-optional-item');

        Route::get('product-gallery/{id}', [ProductGalleryController::class, 'index'])->name('product-gallery');
        Route::post('store-product-gallery', [ProductGalleryController::class, 'store'])->name('store-product-gallery');
        Route::delete('delete-product-image/{id}', [ProductGalleryController::class, 'destroy'])->name('delete-product-image');

        Route::resource('service', ServiceController::class);
        Route::put('service-status/{id}', [ServiceController::class, 'changeStatus'])->name('service.status');

        Route::resource('about-us', AboutUsController::class);
        Route::put('why-choose-us.update/{id}', [AboutUsController::class, 'why_choose_us'])->name('why-choose-us.update');
        Route::put('video-update/{id}', [AboutUsController::class, 'video_update'])->name('video-update');

        Route::resource('contact-us', ContactPageController::class);

        Route::resource('custom-page', CustomPageController::class);
        Route::put('custom-page-status/{id}', [CustomPageController::class, 'changeStatus'])->name('custom-page.status');

        Route::resource('terms-and-condition', TermsAndConditionController::class);
        Route::resource('privacy-policy', PrivacyPolicyController::class);

        Route::resource('blog-category', BlogCategoryController::class);
        Route::put('blog-category-status/{id}', [BlogCategoryController::class, 'changeStatus'])->name('blog.category.status');

        Route::resource('blog', BlogController::class);
        Route::put('blog-status/{id}', [BlogController::class, 'changeStatus'])->name('blog.status');

        Route::resource('popular-blog', PopularBlogController::class);
        Route::put('popular-blog-status/{id}', [PopularBlogController::class, 'changeStatus'])->name('popular-blog.status');

        Route::resource('blog-comment', BlogCommentController::class);
        Route::put('blog-comment-status/{id}', [BlogCommentController::class, 'changeStatus'])->name('blog-comment.status');

        Route::get('clear-database', [SettingController::class, 'showClearDatabasePage'])->name('clear-database');
        Route::delete('clear-database', [SettingController::class, 'clearDatabase'])->name('clear-database');

        Route::get('subscriber', [SubscriberController::class, 'index'])->name('subscriber');
        Route::delete('delete-subscriber/{id}', [SubscriberController::class, 'destroy'])->name('delete-subscriber');
        Route::post('specification-subscriber-email/{id}', [SubscriberController::class, 'specificationSubscriberEmail'])->name('specification-subscriber-email');
        Route::post('each-subscriber-email', [SubscriberController::class, 'eachSubscriberEmail'])->name('each-subscriber-email');

        Route::get('contact-message', [ContactMessageController::class, 'index'])->name('contact-message');
        Route::get('show-contact-message/{id}', [ContactMessageController::class, 'show'])->name('show-contact-message');
        
      
        Route::post('contact-message/{id}/reply', [ContactMessageController::class, 'reply'])
        ->name('contact-message.reply');



        Route::delete('delete-contact-message/{id}', [ContactMessageController::class, 'destroy'])->name('delete-contact-message');
        Route::put('enable-save-contact-message', [ContactMessageController::class, 'handleSaveContactMessage'])->name('enable-save-contact-message');

        Route::get('email-configuration', [EmailConfigurationController::class, 'index'])->name('email-configuration');
        Route::put('update-email-configuraion', [EmailConfigurationController::class, 'update'])->name('update-email-configuraion');

        Route::get('email-template', [EmailTemplateController::class, 'index'])->name('email-template');
        Route::get('edit-email-template/{id}', [EmailTemplateController::class, 'edit'])->name('edit-email-template');
        Route::put('update-email-template/{id}', [EmailTemplateController::class, 'update'])->name('update-email-template');

        Route::get('general-setting', [SettingController::class, 'index'])->name('general-setting');
        Route::put('update-general-setting', [SettingController::class, 'updateGeneralSetting'])->name('update-general-setting');
        Route::put('update-theme-color', [SettingController::class, 'updateThemeColor'])->name('update-theme-color');
        Route::put('update-logo-favicon', [SettingController::class, 'updateLogoFavicon'])->name('update-logo-favicon');
        Route::put('update-cookie-consent', [SettingController::class, 'updateCookieConset'])->name('update-cookie-consent');
        Route::put('update-google-recaptcha', [SettingController::class, 'updateGoogleRecaptcha'])->name('update-google-recaptcha');
        Route::put('update-facebook-comment', [SettingController::class, 'updateFacebookComment'])->name('update-facebook-comment');
        Route::put('update-tawk-chat', [SettingController::class, 'updateTawkChat'])->name('update-tawk-chat');
        Route::put('update-google-analytic', [SettingController::class, 'updateGoogleAnalytic'])->name('update-google-analytic');
        Route::put('update-custom-pagination', [SettingController::class, 'updateCustomPagination'])->name('update-custom-pagination');
        Route::put('update-social-login', [SettingController::class, 'updateSocialLogin'])->name('update-social-login');
        Route::put('update-facebook-pixel', [SettingController::class, 'updateFacebookPixel'])->name('update-facebook-pixel');
        Route::put('update-pusher', [SettingController::class, 'updatePusher'])->name('update-pusher');

        Route::resource('admin', AdminController::class);
        Route::put('admin-status/{id}', [AdminController::class, 'changeStatus'])->name('admin-status');

        Route::resource('faq', FaqController::class);
        Route::put('faq-status/{id}', [FaqController::class, 'changeStatus'])->name('faq-status');

        Route::get('product-review', [ProductReviewController::class, 'index'])->name('product-review');
        Route::put('product-review-status/{id}', [ProductReviewController::class, 'changeStatus'])->name('product-review-status');
        Route::get('show-product-review/{id}', [ProductReviewController::class, 'show'])->name('show-product-review');
        Route::delete('delete-product-review/{id}', [ProductReviewController::class, 'destroy'])->name('delete-product-review');

        Route::get('customer-list', [CustomerController::class, 'index'])->name('customer-list');
        Route::get('customer-show/{id}', [CustomerController::class, 'show'])->name('customer-show');
        Route::put('customer-status/{id}', [CustomerController::class, 'changeStatus'])->name('customer-status');
        Route::delete('customer-delete/{id}', [CustomerController::class, 'destroy'])->name('customer-delete');
        Route::get('pending-customer-list', [CustomerController::class, 'pendingCustomerList'])->name('pending-customer-list');
        Route::get('send-email-to-all-customer', [CustomerController::class, 'sendEmailToAllUser'])->name('send-email-to-all-customer');
        Route::post('send-mail-to-all-user', [CustomerController::class, 'sendMailToAllUser'])->name('send-mail-to-all-user');
        Route::post('send-mail-to-single-user/{id}', [CustomerController::class, 'sendMailToSingleUser'])->name('send-mail-to-single-user');

        Route::resource('error-page', ErrorPageController::class);

        Route::get('maintainance-mode', [ContentController::class, 'maintainanceMode'])->name('maintainance-mode');
        Route::put('maintainance-mode-update', [ContentController::class, 'maintainanceModeUpdate'])->name('maintainance-mode-update');
        Route::get('topbar-contact', [ContentController::class, 'headerPhoneNumber'])->name('topbar-contact');
        Route::put('update-topbar-contact', [ContentController::class, 'updateHeaderPhoneNumber'])->name('update-topbar-contact');
        Route::get('default-avatar', [ContentController::class, 'defaultAvatar'])->name('default-avatar');
        Route::post('update-default-avatar', [ContentController::class, 'updateDefaultAvatar'])->name('update-default-avatar');
        Route::get('app-section', [ContentController::class, 'app_section'])->name('app-section');
        Route::post('update-app-section', [ContentController::class, 'update_app_section'])->name('update-app-section');

        Route::get('advertisement', [AdvertisementController::class, 'index'])->name('advertisement');
        Route::post('store-advertisement', [AdvertisementController::class, 'store'])->name('store-advertisement');
        Route::put('update-advertisement/{id}', [AdvertisementController::class, 'update'])->name('update-advertisement');
        Route::delete('advertisement-delete/{id}', [AdvertisementController::class, 'destroy'])->name('advertisement-delete');

        Route::get('login-page', [ContentController::class, 'loginPage'])->name('login-page');
        Route::post('update-login-page', [ContentController::class, 'updateloginPage'])->name('update-login-page');

        Route::get('breadcrumb-image', [ContentController::class, 'breadcrumb_image'])->name('breadcrumb-image');
        Route::post('update-breadcrumb-image', [ContentController::class, 'update_breadcrumb_image'])->name('update-breadcrumb-image');

        Route::get('seo-setup', [ContentController::class, 'seoSetup'])->name('seo-setup');
        Route::put('update-seo-setup/{id}', [ContentController::class, 'updateSeoSetup'])->name('update-seo-setup');
        Route::get('get-seo-setup/{id}', [ContentController::class, 'getSeoSetup'])->name('get-seo-setup');

        Route::get('payment-method', [PaymentMethodController::class, 'index'])->name('payment-method');
        Route::put('update-paypal', [PaymentMethodController::class, 'updatePaypal'])->name('update-paypal');
        Route::put('update-stripe', [PaymentMethodController::class, 'updateStripe'])->name('update-stripe');
        Route::put('update-razorpay', [PaymentMethodController::class, 'updateRazorpay'])->name('update-razorpay');
        Route::put('update-bank', [PaymentMethodController::class, 'updateBank'])->name('update-bank');
        Route::put('update-mollie', [PaymentMethodController::class, 'updateMollie'])->name('update-mollie');
        Route::put('update-paystack', [PaymentMethodController::class, 'updatePayStack'])->name('update-paystack');
        Route::put('update-flutterwave', [PaymentMethodController::class, 'updateflutterwave'])->name('update-flutterwave');
        Route::put('update-instamojo', [PaymentMethodController::class, 'updateInstamojo'])->name('update-instamojo');
        Route::put('update-cash-on-delivery', [PaymentMethodController::class, 'updateCashOnDelivery'])->name('update-cash-on-delivery');
        Route::put('update-sslcommerz', [PaymentMethodController::class, 'updateSslcommerz'])->name('update-sslcommerz');

        Route::resource('slider', SliderController::class);
        Route::put('slider-status/{id}', [SliderController::class, 'changeStatus'])->name('slider-status');
        Route::post('update-slider-image', [SliderController::class, 'update_slider_image'])->name('update-slider-image');

        Route::resource('counter', CounterController::class);
        Route::post('update-counter-image', [CounterController::class, 'update_counter_image'])->name('update-counter-image');

        Route::resource('partner', PartnerController::class);
        Route::post('update-partner-image', [PartnerController::class, 'update_partner_image'])->name('update-partner-image');

        Route::get('menu-visibility', [MenuVisibilityController::class, 'index'])->name('menu-visibility');
        Route::put('update-menu-visibility/{id}', [MenuVisibilityController::class, 'update'])->name('update-menu-visibility');

        Route::get('all-order', [OrderController::class, 'index'])->name('all-order');
        Route::get('pending-order', [OrderController::class, 'pendingOrder'])->name('pending-order');
        Route::get('pregress-order', [OrderController::class, 'pregressOrder'])->name('pregress-order');
        Route::get('delivered-order', [OrderController::class, 'deliveredOrder'])->name('delivered-order');
        Route::get('completed-order', [OrderController::class, 'completedOrder'])->name('completed-order');
        Route::get('declined-order', [OrderController::class, 'declinedOrder'])->name('declined-order');
        Route::get('cash-on-delivery', [OrderController::class, 'cashOnDelivery'])->name('cash-on-delivery');
        Route::get('order-show/{id}', [OrderController::class, 'show'])->name('order-show');
        Route::delete('delete-order/{id}', [OrderController::class, 'destroy'])->name('delete-order');
        Route::put('update-order-status/{id}', [OrderController::class, 'updateOrderStatus'])->name('update-order-status');

        Route::get('reservation', [OrderController::class, 'reservation'])->name('reservation');
        Route::put('update-reservation-status/{id}', [OrderController::class, 'update_reservation_status'])->name('update-reservation-status');
        Route::delete('delete-reservation/{id}', [OrderController::class, 'delete_reservation'])->name('delete-reservation');

        Route::resource('coupon', CouponController::class);
        Route::put('coupon-status/{id}', [CouponController::class, 'changeStatus'])->name('coupon-status');

        Route::resource('footer', FooterController::class);
        Route::resource('social-link', FooterSocialLinkController::class);

        Route::get('admin-language/{code?}', [LanguageController::class, 'adminLnagugae'])->name('admin-language');
        Route::post('update-admin-language/{code}', [LanguageController::class, 'updateAdminLanguage'])->name('update-admin-language');
        Route::get('admin-validation-language/{code}', [LanguageController::class, 'adminValidationLnagugae'])->name('admin-validation-language');
        Route::post('update-admin-validation-language/{code}', [LanguageController::class, 'updateAdminValidationLnagugae'])->name('update-admin-validation-language');

        Route::get('website-language/{code}', [LanguageController::class, 'websiteLanguage'])->name('website-language');
        Route::post('update-language/{code}', [LanguageController::class, 'updateLanguage'])->name('update-language');
        Route::get('website-validation-language/{code}', [LanguageController::class, 'websiteValidationLanguage'])->name('website-validation-language');
        Route::post('update-validation-language/{code}', [LanguageController::class, 'updateValidationLanguage'])->name('update-validation-language');

        Route::get('homepage', [HomepageController::class, 'homepage'])->name('homepage');
        Route::put('update-homepage', [HomepageController::class, 'update_homepage'])->name('update-homepage');

        Route::resource('delivery-area', DeliveryAreaCotroller::class);

        Route::resource('languages', LanguageManagerController::class);

        Route::controller(BlogTranslationController::class)->name('translation.blog.')->group(function () {
            Route::get('translation/blog/{code}/{blog}', 'create')->name('create');
            Route::put('translation/blog/save', 'update')->name('store');
        });

        Route::controller(CategoryTranslationController::class)->name('translation.category.')->group(function () {
            Route::get('translation/category/{code}/{id}', 'create')->name('create');
            Route::put('translation/category/save', 'update')->name('store');
        });

        Route::controller(AboutUsTranslationController::class)->name('translation.about-us.')->group(function () {
            Route::get('translation/about-us/{code}', 'create')->name('create');
            Route::put('translation/about-us/save', 'update')->name('store');
        });

        Route::controller(TermsAndConditionTranslationController::class)->name('translation.terms-and-condition.')->group(function () {
            Route::get('translation/terms-and-condition/{code}', 'create')->name('create');
            Route::put('translation/terms-and-condition/save', 'update')->name('store');
        });

        Route::controller(PrivacyPolicyTranslationController::class)->name('translation.privacy-policy.')->group(function () {
            Route::get('translation/privacy-policy/{code}', 'create')->name('create');
            Route::put('translation/privacy-policy/save', 'update')->name('store');
        });

        Route::controller(ProductTranslationController::class)->name('translation.product.')->group(function () {
            Route::get('translation/product/{code}/{id}', 'create')->name('create');
            Route::put('translation/product/{code}/{id}', 'update')->name('update');
        });

        Route::controller(ProductCategoryTranslationController::class)->name('translation.product-category.')->group(function () {
            Route::get('translation/product-category/{code}/{id}', 'create')->name('create');
            Route::put('translation/product-category/save', 'update')->name('store');
        });

        Route::controller(ServiceTranslationController::class)->name('translation.service.')->group(function () {
            Route::get('translation/service/{code}/{id}', 'create')->name('create');
            Route::put('translation/service/{code}/{id}', 'update')->name('update');
        });

        Route::controller(SettingsTranslationController::class)->name('translation.settings.')->group(function () {
            Route::get('translation/app-section/{code}', 'create')->name('app.create');
            Route::put('translation/app-section/{code}', 'update')->name('app.update');
        });

        Route::controller(HomepageTranslationController::class)->name('translation.homepage.')->group(function () {
            Route::get('translation/homepage/{code}', 'create')->name('create');
            Route::put('translation/homepage/{code}', 'update')->name('update');
        });

        Route::controller(AdvertisementTranslationController::class)->name('translation.advertisement.')->group(function () {
            Route::get('translation/advertisement/{code}/{id}', 'create')->name('create');
            Route::put('translation/advertisement/{code}/{id}', 'update')->name('update');
        });

        Route::controller(CounterTranslationController::class)->name('translation.counter.')->group(function () {
            Route::get('translation/counter/{code}/{id}', 'create')->name('create');
            Route::put('translation/counter/{code}/{id}', 'update')->name('update');
        });

        Route::controller(FooterTranslationController::class)->name('translation.footer.')->group(function () {
            Route::get('translation/footer/{code}/{id}', 'create')->name('create');
            Route::put('translation/footer/{code}/{id}', 'update')->name('update');
        });

        Route::controller(TestimonialTranslationController::class)->name('translation.testimonial.')->group(function () {
            Route::get('translation/testimonial/{code}/{id}', 'create')->name('create');
            Route::put('translation/testimonial/{code}/{id}', 'update')->name('update');
        });

        Route::controller(OurChefTranslationController::class)->name('translation.our-chef.')->group(function () {
            Route::get('translation/our-chef/{code}/{id}', 'create')->name('create');
            Route::put('translation/our-chef/{code}/{id}', 'update')->name('update');
        });

        Route::controller(CustomPageTranslationController::class)->name('translation.custom-page.')->group(function () {
            Route::get('translation/custom-page/{code}/{id}', 'create')->name('create');
            Route::put('translation/custom-page/{code}/{id}', 'update')->name('update');
        });

        Route::controller(FaqTranslationController::class)->name('translation.faq.')->group(function () {
            Route::get('translation/faq/{code}/{id}', 'create')->name('create');
            Route::put('translation/faq/{code}/{id}', 'update')->name('update');
        });
    });

Route::get('migrate', function () {
    try {
        BlogTranslation::all();
        return redirect()->back();
    } catch (\Throwable $th) {
        Artisan::call('migrate');
        return redirect()->back();
    }
});

});
