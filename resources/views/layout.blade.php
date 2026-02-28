@php
    // Force session to initialize so it's available for Cart, etc.
    session()->start(); 
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />


    @yield('title')
    @yield('meta')

    <link rel="icon" type="image/png" href="{{ asset($setting->favicon) }}">
    <link rel="stylesheet" href="{{ asset('user/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/jquery.exzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">



    @include('theme_color')
    @if (session()->get('text_direction') == 'rtl')
    <link rel="stylesheet" href="{{ asset('user/css/rtl.css') }}">
    @endif

    <!--jquery library js-->
    <script src="{{ asset('user/js/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('user/js/sweetalert2@11.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    @if ($googleAnalytic->status == 1)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalytic->analytic_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $googleAnalytic->analytic_id }}');
    </script>
    @endif

    @if ($facebookPixel->status == 1)
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '{{ $facebookPixel->app_id }}');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ $facebookPixel->app_id }}&ev=PageView&noscript=1"
    /></noscript>
    @endif


</head>

<style>
.modal-scrollable-area {
  max-height: 70vh;
  overflow-y: auto;
  padding-right: 10px;
  margin-top: 15px;
}

.modal-scrollable-area::-webkit-scrollbar {
  width: 6px;
}

.modal-scrollable-area::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 3px;
}

    .cart-item-actions {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .edit-item, .delete-item {
        color: #666;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .edit-item:hover {
        color: #007bff;
        transform: scale(1.1);
    }

    .delete-item:hover {
        color: #dc3545;
        transform: scale(1.1);
    }

    .mini_cart_list li {
        position: relative;
        padding-right: 80px !important;
    }
    
    


/* Remove background base and use round icon */
.whatsapp-launcher {
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: flex;
    align-items: center;
    cursor: pointer;
    z-index: 9999;
    gap: 6px;
    background: transparent;
}

.whatsapp-launcher img {
    width: 64px !important;
    height: 64px !important;
    max-width: 64px;
    max-height: 64px;
    object-fit: contain;
    display: inline-block;
    padding: 0;
    margin: 0;
    border: none;
    box-shadow: none;
}

.whatsapp-launcher .chat-text {
    background-color: #25D366;
    color: #fff;
    padding: 6px 10px;
    border-radius: 18px;
    font-size: 12px;
    font-weight: 500;
    line-height: 1;
    white-space: nowrap;
}


.whatsapp-widget {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 280px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.2);
    z-index: 10000;
    display: none;
    overflow: hidden;
    font-family: sans-serif;
}

.whatsapp-header {
    background-color: #25D366;
    color: white;
    padding: 10px;
    display: flex;
    align-items: center;
}
.whatsapp-widget .user-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
}

.agent-info {
    display: flex;
    align-items: center;
}

.user-img {
    width: 40px !important;
    height: 40px !important;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.user-info h4 {
    margin: 0;
    font-size: 14px;
}

.user-info p {
    margin: 0;
    font-size: 11px;
}


.user-info h4 {
    margin: 0;
    font-size: 16px;
}
.user-info p {
    margin: 0;
    font-size: 12px;
}
.close-widget {
    margin-left: auto;
    font-size: 20px;
    cursor: pointer;
}
.whatsapp-body {
    padding: 15px;
    font-size: 14px;
    color: #333;
}
.whatsapp-footer {
    padding: 10px;
    text-align: center;
}
.whatsapp-button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    font-weight: bold;
}

/* Force navbar above topbar on tablets */
@media (min-width: 768px) and (max-width: 1199.98px) {
  /* Remove gap between topbar and menu */
  .wsus__topbar {
    position: relative !important;
    z-index: 10 !important;
  }

  .main_menu {
    position: relative !important;
    z-index: 9999 !important;
    overflow: visible !important;
  }

  /* Directly control navbar height/padding */
  .main_menu .navbar {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }

  .main_menu .navbar-brand {
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }

  .main_menu .navbar-brand img {
    display: block;
    height: 50px; /* Adjust if you want smaller */
    width: auto;
  }

  .main_menu .navbar-collapse {
    background: #fff !important;
    margin-top: 0 !important;
    padding-top: 0 !important;
  }

  /* Keep nav links on one line */
  .navbar-nav .nav-link {
    white-space: nowrap !important;
  }

  .navbar-nav .nav-item {
    margin: 0 8px !important;
  }
}



</style>

