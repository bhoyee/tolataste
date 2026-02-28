<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Category;
use App\Models\MaintainanceText;
use App\Models\Product;
use App\Models\BannerImage;
use App\Models\Service;
use App\Models\Blog;
use App\Models\AboutUs;
use App\Models\ContactPage;
use App\Models\ErrorPage;
use App\Models\PopularPost;
use App\Models\BlogCategory;
use App\Models\BreadcrumbImage;
use App\Models\CustomPagination;
use App\Models\Faq;
use App\Models\CustomPage;
use App\Models\TermsAndCondition;
use App\Models\Subscriber;
use App\Mail\SubscriptionVerification;
use App\Mail\ContactMessageInformation;
use App\Helpers\MailHelper;
use App\Models\EmailTemplate;
use App\Models\ProductReview;
use App\Models\ProductGallery;
use App\Models\Setting;
use App\Models\ContactMessage;
use App\Models\BlogComment;
use App\Models\Testimonial;
use App\Models\GoogleRecaptcha;
use App\Models\Order;
use App\Models\SeoSetting;
use App\Rules\Captcha;
use App\Models\FooterSocialLink;
use App\Models\AnnouncementModal;
use App\Models\MenuVisibility;
use App\Models\GoogleAnalytic;
use App\Models\FacebookPixel;
use App\Models\TawkChat;
use App\Models\CookieConsent;
use App\Models\FooterLink;
use App\Models\Footer;
use App\Models\Homepage;
use App\Models\OurChef;
use App\Models\Counter;
use App\Models\Language;
use App\Models\Gallery; 
use Mail;
use Str;
use Session;
use Cart;
use Carbon\Carbon;
use Route;

class HomeController extends Controller
{

