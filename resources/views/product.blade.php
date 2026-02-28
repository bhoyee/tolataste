@extends('layout')
@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $seo_setting->seo_description }}">
@endsection

@section('public-content')

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Our Products')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="{{ route('products') }}">{{__('user.Our Products')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=============================
        SEARCH MENU START
    ==============================-->
    <section class="wsus__search_menu mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <form class="wsus__search_menu_form" action="{{ route('products') }}">
                <div class="row">
                    <div class="col-xl-6 col-md-5">
                        <input type="text" placeholder="{{__('user.Type your keyword')}}" name="search">
                    </div>
                    <div class="col-xl-4 col-md-4">
                        <select id="select_js2" name="category">
                            <option value="">{{__('user.Select category')}}</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->slug }}">{{ $category->name_translated }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-2 col-md-3">
                        <button type="submit" class="common_btn">{{__('user.search')}}</button>
                    </div>
                </div>
            </form>

            @if ($products->count() == 0)
                <div class="row">
                    <div class="col-12 text-center mt-5">
                        <h3 class="text-danger">{{__('user.Products not found!')}}</h3>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__menu_item">
                            <div class="wsus__menu_item_img">
                                <img src="{{ asset($product->thumb_image) }}" alt="menu" class="img-fluid w-100">
                                <a class="category" href="{{ route('products', ['category'=> $product->category->slug]) }}">{{ $product->category->name_translated }}</a>
                            </div>
                            <div class="wsus__menu_item_text">
                                <p class="rating">

                                    @php
                                        if ($product->total_review > 0) {
                                            $average = $product->average_rating;

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

                                    @if ($product->total_review > 0)
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

                                    <span>{{ $product->total_review }}</span>
                                </p>
                                <a class="title" href="{{ route('show-product', $product->slug) }}">{{ $product->name_translated }}</a>
                                @if ($product->is_offer)
                                    <h5 class="price">{{ $currency_icon }}{{ $product->offer_price }} <del>{{ $currency_icon }}{{ $product->price  }}</del> </h5>
                                @else
                                    <h5 class="price">{{ $currency_icon }}{{ $product->price }}</h5>
                                @endif

                                <ul class="d-flex flex-wrap justify-content-center">
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
                    </div>
                    @endforeach
                </div>
                <div class="wsus__pagination mt_35">
                    {{ $products->links('custom_paginator') }}
                </div>
            @endif
        </div>
    </section>

    <!--=============================
        SEARCH MENU END
    ==============================-->
@endsection