<body>

    <div class="" id="preloader">
        <div class="img d-none">
            <img src="{{ asset('uploads/website-images/Spinner.gif') }}" alt="TolaTaste" class="img-fluid">
        </div>
    </div>

    <!--=============================
        TOPBAR START
    ==============================-->
    <section class="wsus__topbar">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-md-6 d-none d-md-block">
                    <ul class="wsus__topbar_info d-flex flex-wrap">
                        <li><a href="mailto:{{ $footer->email }}"><i class="fas fa-envelope"></i> {{ $footer->email }}</a>
                        </li>
                        <li><a href="callto:{{ $footer->phone }}"><i class="fas fa-phone-alt"></i> {{ $footer->phone }}</a></li>
                    </ul>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="topbar_right">
                        <!-- <div class="topbar_language">
                            <form id="setLanguage" action="{{ route('set-language') }}">
                                <select id="select_js3" name="code">
                                    @forelse($languages as $language)
                                    <option value="{{$language->code}}"{{ session()->get('lang') == $language->code ? 'selected' : '' }}>{{ $language->name }}</option>
                                    @empty
                                    <option value="en">English</option>
                                    @endforelse
                                </select>
                            </form>
                        </div> -->
                        <ul class="topbar_icon d-flex flex-wrap">
                            @foreach ($social_links as $social_link)
                            <li><a href="{{ $social_link->link }}"><i class="{{ $social_link->icon }}"></i></a></li>
                            @endforeach
                        </ul>   
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        TOPBAR END
    ==============================-->


    <!--=============================
        MENU START
    ==============================-->
    <nav class="navbar navbar-expand-lg main_menu">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset($setting->logo) }}" alt="TolaTeste" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="far fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav m-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{__('user.Home')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about-us') }}">{{__('user.About Us')}}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products') }}">{{__('user.Products')}}</a>
                    </li>

                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">{{__('user.pages')}} <i class="far fa-plus"></i></a>
                        <ul class="droap_menu">

                            <li>
                                <a href="{{ route('our-chef') }}">{{__('user.Our chef')}}</a>
                            </li>

                            <li><a href="{{ route('testimonial') }}">{{__('user.Testimonial')}}</a></li>

                            <li><a href="{{ route('faq') }}">{{__('user.FAQs')}}</a></li>

                            <li><a href="{{ route('privacy-policy') }}">{{__('user.privacy policy')}}</a></li>
                            <li><a href="{{ route('terms-and-condition') }}">{{__('user.terms and condition')}}</a></li>

                            @foreach ($custom_pages as $custom_page)
                            <li><a href="{{ route('show-page', $custom_page->slug) }}">{{ $custom_page->page_name_translated }}</a></li>
                            @endforeach
                        </ul>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gallery') }}">{{__('user.gallery')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('catering') }}">{{ __('user.catering') }}</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('faq') }}">{{__('user.FAQs')}}</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('blogs') }}">{{__('user.Blogs')}}</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact-us') }}">{{__('user.contact us')}}</a>
                    </li>
                </ul>
                <ul class="menu_icon d-flex flex-wrap">
                    <li>
                        <a href="javascript:;" class="menu_search"><i class="far fa-search"></i></a>
                        <div class="wsus__search_form">
                            <form action="{{ route('products') }}">
                                <span class="close_search"><i class="far fa-times"></i></span>
                                <input name="search" type="text" placeholder="{{__('user.Type your keyword')}}">
                                <button type="submit">{{__('user.search')}}</button>
                            </form>
                        </div>
                    </li>
                    @php
                        $mini_cart_contents = Cart::content();
                    @endphp
                    <li>
                        <a class="cart_icon"><i class="fas fa-shopping-basket"></i> <span class="topbar_cart_qty">{{ count($mini_cart_contents) }}</span></a>
                    </li>
                    <li>
                        @auth('web')
                            <a href="{{ route('dashboard') }}" title="{{ __('user.Dashboard') }}"><i class="fas fa-user"></i></a>
                        @else
                            <a class="common_btn" href="{{ route('login') }}">{{ __('user.Login') }}</a>
                        @endauth
                    </li>
                    <!-- <li>
                        @auth('web')
                        <a class="common_btn" href="#" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">{{__('user.reservation')}}</a>
                        @else
                        <a class="common_btn" href="{{ route('login') }}">{{__('user.reservation')}}</a>
                        @endauth

                    </li> -->
                    <li>
                        <a class="common_btn" href="javascript:;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            {{__('user.reservation')}}
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="wsus__menu_cart_area">
    <div class="wsus__menu_cart_boody">
        @php
            use Gloudemans\Shoppingcart\Facades\Cart;
            $mini_cart_contents = Cart::content();
            $mini_sub_total = 0;
        @endphp

        @if ($mini_cart_contents->count() == 0)
            <div class="wsus__menu_cart_header">
                <h5>{{ __('user.Your cart is empty') }}</h5>
                <span class="close_cart"><i class="fas fa-times"></i></span>
            </div>
        @else
            <div>
                <div class="wsus__menu_cart_header">
                    <h5 class="mini_cart_body_item">
                        {{ __('user.Total Item') }} ({{ $mini_cart_contents->count() }})
                    </h5>
                    <span class="close_cart"><i class="fas fa-times"></i></span>
                </div>

                <ul class="mini_cart_list">
                    @foreach ($mini_cart_contents as $mini_cart_content)
                        @php
                            $qty = $mini_cart_content->qty;
                            $base = $mini_cart_content->price;
                            $item_total = $base * $qty;
                            $mini_sub_total += $item_total;

                            $optional_items = $mini_cart_content->options->optional_items ?? [];
                            $protein_items  = $mini_cart_content->options->protein_items ?? [];
                            $soup_items     = $mini_cart_content->options->soup_items ?? [];
                            $wrap_items     = $mini_cart_content->options->wrap_items ?? [];
                            $drink_items    = $mini_cart_content->options->drink_items ?? [];
                        @endphp

                        <li class="min-item-{{ $mini_cart_content->rowId }}" data-mini-item-rowid="{{ $mini_cart_content->rowId }}">
                            <div class="menu_cart_img">
                                <img src="{{ asset($mini_cart_content->options->image ?? '') }}" alt="menu" class="img-fluid w-100">
                            </div>

                            <div class="menu_cart_text">
                                <a class="title" href="{{ route('show-product', $mini_cart_content->options->slug ?? '#') }}">
                                    {{ $mini_cart_content->name }}
                                </a>

                                @if(!empty($mini_cart_content->options->size) && $mini_cart_content->options->size !== 'null')
                                    <p class="size">{{ $mini_cart_content->options->size }}</p>
                                @endif

                                @foreach ($optional_items as $item)
                                    <span class="extra">{{ $item['optional_name'] ?? '' }}</span>
                                @endforeach

                                @foreach ($protein_items as $item)
                                    <span class="extra">{{ $item['protein_name'] ?? '' }}</span>
                                @endforeach

                                @foreach ($soup_items as $item)
                                    <span class="extra">{{ $item['soup_name'] ?? '' }}</span>
                                @endforeach

                                @foreach ($wrap_items as $item)
                                    <span class="extra">{{ $item['wrap_name'] ?? '' }}</span>
                                @endforeach

                                @foreach ($drink_items as $item)
                                    <span class="extra">{{ $item['drink_name'] ?? '' }}</span>
                                @endforeach

                                <p class="price mini-price-{{ $mini_cart_content->rowId }}">
                                    {{ $currency_icon }}{{ number_format($item_total, 2) }}
                                </p>
                            </div>

                            <div class="cart-item-actions">
                                @php
                                    $rowId = method_exists($mini_cart_content, 'rowId') ? $mini_cart_content->rowId() : $mini_cart_content->rowId;
                                @endphp

                                <a href="{{ route('cart.edit.page', $rowId) }}" class="edit_item">
                                    <i class="fal fa-edit"></i>
                                </a>

                          <span class="delete-item mini-item-remove" title="Remove item" data-rowid="{{ $mini_cart_content->rowId }}">

                                    <i class="fal fa-times"></i>
                                </span>
                            </div>

                            <input type="hidden"
                                class="mini-input-price set-mini-input-price-{{ $mini_cart_content->rowId }}"
                                value="{{ $item_total }}">
                        </li>
                    @endforeach
                    </ul>


                <p class="subtotal">
                    {{ __('user.Sub Total') }}
                    <span class="mini_sub_total">{{ $currency_icon }}{{ number_format($mini_sub_total, 2) }}</span>
                </p>

                <a class="cart_view" href="{{ route('cart') }}">{{ __('user.view cart') }}</a>
                <!--<a href="javascript:void(0);" class="checkout" onclick="showGuestCheckoutModal()">Checkout</a>-->
                
                 @auth
                <a href="{{ route('checkout') }}" class="checkout">Checkout</a>
                @else
                <a href="javascript:void(0);" class="checkout" onclick="showGuestCheckoutModal()">Checkout</a>
                @endauth

                <!-- <a class="checkout" href="{{ route('checkout') }}">{{ __('user.checkout') }}</a> -->
            </div>
        @endif
    </div>