    public function index()
    {
        $seo_setting = SeoSetting::find(1);

        $homepage = Homepage::with('translation')->first();
        $setting = Setting::with('translation')->first();

        $sliders = Slider::where('status', 1)->orderBy('serial', 'asc')->get();
        $slider_background = $setting->slider_background;
        $foreground_image_one = $setting->slider_foreground_one;
        $foreground_image_two = $setting->slider_foreground_two;

        $slider = (object) array(
            'slider_background' => $slider_background,
            'foreground_image_one' => $foreground_image_one,
            'foreground_image_two' => $foreground_image_two,
            'sliders' => $sliders
        );

        $services = Service::with('translation')->where('status', 1)->get();
        $service = (object) array(
            'status' => $homepage->service_status == 1 ? true : false,
            'services' => $services
        );

        $today_special_products = Product::where(['status' => 1, 'today_special' => 1])->get()->take($homepage->today_special_item);
        $today_special_product = (object) array(
            'status' => $homepage->today_special_status == 1 ? true : false,
            'image' => $homepage->today_special_image,
            'short_title' => $homepage->today_special_short_title_translated,
            'long_title' => $homepage->today_special_long_title_translated,
            'description' => $homepage->today_special_description_translated,
            'products' => $today_special_products
        );

        $categories = Category::with('translation')->where('status', 1)->where('show_homepage', 1)->get();
        $custom_product_ids = array();
        foreach ($categories as $category) {
            $products = Product::with('translation')->where(['status' => 1, 'category_id' => $category->id])->select('id', 'status', 'category_id')->get()->take($homepage->menu_item);
            foreach ($products as $product) {
                $custom_product_ids[] = $product->id;
            }
        }
        $products = Product::with('category.translation', 'translation')->where(['status' => 1])->whereIn('id', $custom_product_ids)->get();
        $menu_section = (object) array(
            'status' => $homepage->menu_status == 1 ? true : false,
            'short_title' => $homepage->menu_short_title_translated,
            'long_title' => $homepage->menu_long_title_translated,
            'description' => $homepage->menu_description_translated,
            'left_image' => $homepage->menu_left_image,
            'right_image' => $homepage->menu_right_image,
            'categories' => $categories,
            'products' => $products
        );

        $ad_banners = BannerImage::with('translation')->where('status', 1)->orderBy('serial', 'asc')->get()->take($homepage->total_advertisement_item);
        $advertisement = (object) array(
            'status' => $homepage->advertisement_status == 1 ? true : false,
            'banners' => $ad_banners,
        );

        $chefs = OurChef::with('translation')->where('status', 1)->get()->take($homepage->chef_item);
        $our_chef = (object) array(
            'status' => $homepage->chef_status == 1 ? true : false,
            'short_title' => $homepage->chef_short_title_translated,
            'long_title' => $homepage->chef_long_title_translated,
            'description' => $homepage->chef_description_translated,
            'left_image' => $homepage->chef_left_image,
            'right_image' => $homepage->chef_right_image,
            'chefs' => $chefs
        );

        $app_section = (object) array(
            'status' => $homepage->mobile_app_status == 1 ? true : false,
            'title' => $setting->app_title_translated,
            'description' => $setting->app_description_translated,
            'play_store_link' => $setting->play_store_link,
            'app_store_link' => $setting->app_store_link,
            'image' => $setting->app_image,
            'home1_background' => $setting->app_background_one,
            'home2_background' => $setting->app_background_two,
        );

        $counters = Counter::with('translation')->get();
        $counter = (object) array(
            'status' => $homepage->counter_status == 1 ? true : false,
            'background_image' => $setting->counter_background,
            'counters' => $counters
        );

        $testimonials = Testimonial::with('translation')->where('status', 1)->get()->take($homepage->testimonial_item);
        $testimonial = (object) array(
            'status' => $homepage->testimonial_status == 1 ? true : false,
            'short_title' => $homepage->testimonial_short_title_translated,
            'long_title' => $homepage->testimonial_long_title_translated,
            'description' => $homepage->testimonial_description_translated,
            'testimonials' => $testimonials
        );

        $blogs = Blog::with('category', 'translation')->where(['status' => 1, 'show_homepage' => 1])->get()->take($homepage->blog_item);
        $blog = (object) array(
            'status' => $homepage->blog_status == 1 ? true : false,
            'short_title' => $homepage->blog_short_title_translated,
            'long_title' => $homepage->blog_long_title_translated,
            'description' => $homepage->blog_description_translated,
            'home1_background' => $homepage->blog_background,
            'home2_background' => $homepage->blog_background_2,
            'blogs' => $blogs
        );

        $about_us = AboutUs::with('translation')->first();
        $video_section = (object) array(
            'status' => $homepage->video_section_status == 1 ? true : false,
            'title' => $about_us->video_title_translated,
            'video_id' => $about_us->video_id,
            'background_image' => $about_us->video_background,
        );

        $items = array(
            (object) array(
                'title' => $about_us->title_one_translated,
                'icon' => $about_us->icon_one,
            ),
            (object) array(
                'title' => $about_us->title_two_translated,
                'icon' => $about_us->icon_two,
            ),
            (object) array(
                'title' => $about_us->title_three_translated,
                'icon' => $about_us->icon_three,
            ),
            (object) array(
                'title' => $about_us->title_four_translated,
                'icon' => $about_us->icon_four,
            )
        );
        $why_choose_us = (object) array(
            'status' => $homepage->why_choose_us_status == 1 ? true : false,
            'short_title' => $about_us->why_choose_us_short_title_translated,
            'long_title' => $about_us->why_choose_us_long_title_translated,
            'description' => $about_us->why_choose_us_description_translated,
            'background_image' => $about_us->why_choose_us_background,
            'foreground_image_one' => $about_us->why_choose_us_foreground_one,
            'foreground_image_two' => $about_us->why_choose_us_foreground_two,
            'items' => $items
        );

        return view('index')->with([
            'seo_setting' => $seo_setting,
            'slider' => $slider,
            'service' => $service,
            'today_special_product' => $today_special_product,
            'menu_section' => $menu_section,
            'advertisement' => $advertisement,
            'our_chef' => $our_chef,
            'app_section' => $app_section,
            'counter' => $counter,
            'testimonial' => $testimonial,
            'blog' => $blog,
            'video_section' => $video_section,
            'why_choose_us' => $why_choose_us
        ]);
    }

