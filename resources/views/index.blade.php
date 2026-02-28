@extends('layout')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo_setting->seo_description }}">
@endsection

@section('public-content')

    <!--=============================
        BANNER START
    ==============================-->
    <section class="wsus__banner" style="background: url({{ asset($slider->slider_background) }});">
        <div class="wsus__banner_overlay">
            <span class="banner_shape_1">
                <img src="{{ asset($slider->foreground_image_one) }}" alt="shape" class="img-fluid w-100">
            </span>
            <span class="banner_shape_2">
                <img src="{{ asset($slider->foreground_image_two) }}" alt="shape" class="img-fluid w-100">
            </span>
            <div class="row banner_slider">
                @foreach ($slider->sliders as $slider_item)
                    <div class="col-12">
                        <div class="wsus__banner_slider">
                            <div class=" container">
                                <div class="row">
                                    <div class="col-xl-5 col-md-5 col-lg-5">
                                        <div class="wsus__banner_img wow fadeInLeft" data-wow-duration="1s">
                                            <div class="img">
                                                <img src="{{ asset($slider_item->image) }}" alt="food item" class="img-fluid w-100">
                                                <span style="background: url({{ asset('user/images/offer_shapes.png') }});">
                                                    {{ $slider_item->offer_text }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-5 col-md-7 col-lg-6">
                                        <div class="wsus__banner_text wow fadeInRight" data-wow-duration="1s">
                                            <h1>{{ $slider_item->title_one }}</h1>
                                            <h3>{{ $slider_item->title_two }}</h3>
                                            <p>{{ $slider_item->description }}</p>
                                            <ul class="d-flex flex-wrap">
                                                <li><a class="common_btn" href="{{ $slider_item->link }}">{{__('user.Order now')}}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--=============================
        BANNER END
    ==============================-->


    <!--=============================
        WHY CHOOSE START
    ==============================-->
    @if($service->status)
    <section class="wsus__why_choose">
        <div class="container">
            <div class="row">
                @foreach ($service->services as $service_item)
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="wsus__choose_single d-flex flex-wrap align-items-center justify-content-between">
                            <div class="icon icon_1">
                                <i class="{{ $service_item->icon }}"></i>
                            </div>
                            <div class="text">
                                <h3>{{ $service_item->title_translated }}</h3>
                                <p>{{ $service_item->description_translated }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!--=============================
        WHY CHOOSE END
    ==============================-->


    <!--=============================
        OFFER ITEM START
    ==============================-->
    @if ($today_special_product->status)
        <section class="wsus__offer_item mt_95 xs_mt_65">
            <span class="banner_shape_3">
                <img src="{{ asset($today_special_product->image) }}" alt="shape" class="img-fluid w-100">
            </span>
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                        <div class="wsus__section_heading mb_50">
                            <h4>{{ $today_special_product->short_title }}</h4>
                            <h2>{{ $today_special_product->long_title }}</h2>
                            <span>
                                <img src="{{ asset('user/images/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                            </span>
                            <p>{{ $today_special_product->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
                    @foreach ($today_special_product->products as $product)
                        <div class="col-xl-4">
                            <div class="wsus__offer_item_single" style="background: url({{ asset($product->thumb_image) }});">

                                @if ($product->is_offer)
                                <span>{{ $product->offer }}% off</span>
                                @endif

                                <a class="title" href="{{ route('show-product', $product->slug) }}">{{ $product->name_translated }}</a>
                                <p>{{ $product->short_description_translated }}</p>
                                <ul class="d-flex flex-wrap">
                                    <li><a href="javascript:;" onclick="load_product_model({{ $product->id }})"><i
                                                class="fas fa-shopping-basket"></i></a></li>

                                    @auth('web')
                                    <li><a href="javascript:;" onclick="add_to_wishlist({{ $product->id }})"><i class="fal fa-heart"></i></a></li>
                                    @else
                                    <li><a href="javascript:;" onclick="before_auth_wishlist({{ $product->id }})"><i class="fal fa-heart"></i></a></li>
                                    @endauth


                                    <li><a href="{{ route('show-product', $product->slug) }}"><i class="far fa-eye"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif

    <!--=============================
        MENU ITEM START
    ==============================-->
    @if ($menu_section->status)
        <section class="wsus__menu mt_95 xs_mt_65">
            <span class="banner_shape_1">
                <img src="{{ asset($menu_section->left_image) }}" alt="shape" class="img-fluid w-100">
            </span>
            <span class="banner_shape_2">
                <img src="{{ asset($menu_section->right_image) }}" alt="shape" class="img-fluid w-100">
            </span>
            <div class="container">

                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                        <div class="wsus__section_heading mb_45">
                            <h4>{{ $menu_section->short_title }}</h4>
                            <h2>{{ $menu_section->long_title }}</h2>
                            <span>
                                <img src="{{ asset('user/images/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                            </span>
                            <p>{{ $menu_section->description }}</p>
                        </div>
                    </div>
                </div>

                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-12">
                        <div class="menu_filter d-flex flex-wrap justify-content-center">
                            @foreach ($menu_section->categories as $index => $menu_category )
                                <button class="{{ $index == 0 ? 'first_menu_product' : '' }}" data-filter=".category_{{ $menu_category->id }}">{{ $menu_category->name_translated }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row grid">
                    @foreach ($menu_section->products as $index => $menu_product )
                        <!--<div class="col-xl-3 col-sm-6 col-lg-4 category_{{ $menu_product->category_id }} wow fadeInUp " data-wow-duration="1s">-->
                            <div class="col-xl-3 col-sm-6 col-lg-4 category_{{ $menu_product->category_id }}">

                            <div class="wsus__menu_item">
                                <div class="wsus__menu_item_img">
                                    <img src="{{ asset($menu_product->thumb_image) }}" alt="menu" class="img-fluid w-100">
                                    <a class="category" href="#">{{ $menu_product->category->name_translated }}</a>
                                </div>
                                <div class="wsus__menu_item_text">
                                    <p class="rating">
                                        @php
                                            if ($menu_product->total_review > 0) {
                                                $average = $menu_product->average_rating;

                                                $int_average = intval($average);

                                                $next_value = $int_average + 1;
                                                $review_point = $int_average;
                                                $half_review=false;
                                                if($int_average < $average && $average < $next_value){
                                                    $review_point= $int_average + 0.5;
                                                    $half_review=true;
                                                }
                                            }
                                        @endphp

                                        @if ($menu_product->total_review > 0)
                                            @for ($i = 1; $i <=5; $i++)
                                                @if ($i <= $review_point)
                                                    <i class="fas fa-star"></i>
                                                @elseif ($i> $review_point )
                                                    @if ($half_review==true)
                                                        <i class="fas fa-star-half-alt"></i>
                                                        @php
                                                            $half_review=false
                                                        @endphp
                                                    @else
                                                    <i class="far fa-star"></i>
                                                    @endif
                                                @endif
                                            @endfor
                                        @else
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                            <i class="far fa-star"></i>
                                        @endif
                                        <span>{{ $menu_product->total_review }}</span>
                                    </p>
                                    <a class="title" href="{{ route('show-product', $menu_product->slug) }}">{{ $menu_product->name_translated }}</a>

                                    @if ($menu_product->is_offer)
                                        <h5 class="price">{{ $currency_icon }}{{ $menu_product->offer_price }} <del>{{ $currency_icon }}{{ $menu_product->price  }}</del> </h5>
                                    @else
                                        <h5 class="price">{{ $currency_icon }}{{ $menu_product->price }}</h5>
                                    @endif

                                    <ul class="d-flex flex-wrap justify-content-center">
                                        <li><a href="javascript:;" onclick="load_product_model({{ $menu_product->id }})"><i
                                                    class="fas fa-shopping-basket"></i></a></li>


                                        @auth('web')
                                        <li><a href="javascript:;" onclick="add_to_wishlist({{ $menu_product->id }})"><i class="fal fa-heart"></i></a></li>
                                        @else
                                        <li><a href="javascript:;" onclick="before_auth_wishlist({{ $menu_product->id }})"><i class="fal fa-heart"></i></a></li>
                                        @endauth

                                        <li><a href="{{ route('show-product', $menu_product->slug) }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif
    <!--=============================
        MENU ITEM END
    ==============================-->


<!--=============================
    OPENING HOURS SECTION END
==============================-->

<section class="wsus__download mt_100 xs_mt_70">
    <div class="container">
        <div class="wsus__download_bg" style="background: url(https://unifood.websolutionus.com/public/uploads/website-images/app_background_one-2022-12-13-01-02-55-7947.jpg);">
            <div class="wsus__download_overlay">
                <div class="row justify-content-between">
                    <div class="col-xl-5 col-lg-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__download_text">
                            <div class="wsus__section_heading mb_25">
                                <h2>📅 Our Opening Hours</h2>
                                <p>We’re open to serve you the best African flavors. Visit us during our working hours!</p>
                                <br>
                                <table style="width: 100%; font-size: 18px; font-weight: 600;">
                                    <tbody>
                                        <tr><td>Monday:</td><td>9:00 AM – 10:00 PM</td></tr>
                                        <tr><td>Tuesday:</td><td>9:00 AM – 10:00 PM</td></tr>
                                        <tr><td>Wednesday:</td><td>9:00 AM – 10:00 PM</td></tr>
                                        <tr><td>Thursday:</td><td>9:00 AM – 10:00 PM</td></tr>
                                        <tr><td>Friday:</td><td>9:00 AM – 10:00 PM</td></tr>
                                        <tr><td>Saturday:</td><td>10:00 AM – 08:00 PM</td></tr>
                                        <tr><td>Sunday:</td><td style="color: #ff4d00;">Closed</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 wow fadeInUp text-center" data-wow-duration="1s">
                        <div class="wsus__download_img">
                            <img src="{{ asset('uploads/website-images/board.png') }}" alt="Opening Hours" class="img-fluid w-75">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





    <!--=============================
        ADD SLIDER START
    ==============================-->
    @if ($advertisement->status)
        <section class="wsus__add_slider mt_100 xs_mt_70 mb-5">
            <div class="container">
                <div class="row add_slider wow fadeInUp" data-wow-duration="1s">
                    @foreach ($advertisement->banners as $ad_banner)
                        <div class="col-xl-4">
                            <a href="{{ $ad_banner->link }}" class="wsus__add_slider_single" style="background: url({{ url($ad_banner->image) }});">
                                <div class="text">
                                    <h3>{{ $ad_banner->title_translated }}</h3>
                                    <p>{{ $ad_banner->description_translated }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!--=============================
        ADD SLIDER END
    ==============================-->





@endsection