</div>



<!-- CART POPUP START -->
<!--<div class="wsus__cart_popup">-->
<!--    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">-->
<!--        <div class="modal-dialog modal-dialog-centered">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-body">-->
<!--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">-->
<!--                        <i class="fal fa-times"></i>-->
<!--                    </button>-->
<!--                    <div class="load_product_modal_response">-->
<!--                        <img src="{{ asset('uploads/website-images/Spinner-1s-200px.gif') }}" alt="">-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!-- CART POPUP END -->
<!-- CART POPUP START -->
<div class="wsus__cart_popup">
  <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Optional: modal-lg for wider layout -->
      <div class="modal-content">
        <div class="modal-body position-relative">

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fal fa-times"></i>
          </button>

          <!-- ✅ Make this scrollable -->
          <div class="load_product_modal_response modal-scrollable-area">
            <img src="{{ asset('uploads/website-images/Spinner-1s-200px.gif') }}" alt="">
            {{-- Dynamic content will be loaded here --}}
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- CART POPUP END -->



<div class="wsus__reservation">
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">{{__('user.Book a Table')}}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="wsus__reservation_form" method="POST" action="{{ route('store-reservation') }}">
                        @csrf

                        @php
                            $auth_user = Auth::guard('web')->user();
                        @endphp

                        {{-- Guest user fields --}}
                        @if (!$auth_user)
                            <input class="reservation_input" type="text" name="guest_name" placeholder="{{__('user.Full Name')}}" required>
                            <input class="reservation_input" type="email" name="guest_email" placeholder="{{__('user.Email')}}" required>
                            <input class="reservation_input" type="text" name="guest_phone" placeholder="{{__('user.Phone')}}" required>
                        @else
                            {{-- Authenticated user phone update (if not set) --}}
                            @if ($auth_user->phone == null)
                                <input class="reservation_input" type="text" name="phone" placeholder="{{__('user.Phone')}}" required>
                            @endif
                        @endif

                        <input class="reservation_input datepicker" type="text" autocomplete="off" name="reserve_date" required placeholder="{{__('user.Select date')}}">

                        <label>{{ __('user.Select Time') }}</label>
                        <input class="reservation_input" type="time" name="reserve_time" required>

                        <input class="reservation_input" type="number" placeholder="{{__('user.Number of person')}}" name="person" required>

                        <button type="submit" id="reservationSubmitBtn">
                            <span id="reservationSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            {{ __('user.Send Request') }}
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

    <!--=============================
        MENU END
    ==============================-->


    <!-- CART POPUT START -->
    <!--<div class="wsus__cart_popup">-->
    <!--    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">-->
    <!--        <div class="modal-dialog modal-dialog-centered">-->
    <!--            <div class="modal-content">-->
    <!--                <div class="modal-body">-->
    <!--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i-->
    <!--                            class="fal fa-times"></i></button>-->
    <!--                    <div class="load_product_modal_response">-->
    <!--                        <img src="{{ asset('uploads/website-images/Spinner-1s-200px.gif') }}" alt="">-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!-- CART POPUP START -->