    public function about_us()
    {
        $homepage = Homepage::first();
        $about_us = AboutUs::with('translation')->first();
        $setting = Setting::first();

        $about = (object) array(
            'short_title' => $about_us->about_us_short_title_translated,
            'long_title' => $about_us->about_us_long_title_translated,
            'image' => $about_us->about_us_image,
            'about_us' => $about_us->about_us_translated,
        );

        $video_section = (object) array(
            'title' => $about_us->video_title_translated,
            'video_id' => $about_us->video_id,
            'background_image' => $about_us->video_background,
        );

        $items = array(
            (object) array(
                'title' => $about_us->title_one_translated,
                'icon' => $about_us->icon_one,
            ),
            (object) array(
                'title' => $about_us->title_two_translated,
                'icon' => $about_us->icon_two,
            ),
            (object) array(
                'title' => $about_us->title_three_translated,
                'icon' => $about_us->icon_three,
            ),
            (object) array(
                'title' => $about_us->title_four_translated,
                'icon' => $about_us->icon_four,
            )
        );

        $why_choose_us = (object) array(
            'short_title' => $about_us->why_choose_us_short_title_translated,
            'long_title' => $about_us->why_choose_us_long_title_translated,
            'description' => $about_us->why_choose_us_description_translated,
            'background_image' => $about_us->why_choose_us_background,
            'foreground_image_one' => $about_us->why_choose_us_foreground_one,
            'foreground_image_two' => $about_us->why_choose_us_foreground_two,
            'items' => $items
        );

        $counters = Counter::with('translation')->get();
        $counter = (object) array(
            'background_image' => $setting->counter_background,
            'counters' => $counters
        );

        $testimonials = Testimonial::with('translation')->where('status', 1)->get()->take($homepage->testimonial_item);
        $testimonial = (object) array(
            'short_title' => $homepage->testimonial_short_title_translated,
            'long_title' => $homepage->testimonial_long_title_translated,
            'description' => $homepage->testimonial_description_translated,
            'testimonials' => $testimonials
        );

        $seo_setting = SeoSetting::find(2);

        return view('about_us')->with([
            'seo_setting' => $seo_setting,
            'about_us' => $about,
            'video_section' => $video_section,
            'why_choose_us' => $why_choose_us,
            'counter' => $counter,
            'testimonial' => $testimonial,
        ]);
    }


public function contact_us(Request $request)
{
    if ($request->filled('websitess')) {
        // \Log::warning('🚫 Spam detected via honeypot.', ['ip' => $request->ip()]);
        return redirect()->back()->withErrors(['error' => 'Spam detected.'])->withInput();
    }
    $contact_setting = \App\Models\Setting::first();
    $contact = \App\Models\ContactPage::first();
    $recaptcha_setting = \App\Models\GoogleRecaptcha::first();
    $seo_setting = \App\Models\SeoSetting::find(3);
    return view('contact_us')->with([
        'seo_setting' => $seo_setting,
        'contact' => $contact,
        'recaptcha_setting' => $recaptcha_setting,
        'contact_setting' => $contact_setting,
    ]);
}

public function send_contact_message(Request $request)
{
    
      if ($request->filled('websitess')) {
        \Log::warning('🚫 Spam detected via honeypot.', ['ip' => $ip]);
        return redirect()->back()->withErrors(['error' => 'Spam detected.'])->withInput();
    }
    // 🧠 Rate limit per IP
    $ip = $request->ip();
    $key = 'contact_form_' . $ip;

    if (cache()->has($key)) {
        return redirect()->back()->withErrors(['error' => 'Please wait a minute before submitting again.'])->withInput();
    }

    cache()->put($key, true, now()->addMinutes(1)); // Block resubmissions for 1 min

    // 🕳️ Honeypot field check
  

    // ✅ Validation
    $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:1000',
    ], [
        'name.required' => __('Name is required'),
        'email.required' => __('Email is required'),
        'subject.required' => __('Subject is required'),
        'message.required' => __('Message is required'),
    ]);

    // 🧼 Basic spam keyword filter
    $spam_keywords = ['viagra', 'casino', 'porn', 'sex', 'bitcoin'];
    foreach ($spam_keywords as $word) {
        if (str_contains(strtolower($request->message), $word)) {
            \Log::warning('❌ Spam keyword blocked', ['ip' => $ip, 'word' => $word]);
            return redirect()->back()->withErrors(['error' => 'Spam content detected.'])->withInput();
        }
    }

    // 💾 Save message without mass assignment
    $setting = Setting::first();
    if ($setting->enable_save_contact_message == 1) {
        $contact = new \App\Models\ContactMessage();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->subject = $request->subject;
        $contact->phone = $request->phone;
        $contact->message = $request->message;
        $contact->save();
    }

    // 📧 Send notification email
    MailHelper::setMailConfig();
    $template = \App\Models\EmailTemplate::find(2);

    $emailBody = str_replace(
        ['{{name}}', '{{email}}', '{{phone}}', '{{subject}}', '{{message}}'],
        [$request->name, $request->email, $request->phone, $request->subject, $request->message],
        $template->description
    );

    Mail::to($setting->contact_email)->send(new \App\Mail\ContactMessageInformation($emailBody, $template->subject));

    return redirect()->back()->with([
        'messege' => __('Message sent successfully'),
        'alert-type' => 'success'
    ]);
}



    public function blogs(Request $request)
    {
        $paginateQty = CustomPagination::whereId('1')->first()->qty;
        $blogs = Blog::with('translation', 'category.translation')->orderBy('id', 'desc')->where(['status' => 1]);

        if ($request->search) {
            $blogs = $blogs->where('title', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->category) {
            $category = BlogCategory::with('translation')->where('slug', $request->category)->first();
            $blogs = $blogs->where('blog_category_id', $category->id);
        }

        $blogs = $blogs->paginate($paginateQty);

        $seo_setting = SeoSetting::find(6);

        return view('blog')->with(['blogs' => $blogs, 'seo_setting' => $seo_setting]);
    }

    public function show_blog($slug)
    {
        $blog = Blog::with('category', 'category.translation', 'translation')->where(['status' => 1, 'slug' => $slug])->first();
        if (!$blog) {
            abort(404);
        }
        $popular_posts = PopularPost::with('blog')->where(['status' => 1])->get();

        $blog_arr = array();
        foreach ($popular_posts as $popular_post) {
            $blog_arr[] = $popular_post->blog_id;
        }

        $popular_posts = Blog::with('translation')->orderBy('id', 'desc')->where(['status' => 1])->whereIn('id', $blog_arr)->get();

        $categories = BlogCategory::with('translation')->where(['status' => 1])->get();
        $recaptcha_setting = GoogleRecaptcha::first();
        $active_comments = BlogComment::where('blog_id', $blog->id)->orderBy('id', 'desc')->get();

        $next_blog = Blog::with('translation')->where('id', '>', $blog->id)->orderBy('id', 'asc')->first();
        $prev_blog = Blog::with('translation')->where('id', '<', $blog->id)->orderBy('id', 'desc')->first();

        return view('blog_detail')->with(['blog' => $blog, 'popular_posts' => $popular_posts, 'categories' => $categories, 'recaptcha_setting' => $recaptcha_setting, 'active_comments' => $active_comments, 'next_blog' => $next_blog, 'prev_blog' => $prev_blog]);
    }

    public function blog_comment(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required',
            'blog_id' => 'required',
            'g-recaptcha-response' => new Captcha()
        ];

        $customMessages = [
            'name.required' => trans('Name is required'),
            'email.required' => trans('Email is required'),
            'comment.required' => trans('Comment is required'),
        ];
        $this->validate($request, $rules, $customMessages);

        $comment = new BlogComment();
        $comment->blog_id = $request->blog_id;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->save();
        $notification = trans('Blog comment submited successfully');
        return response()->json(['status' => 1, 'message' => $notification], 200);
    }


    public function faq()
    {
        $faqs = FAQ::with('translation')->orderBy('id', 'desc')->where('status', 1)->get();
        $recaptcha_setting = GoogleRecaptcha::first();

        return view('faq')->with(['faqs' => $faqs, 'recaptcha_setting' => $recaptcha_setting]);
    }

    public function gallery()
    {
        $galleryImages = Gallery::all(); // Assuming you have a Gallery model
        return view('gallery', compact('galleryImages'));
    }
    

    public function custom_page($slug)
    {
        $page = CustomPage::where(['slug' => $slug, 'status' => 1])->first();
        return view('custom_page')->with(['page' => $page]);
    }

    public function terms_and_condition()
    {
        $terms_conditions = TermsAndCondition::with('translation')->first()?->terms_and_condition_translated;
        return view('terms_and_conditions')->with(['terms_conditions' => $terms_conditions]);
    }

    public function privacy_policy()
    {
        $privacy_policy = TermsAndCondition::with('translation')->first()?->privacy_policy_translated;
        return view('privacy_policy')->with(['privacy_policy' => $privacy_policy]);
    }

    public function products(Request $request)
    {
        $categories = Category::with('translation')->where(['status' => 1])->get();
        $paginate_qty = CustomPagination::whereId('2')->first()->qty;
        // $products = Product::with('category.translation', 'translation')->orderBy('id', 'desc')->where(['status' => 1]);
        $products = Product::with('category.translation', 'translation')
    ->orderBy('id', 'desc')
    ->where('status', 1)
    ->whereHas('category', function ($query) {
        $query->where('slug', '!=', 'offer'); // exclude "offer" category
    });


        if ($request->category) {
            $category = Category::where('slug', $request->category)->first();
            $products = $products->where('category_id', $category->id);
        }

        if ($request->search) {
            $products = $products->where('name', 'LIKE', '%' . $request->search . '%');
        }

        $products = $products->paginate($paginate_qty);
        $products = $products->appends($request->all());

        $seo_setting = SeoSetting::find(9);

        return view('product')->with([
            'seo_setting' => $seo_setting,
            'categories' => $categories,
            'products' => $products,
        ]);
    }