<div class="wsus__cart_popup">
  <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Optional: modal-lg for wider layout -->
      <div class="modal-content">
        <div class="modal-body position-relative">

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fal fa-times"></i>
          </button>

          <!-- ✅ Make this scrollable -->
          <div class="load_product_modal_response modal-scrollable-area">
            <img src="{{ asset('uploads/website-images/Spinner-1s-200px.gif') }}" alt="">
            {{-- Dynamic content will be loaded here --}}
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- CART POPUP END -->



    <!-- cart edit model -->
    <div class="modal fade" id="editCartModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Cart Item</h5>
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="editCartModalBody">
                {{-- AJAX content goes here --}}
            </div>
        </div>
    </div>
</div>

<!-- guestcheckout -->
<!-- guestcheckout -->
<div class="modal fade mt-5" id="guestCheckoutModal" tabindex="-1" aria-labelledby="guestCheckoutLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="guestCheckoutLabel">Continue Checkout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center">
        <p>How would you like to checkout?</p>

        <button class="btn btn-outline-primary mb-2 w-100" onclick="window.location='{{ route('login') }}'">
          Login to Checkout
        </button>

        <button class="btn btn-outline-secondary mb-3 w-100" onclick="window.location='{{ route('register') }}'">
          Register to Checkout
        </button>

        <hr>

        <form id="guest-checkout-form">
          @csrf
          <div class="form-group">
            <input type="text" name="guest_name" class="form-control" placeholder="Full Name" required>
          </div>
          <div class="form-group mt-2">
            <input type="email" name="guest_email" class="form-control" placeholder="Email Address" required>
          </div>
          <div class="form-group mt-2">
            <input type="text" name="guest_phone" class="form-control" placeholder="Phone Number" required>
          </div>
          <button type="submit" class="btn btn-success mt-3 w-100" id="guest-checkout-btn">
            <span class="spinner-border spinner-border-sm d-none" role="status" id="guestSpinner"></span>
            Continue as Guest
          </button>
        </form>
      </div>
    </div>
  </div>
</div>


    <!-- CART POPUT END -->
    <!--=============================
        OFFER ITEM END
    ==============================-->

    @yield('public-content')


    <!--=============================
        BRAND START
    ==============================-->
    <!-- <section class="wsus__brand" style="background: url({{ asset($setting->partner_background) }});">
        <div class="wsus__brand_overlay">
            <div class="container">
                <div class="row brand_slider wow fadeInUp" data-wow-duration="1s">
                    @foreach ($partners as $partner)
                        <div class="col-xl-2">
                            @if ($partner->link)
                            <a class="wsus__single_brand" href="{{ $partner->link }}">
                                <img src="{{ asset($partner->image) }}" alt="brand" class="img-fluid w-100">
                            </a>
                            @else
                            <a class="wsus__single_brand" href="javascript:;">
                                <img src="{{ asset($partner->image) }}" alt="brand" class="img-fluid w-100">
                            </a>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>

            
        </div>
    </section> -->
    <!--=============================
        BRAND END
    ==============================-->


    <!--=============================
        FOOTER START
    ==============================-->
    <footer style="background: url({{ asset($footer->footer_background) }});">
        <div class="footer_overlay pt_100 xs_pt_70 pb_100 xs_pb_70">
            <div class="container wow fadeInUp" data-wow-duration="1s">
                <div class="row justify-content-between">
                    <div class="col-lg-4 col-sm-8 col-md-6">
                        <div class="wsus__footer_content">
                            <a class="footer_logo" href="{{ route('home') }}">
                                <img src="{{ asset($setting->footer_logo) }}" alt="TolaTaste" class="img-fluid w-50">
                            </a>
                            <span>{{ $footer->about_us_translated }}</span>
                            <p class="info"><i class="far fa-map-marker-alt"></i> {{ $footer->address_translated }}</p>
                            <a class="info" href="callto:{{ $footer->phone }}"><i class="fas fa-phone-alt"></i>
                                {{ $footer->phone }}</a>
                            <a class="info" href="mailto:{{ $footer->email }}"><i class="fas fa-envelope"></i>
                                {{ $footer->email }}</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6">
                        <div class="wsus__footer_content">
                            <h3>{{__('user.Important Link')}}</h3>
                            <ul>
                                <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                                <li><a href="{{ route('about-us') }}">{{__('user.About Us')}}</a></li>
                                <li><a href="{{ route('contact-us') }}">{{__('user.Contact Us')}}</a></li>
                                <!-- <li><a href="{{ route('our-chef') }}">{{__('user.Our Chef')}}</a></li> -->
                                <li><a href="{{ route('our-chef') }}">{{__('user.Dashboard')}}</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-4 col-md-6 order-sm-4 order-lg-3">
                        <div class="wsus__footer_content">
                            <h3>{{__('user.Help Link')}}</h3>
                            <ul>
                                <!-- <li><a href="{{ route('blogs') }}">{{__('user.Our Blogs')}}</a></li> -->
                                <li><a href="#">{{__('user.Our Blogs')}}</a></li>
                                <!-- <li><a href="{{ route('testimonial') }}">{{__('user.Testimonial')}}</a></li> -->
                                <li><a href="{{ route('faq') }}">{{__('user.FAQ')}}</a></li>
                                <li><a href="{{ route('privacy-policy') }}">{{__('user.Privacy and Policy')}}</a></li>
                                <li><a href="{{ route('terms-and-condition') }}">{{__('user.Terms and Conditions')}}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-8 col-md-6 order-lg-4">
                        <div class="wsus__footer_content">
                            <h3>{{__('user.Subscribe to Newsletter')}}</h3>
                            <form id="subscribe_form">
                                <input type="text" name="website" style="display:none">

                                @csrf
                                <input type="email" placeholder="{{__('user.Email')}}" name="email">
                                <button id="subscribe_btn" type="submit"><i class="fas fa-paper-plane"></i></button>
                            </form>
                            <div class="wsus__footer_social_link">
                                <h5>{{__('user.Follow us')}}:</h5>
                                <ul class="d-flex flex-wrap">
                                    @foreach ($social_links as $social_link)
                                    <li><a href="{{ $social_link->link }}"><i class="{{ $social_link->icon }}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wsus__footer_bottom d-flex flex-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="wsus__footer_bottom_text d-flex flex-wrap justify-content-between">
                        <p>
                            {{ $footer->copyright_translated }}
                            &nbsp;|&nbsp;
                            <span style="color: #ffffff;">Powered and Developed by <a href="https://giddyhost.com/" target="_blank" style="color: #ffffff;">GiddyHost</a></span>
                        </p>

                            <ul class="d-flex flex-wrap">
                                <li><a href="{{__('user.faq')}}">{{__('user.FAQ')}}</a></li>
                                <li><a href="{{__('user.payment')}}">{{__('user.Payment')}}</a></li>
                                <li><a href="{{__('user.checkout')}}">{{__('user.Checkout')}}</a></li>
                                <li><a href="{{__('user.dashboard')}}">{{__('user.Dashboard')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
                   <!-- WhatsApp Widget -->
            <div class="whatsapp-launcher" id="whatsappLauncher">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
                <span class="chat-text">Chat with us</span>
            </div>


            <div class="whatsapp-widget" id="whatsappWidget">
                    <div class="whatsapp-header">
                        <div class="agent-info">
                            <img src="{{ asset('uploads/custom-images/agent_avarter.jpg') }}" alt="User Image" class="user-img">
                            <div class="user-info">
                                <h4>Teresa</h4>
                                <p>Support</p>
                            </div>
                        </div>
                        <span class="close-widget" id="closeWidget">&times;</span>
                    </div>

                    <div class="whatsapp-body">
                        <p>Hello 👋 How may we help you? Just send us a message now to get assistance.</p>
                    </div>
                    <div class="whatsapp-footer">
                        <a href="https://wa.me/14433253708" target="_blank" class="whatsapp-button">WhatsApp</a>
                    </div>
             </div>

    </footer>
    <!--=============================
        FOOTER END
    ==============================-->


    <!--=============================
        SCROLL BUTTON START
    ==============================-->
    <div class="wsus__scroll_btn">
        {{__('user.Go to top')}}
    </div>
    <!--=============================
        SCROLL BUTTON END
    ==============================-->

    <!--@if ($tawk_setting->status == 1)-->
    <!--<script type="text/javascript">-->
    <!--    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();-->
    <!--    (function(){-->
    <!--        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];-->
    <!--        s1.async=true;-->
    <!--        s1.src='{{ $tawk_setting->chat_link }}';-->
    <!--        s1.charset='UTF-8';-->
    <!--        s1.setAttribute('crossorigin','*');-->
    <!--        s0.parentNode.insertBefore(s1,s0);-->
    <!--    })();-->
    <!--</script>-->
    <!--@endif-->


    @if ($cookie_consent->status == 1)
    <script src="{{ asset('user/js/cookieconsent.min.js') }}"></script>

    <script>
    window.addEventListener("load",function(){window.wpcc.init({"border":"{{ $cookie_consent->border }}","corners":"{{ $cookie_consent->corners }}","colors":{"popup":{"background":"{{ $cookie_consent->background_color }}","text":"{{ $cookie_consent->text_color }} !important","border":"{{ $cookie_consent->border_color }}"},"button":{"background":"{{ $cookie_consent->btn_bg_color }}","text":"{{ $cookie_consent->btn_text_color }}"}},"content":{"href":"{{ route('privacy-policy') }}","message":"{{ $cookie_consent->message }}","link":"{{ $cookie_consent->link_text }}","button":"{{ $cookie_consent->btn_text }}"}})});
    </script>
    @endif


    <!--bootstrap js-->
    <script src="{{ asset('user/js/bootstrap.bundle.min.js') }}"></script>
    <!--font-awesome js-->
    <script src="{{ asset('user/js/Font-Awesome.js') }}"></script>
    <!-- slick slider -->
    <script src="{{ asset('user/js/slick.min.js') }}"></script>
    <!-- isotop js -->
    <script src="{{ asset('user/js/isotope.pkgd.min.js') }}"></script>
    <!-- simplyCountdownjs -->
    <script src="{{ asset('user/js/simplyCountdown.js') }}"></script>
    <!-- counter up js -->
    <script src="{{ asset('user/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('user/js/jquery.countup.min.js') }}"></script>
    <!-- nice select js -->
    <script src="{{ asset('user/js/jquery.nice-select.min.js') }}"></script>
    <!-- venobox js -->
    <script src="{{ asset('user/js/venobox.min.js') }}"></script>
    <!-- sticky sidebar js -->
    <script src="{{ asset('user/js/sticky_sidebar.js') }}"></script>
    <!-- wow js -->
    <script src="{{ asset('user/js/wow.min.js') }}"></script>
    <!-- ex zoom js -->
    <script src="{{ asset('user/js/jquery.exzoom.js') }}"></script>


    <script src="{{ asset('backend/js/bootstrap-datepicker.min.js') }}"></script>

    <!--main/custom js-->
    <script src="{{ asset('user/js/main.js') }}"></script>

    <script src="{{ asset('toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('backend/js/select2.min.js') }}"></script>

    <script>
        @if(Session::has('messege'))
        var type="{{Session::get('alert-type','info')}}"
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('messege') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('messege') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('messege') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('messege') }}");
                break;
        }
        @endif
    </script>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                toastr.error('{{ $error }}');
            </script>
        @endforeach
    @endif

    <script>