public function show_product($slug)
{
    $product = Product::with('category.translation', 'translation')->where(['status' => 1, 'slug' => $slug])->first();
    if (!$product) {
        abort(404);
    }

    $review_paginate_qty = CustomPagination::whereId('5')->first()->qty;

    $product_reviews = ProductReview::with('user')->where(['status' => 1, 'product_id' => $product->id])->paginate($review_paginate_qty);
    $gellery = ProductGallery::where('product_id', $product->id)->get();

    $size_variants = $product->size_variant ? json_decode($product->size_variant) : [];
    $optional_items = $product->optional_item ? json_decode($product->optional_item) : [];
    $protein_items = $product->protein_item ? json_decode($product->protein_item, true) : [];

    $soup_items = $product->soup_item ? json_decode($product->soup_item, true) : [];
    $wrap_items = $product->wrap_item ? json_decode($product->wrap_item, true) : [];
    $drink_items = $product->drink_item ? json_decode($product->drink_item, true) : [];

    // âœ… Store in session for later use in editCartItem
    Session::put("protein_items_{$product->id}", $protein_items);

    // Related, Recaptcha, etc...
    $related_products = Product::with('category.translation', 'translation')
        ->where(['category_id' => $product->category_id, 'status' => 1])
        ->where('id', '!=', $product->id)
        ->get()
        ->take(10);

    $recaptcha_setting = GoogleRecaptcha::first();
    $setting = Setting::first();
    $default_profile = $setting->default_avatar;

    return view('product_detail')->with([
        'product' => $product,
        'size_variants' => $size_variants,
        'optional_items' => $optional_items,
        'protein_items' => $protein_items,
        'soup_items' => $soup_items, // ðŸ›  pass soup
        'wrap_items' => $wrap_items, // ðŸ›  pass wrap
        'drink_items' => $drink_items, // ðŸ›  pass drink
        'gellery' => $gellery,
        'product_reviews' => $product_reviews,
        'related_products' => $related_products,
        'recaptcha_setting' => $recaptcha_setting,
        'default_profile' => $default_profile,
        'review_paginate_qty' => $review_paginate_qty
    ]);
}