(function($) {
    "use strict";
    $(document).ready(function () {

        $("#setLanguage").on('change', function(e){
            this.submit();
        });

        $(".first_menu_product").click();

        $('.select2').select2();
        $('.modal_select2').select2({
            dropdownParent: $("#address_modal")
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '-Infinity'
        });

        console.log("✅ Global .edit_item click handler active");
        $(document).on('click', '.mini-item-edit', function () {
    const rowid = $(this).data('rowid');
    console.log("🛠️ Edit clicked. Row ID:", rowid);

    if (!rowid) {
        console.warn("⚠️ Could not find row ID for edit.");
        return;
    }

    const url = '/edit-cart-item/' + rowid;

    $('#editCartModalBody').html('<div class="text-center p-3"><b>Loading...</b></div>');

    $.get(url, function (response) {
        console.log("📥 Response:", response);

        if (response.html) {
            $('#editCartModalBody').html(response.html);
            $('#editCartModal').modal('show');
        } else {
            $('#editCartModalBody').html('<div class="text-danger p-3">❌ Failed to load content</div>');
        }
    }).fail(function (err) {
        console.error("❌ AJAX failed:", err);
        $('#editCartModalBody').html('<div class="text-danger p-3">❌ Server Error</div>');
    });
});





$(document).on('click', '.mini-item-remove', function () {
    let rowId = $(this).data('rowid');
    console.log("Deleting rowId:", rowId); // 👈 See this in browser

    if (!rowId) {
        toastr.error("Missing row ID.");
        return;
    }

    $.ajax({
        url: "{{ url('/remove-cart-item') }}/" + rowId,
        type: "GET",
        success: function (response) {
            $(".wsus__menu_cart_boody").html(response.html);
            $("#cart_count").text(response.count);
            toastr.success(response.message);
            calculate_mini_total();
        },
        error: function () {
            toastr.error("{{ __('user.Server error occurred') }}");
        }
    });
});


        $("#subscribe_form").on('submit', function(e){
            e.preventDefault();
            var isDemo = "{{ env('APP_MODE') }}"
            if (isDemo == 0) {
                toastr.error('This Is Demo Version. You Can Not Change Anything');
                return;
            }

            $("#subscribe_btn").prop("disabled", true);
            $("#subscribe_btn").html(`<i class="fas fa-spinner"></i>`);

            $.ajax({
                type: 'POST',
                data: $('#subscribe_form').serialize(),
                url: "{{ route('subscribe-request') }}",
                success: function (response) {
                    toastr.success(response.message)
                    $("#subscribe_form").trigger("reset");
                    $("#subscribe_btn").prop("disabled", false);
                    $("#subscribe_btn").html(`<i class="fas fa-paper-plane"></i>`);
                },
                error: function(response) {
                    $("#subscribe_btn").prop("disabled", false);
                    $("#subscribe_btn").html(`<i class="fas fa-paper-plane"></i>`);
                    if (response.status == 403 && response.responseJSON.message) {
                        toastr.error(response.responseJSON.message);
                    }
                }
            });
        });

    });
})(jQuery);

function calculate_mini_total(){
    let mini_sub_total = 0;
    let mini_total_item = 0;
    $(".mini-input-price").each(function () {
        let current_val = $(this).val();
        mini_sub_total = parseInt(mini_sub_total) + parseInt(current_val);
        mini_total_item = parseInt(mini_total_item) + 1;
    });

    $(".mini_sub_total").html(`{{ $currency_icon }}${mini_sub_total}`);
    $(".topbar_cart_qty").html(mini_total_item);
    $(".mini_cart_body_item").html(`{{__('user.Total Item')}}(${mini_total_item})`);

    if (mini_total_item === 0) {
        $(".wsus__menu_cart_boody").html(`
            <div class="wsus__menu_cart_header">
                <h5>{{__('user.Your cart is empty')}}</h5>
                <span class="close_cart"><i class="fal fa-times"></i></span>
            </div>
        `);
    }
}

function load_product_model(product_id){
    $("#preloader").addClass('preloader');
    $(".img").removeClass('d-none');

    $.ajax({
        type: 'get',
        url: "{{ url('/load-product-modal') }}" + "/" + product_id,
        success: function (response) {
            $("#preloader").removeClass('preloader');
            $(".img").addClass('d-none');
            $(".load_product_modal_response").html(response);
            $("#cartModal").modal('show');
        },
        error: function(response) {
            toastr.error("{{__('user.Server error occured')}}");
        }
    });
}