public function load_product_model($product_id)
{
    $product = Product::with('category.translation', 'translation')
        ->where(['status' => 1, 'id' => $product_id])
        ->first();

    if (!$product) {
        return response()->json(['message' => trans('Something went wrong')], 403);
    }

    $size_variants = $product->size_variant ? json_decode($product->size_variant) : [];
    $optional_items = $product->optional_item ? json_decode($product->optional_item) : [];

    $protein_items = $product->protein_item ? json_decode($product->protein_item, true) : [];
    $soup_items = $product->soup_item ? json_decode($product->soup_item, true) : [];
    $wrap_items = $product->wrap_item ? json_decode($product->wrap_item, true) : [];
    $drink_items = $product->drink_item ? json_decode($product->drink_item, true) : [];

    return view('product_popup_view')->with([
        'product' => $product,
        'size_variants' => $size_variants,
        'optional_items' => $optional_items,
        'protein_items' => $protein_items,
        'soup_items' => $soup_items,
        'wrap_items' => $wrap_items,
        'drink_items' => $drink_items,
    ]);
}

    
    

    public function productReviewList($id)
    {
        $reviews = ProductReview::with('user')->where(['product_id' => $id, 'status' => 1])->paginate(10);
        return response()->json(['reviews' => $reviews]);
    }

    public function subscribeRequest(Request $request)
    {
           // 🛡️ Honeypot check – this field should stay empty; if it's filled, likely a bot
            if ($request->filled('website')) {
                return response()->json(['message' => 'Spam detected.'], 422);
            }


        if ($request->email != null) {
            $isExist = Subscriber::where('email', $request->email)->count();
            if ($isExist == 0) {
                $subscriber = new Subscriber();
                $subscriber->email = $request->email;
                $subscriber->verified_token = random_int(100000, 999999);
                $subscriber->save();
                MailHelper::setMailConfig();
                $template = EmailTemplate::where('id', 3)->first();
                $message = $template->description;
                $subject = $template->subject;
                Mail::to($subscriber->email)->send(new SubscriptionVerification($subscriber, $message, $subject));

                return response()->json(['message' => trans('Subscription successfully, please verified your email')]);
            } else {
                return response()->json(['message' => trans('Email already exist')], 403);
            }
        } else {
            return response()->json(['message' => trans('Email Field is required')], 403);
        }
    }

    public function subscriberVerifcation(Request $request, $token)
    {
        $subscriber = Subscriber::where(['verified_token' => $token])->first();
        if ($subscriber) {
            $subscriber->verified_token = null;
            $subscriber->is_verified = 1;
            $subscriber->save();

            $notification =  trans('Verification successful');
            $notification = array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->route('home')->with($notification);
        } else {
            $notification =  trans('Invalid token');
            $notification = array('messege' => $notification, 'alert-type' => 'error');
            return redirect()->route('home')->with($notification);
        }
    }

    public function our_chef()
    {
        $our_chefs = OurChef::with('translation')->where('status', 1)->orderBy('id', 'desc')->get();

        return view('our_chef')->with(['our_chefs' => $our_chefs]);
    }

    public function testimonial()
    {
        $testimonials = Testimonial::with('translation')->where('status', 1)->orderBy('id', 'desc')->get();

        return view('testimonial')->with(['testimonials' => $testimonials]);
    }

    public function setlanguage(Request $request)
    {
        $lang = Language::whereCode(request('code'))->first();
        $hasLangSession = session()->has('lang');

        if ($hasLangSession) {
            session()->forget('lang');
            session()->forget('text_direction');
        }
        
      if ($lang) {
            session()->put('lang', $lang->code);
            session()->put('text_direction', $lang->direction);

            if(env('APP_MODE') == 0){
                $notification =  "In demo mode, All language won't be translate";
                $notification = array('messege' => $notification, 'alert-type' => 'warning');
                return redirect()->back()->with($notification);
            }else{
                $notification =  trans('Language changed successfully');
                $notification = array('messege' => $notification, 'alert-type' => 'success');
                return redirect()->back()->with($notification);
            }
        }

        session()->put('lang', app()->getLocale());

        if(env('APP_MODE') == 0){
            $notification =  "In demo mode, All language won't be translate";
            $notification = array('messege' => $notification, 'alert-type' => 'warning');
            return redirect()->back()->with($notification);
        }else{
            $notification =  trans('Language changed successfully');
            $notification = array('messege' => $notification, 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }
    }
}