function add_to_wishlist(id){
    $.ajax({
        type: 'get',
        url: "{{ url('/add-to-wishlist') }}/" + id,
        success: function () {
            toastr.success("{{__('user.Wishlist added successfully')}}");
        },
        error: function(response) {
            if (response.status === 500 || response.status === 403) {
                toastr.error("{{__('user.Server error occured')}}");
            }
        }
    });
}

function before_auth_wishlist(){
    toastr.error("{{__('user.Please login first')}}");
}

function showGuestCheckoutModal() {
    $('#guestCheckoutModal').modal('show');
}

</script>

{{-- include pushed scripts here --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('guest-checkout-form');
    const spinner = document.getElementById('guestSpinner');
    const phoneInput = form.querySelector('[name="guest_phone"]');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const phoneValue = phoneInput.value.trim();
        const usPhonePattern = /^(\+1\s?)?(\(?[2-9][0-9]{2}\)?[\s.-]?[0-9]{3}[\s.-]?[0-9]{4})$/;

        if (!usPhonePattern.test(phoneValue)) {
            alert("Please enter a valid U.S. phone number (e.g., 123-456-7890 or (123) 456-7890).");
            phoneInput.focus();
            return;
        }

        const formData = new FormData(form);
        spinner.classList.remove('d-none');

        fetch("{{ route('guest.checkout.session') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            spinner.classList.add('d-none');
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        })
        .catch(error => {
            spinner.classList.add('d-none');
            alert('❌ Something went wrong. Please try again.');
            console.error(error);
        });
    });
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.wsus__reservation_form');
    const submitBtn = document.getElementById('reservationSubmitBtn');
    const spinner = document.getElementById('reservationSpinner');
    const phoneInput = form?.querySelector('[name="guest_phone"], [name="phone"]');

    if (!form || !submitBtn || !spinner) return;

    form.addEventListener('submit', function (e) {
        // ✅ Phone number validation
        if (phoneInput) {
            const usPhonePattern = /^(\+1\s?)?(\(?[2-9][0-9]{2}\)?[\s.-]?[0-9]{3}[\s.-]?[0-9]{4})$/;
            if (!usPhonePattern.test(phoneInput.value.trim())) {
                e.preventDefault();
                alert("Please enter a valid US phone number, e.g. (123) 456-7890 or 123-456-7890.");
                phoneInput.focus();
                return;
            }
        }

        // ✅ Show spinner and disable button
        spinner.classList.remove('d-none');
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...`;
    });
});
</script>

<script>
 // Auto slide for WhatsApp Chat

 document.getElementById('whatsappLauncher').onclick = () => {
    document.getElementById('whatsappWidget').style.display = 'block';
    document.getElementById('whatsappLauncher').style.display = 'none';
};

document.getElementById('closeWidget').onclick = () => {
    document.getElementById('whatsappWidget').style.display = 'none';
    document.getElementById('whatsappLauncher').style.display = 'flex';
};

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navbarCollapse = document.querySelector('.navbar-collapse');
    const navbarToggler = document.querySelector('.navbar-toggler');

    // Close menu on any nav-link or cart icon click
    document.querySelectorAll('.nav-link, .cart_icon').forEach(link => {
        link.addEventListener('click', () => {
            if (navbarToggler && getComputedStyle(navbarToggler).display !== 'none') {
                const collapseEl = bootstrap.Collapse.getInstance(navbarCollapse);
                if (collapseEl) {
                    collapseEl.hide();
                } else {
                    new bootstrap.Collapse(navbarCollapse).hide();
                }
            }
        });
    });
});
</script>




@stack('scripts')
</body>

</html>
