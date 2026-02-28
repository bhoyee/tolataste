@extends('layout')
@section('title')
    <title>{{ $product->seo_title_translated }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $product->seo_description_translated }}">
@endsection

@section('public-content')

<!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Product Details')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="javascript:;">{{__('user.Product Details')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <script>
    const rawProteinOptionsFromDB = @json($product->protein_item);
    console.log("📦 Raw Protein Items from DB:", rawProteinOptionsFromDB);
</script>

    </section>
    
    <!--=============================
        BREADCRUMB END
    ==============================-->

        <!--=============================
        MENU DETAILS START
    ==============================-->
    <section class="wsus__menu_details mt_115 xs_mt_85 mb_95 xs_mb_65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-9 wow fadeInUp" data-wow-duration="1s">
                    <div class="exzoom hidden" id="exzoom">
                        <div class="exzoom_img_box wsus__menu_details_images">
                            <ul class='exzoom_img_ul'>
                                @foreach ($gellery as $single_gallery)
                                    <li><img class="zoom ing-fluid w-100" src="{{ asset($single_gallery->image) }}" alt="product"></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="exzoom_nav"></div>
                        <p class="exzoom_btn">
                            <a href="javascript:void(0);" class="exzoom_prev_btn"> <i class="far fa-chevron-left"></i>
                            </a>
                            <a href="javascript:void(0);" class="exzoom_next_btn"> <i class="far fa-chevron-right"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__menu_details_text">
                        <h2>{{ $product->name_translated }}</h2>
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

                            <span>({{ $product->total_review }})</span>
                        </p>

                        @if ($product->is_offer)
                            <h3 class="price">{{ $currency_icon }}{{ $product->offer_price }} <del>{{ $currency_icon }}{{ $product->price }}</del></h3>
                        @else
                            <h3 class="price">{{ $currency_icon }}{{ $product->price }} </h3>
                        @endif



                        <p class="short_description">{{ $product->short_description_translated }}</p>

                        <form id="add_to_cart_form" action="{{ route('add-to-cart') }}" method="POST">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <!-- <input type="hidden" name="price" value="0" id="price"> -->
                            <input type="hidden" name="variant_price" value="0" id="variant_price">


                            <input type="hidden" name="variant_price" id="variant_price" value="{{ $product->is_offer ? $product->offer_price : $product->price }}">
                            <input type="hidden" name="price" id="price" value="0">

<!-- 
                        <div class="details_size">
                            <h5>{{__('user.select size')}}</h5>
                            @foreach ($size_variants as $index => $size_variant)
                                <div class="form-check">
                                    <input name="size_variant" class="form-check-input" type="radio" name="flexRadioDefault" id="large-{{ $index }}" value="{{ $size_variant->size }}(::){{ $size_variant->price }}" data-variant-price="{{ $size_variant->price }}" data-variant-size="{{ $size_variant->size }}">
                                    <label class="form-check-label" for="large-{{ $index }}">
                                        {{ $size_variant->size }} <span>- {{ $currency_icon }}{{ $size_variant->price }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div> -->

                        @if (count($optional_items) > 0)
                        <div class="details_extra_item">
                            <h5>{{__('user.select Addon')}} <span>({{__('user.optional')}})</span></h5>
                            @foreach ($optional_items as $index => $optional_item)
                                <div class="form-check">
                                <input data-optional-item="{{ $optional_item->price }}"
       name="optional_items[]"
       class="form-check-input check_optional_item check_variant_item"
       type="checkbox"
       value="{{ $optional_item->item }}(::){{ $optional_item->price }}"
       id="optional-item-{{ $index }}">
                                    <label class="form-check-label" for="optional-item-{{ $index }}">
                                        {{ $optional_item->item }} <span>+ {{ $currency_icon }}{{ $optional_item->price }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @endif
                        <!-- proein section -->

                        @if (!empty($protein_items))
                        <div class="details_extra_item"> {{-- ✅ use same class as Addon --}}
                            <h5>{{ __('user.select Protein') }}</h5>
                            @foreach ($protein_items as $index => $protein_item)
                                <div class="form-check">
                                    <input
                                        data-protein-item="{{ $protein_item['price'] }}"
                                        name="protein_items[]"
                                        class="form-check-input check_protein_item check_variant_item"
                                        type="checkbox"
                                        value="{{ $protein_item['item'] }}__{{ $protein_item['price'] }}"
                                        id="protein-item-{{ $index }}"
                                    >
                                    <label class="form-check-label" for="protein-item-{{ $index }}">
                                        {{ $protein_item['item'] }}
                                        <span>+ {{ $currency_icon }}{{ $protein_item['price'] }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Soup Section -->
                    @if (!empty($soup_items))
                    <div class="details_extra_item">
                        <h5>{{ __('user.select Soup') }}</h5>
                        @foreach ($soup_items as $index => $soup_item)
                            <div class="form-check">
                                <input
                                    data-soup-item="{{ $soup_item['price'] }}"
                                    name="soup_items[]"
                                    class="form-check-input check_soup_item check_variant_item"
                                    type="checkbox"
                                    value="{{ $soup_item['item'] }}__{{ $soup_item['price'] }}"
                                    id="soup-item-{{ $index }}"
                                >
                                <label class="form-check-label" for="soup-item-{{ $index }}">
                                    {{ $soup_item['item'] }} <span>+ {{ $currency_icon }}{{ $soup_item['price'] }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Wrap Section -->
                    @if (!empty($wrap_items))
                    <div class="details_extra_item">
                        <h5>{{ __('user.select Wrap / Swallow') }}</h5>
                        @foreach ($wrap_items as $index => $wrap_item)
                            <div class="form-check">
                                <input
                                    data-wrap-item="{{ $wrap_item['price'] }}"
                                    name="wrap_items[]"
                                    class="form-check-input check_wrap_item check_variant_item"
                                    type="checkbox"
                                    value="{{ $wrap_item['item'] }}__{{ $wrap_item['price'] }}"
                                    id="wrap-item-{{ $index }}"
                                >
                                <label class="form-check-label" for="wrap-item-{{ $index }}">
                                    {{ $wrap_item['item'] }} <span>+ {{ $currency_icon }}{{ $wrap_item['price'] }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- drink section -->
                    @if (!empty($drink_items))
                    <div class="details_extra_item">
                        <h5>{{ __('user.select Drink') }}</h5>
                        @foreach ($drink_items as $index => $drink_item)
                            <div class="form-check">
                                <input
                                    data-drink-item="{{ $drink_item['price'] }}"
                                    name="drink_items[]"
                                    class="form-check-input check_drink_item check_variant_item"
                                    type="checkbox"
                                    value="{{ $drink_item['item'] }}__{{ $drink_item['price'] }}"
                                    id="drink-item-{{ $index }}"
                                >
                                <label class="form-check-label" for="drink-item-{{ $index }}">
                                    {{ $drink_item['item'] }} <span>+ {{ $currency_icon }}{{ $drink_item['price'] }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @endif




                    <div class="details_instruction mt-4 mb-4">
                        <h5>{{__('user.Food Instruction')}}  <span>({{ __('user.optional') }})</span></h5>
                        <textarea name="food_instruction" class="form-control" rows="3" placeholder="{{ __('Add your menu preference or instruction') }}"></textarea>
                    </div>
                    

                        <div class="details_quentity">
                            <h5>{{__('user.select quantity')}}</h5>
                            <div class="quentity_btn_area d-flex flex-wrapa align-items-center">
                                <div class="quentity_btn">
                                    <button type="button" class="btn btn-danger decrement_qty_detail_page"><i class="fal fa-minus"></i></button>
                                    <input type="text" value="1" name="qty" class="product_qty" readonly>
                                    <button  type="button" class="btn btn-success increment_qty_detail_page"><i class="fal fa-plus"></i></button>
                                </div>
                                <h3 >{{ $currency_icon }} <span class="grand_total">0.00</span></h3>
                            </div>
                        </div>
                        <ul class="details_button_area d-flex flex-wrap">
                            <li><a id="add_to_cart" class="common_btn" href="javascript:;">{{__('user.add to cart')}}</a></li>
                            @auth('web')
                                <li><a class="wishlist" href="javascript:;" onclick="add_to_wishlist({{ $product->id }})"><i class="far fa-heart"></i></a></li>
                            @else
                                <li><a class="wishlist" href="javascript:;" onclick="before_auth_wishlist()"><i class="far fa-heart"></i></a></li>
                            @endauth
                        </ul>

                    </form>
                    </div>
                </div>
                <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__menu_description_area mt_100 xs_mt_70">
                        <ul class="nav nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                    aria-selected="true">{{__('user.Description')}}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">{{__('user.Reviews')}}</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab" tabindex="0">
                                <div class="menu_det_description">
                                    {!! clean($product->long_description_translated) !!}
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="wsus__review_area">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <h4>{{ $product->total_review }} {{__('user.reviews')}}</h4>
                                            @if ($product->total_review > 0)
                                                <div class="wsus__comment pt-0 mt_20">
                                                    @foreach ($product_reviews as $product_review)
                                                        <div class="wsus__single_comment m-0 border-0">
                                                            @if ($product_review->user->image)
                                                                <img src="{{ asset($product_review->user->image) }}" alt="review" class="img-fluid">
                                                            @else
                                                                <img src="{{ asset($default_user_avatar) }}" alt="review" class="img-fluid">
                                                            @endif

                                                            <div class="wsus__single_comm_text">
                                                                <h3>{{ $product_review->user->name }} <span>{{ $product_review->created_at->format('d M Y') }} </span></h3>
                                                                <span class="rating">
                                                                    @for ($i = 1; $i <=5; $i++)
                                                                        @if ($i <= $product_review->rating)
                                                                            <i class="fas fa-star"></i>
                                                                        @else
                                                                            <i class="fal fa-star"></i>
                                                                        @endif
                                                                    @endfor
                                                                </span>
                                                                <p>{{ $product_review->review }}</p>
                                                            </div>
                                                        </div>
                                                    @endforeach


                                                    @if ($product_reviews->hasMorePages())
                                                        <a href="{{ $product_reviews->nextPageUrl() }}" class="load_more">{{__('user.load More')}}</a>
                                                    @endif

                                                </div>
                                            @endif

                                        </div>
                                        <div class="col-lg-4">
                                            <div class="wsus__post_review">
                                                <h4>{{__('user.write a Review')}}</h4>
                                                <form id="review_form">
                                                    @csrf
                                                    <p class="rating">
                                                        <span>{{__('user.rating')}} : </span>
                                                        <i data-rating="1" class="fas fa-star product_rat" onclick="productReview(1)"></i>
                                                        <i data-rating="2" class="fas fa-star product_rat" onclick="productReview(2)"></i>
                                                        <i data-rating="3" class="fas fa-star product_rat" onclick="productReview(3)"></i>
                                                        <i data-rating="4" class="fas fa-star product_rat" onclick="productReview(4)"></i>
                                                        <i data-rating="5" class="fas fa-star product_rat" onclick="productReview(5)"></i>
                                                    </p>

                                                    <div class="row">
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                                        <input type="hidden" name="rating" value="5" id="product_rating">

                                                        <div class="col-xl-12">
                                                            <textarea name="review" rows="3"
                                                                placeholder="{{__('user.Write your review')}}"></textarea>
                                                        </div>

                                                        @if($recaptcha_setting->status==1)
                                                            <div class="col-xl-12 mt-2">
                                                                <div class="g-recaptcha" data-sitekey="{{ $recaptcha_setting->site_key }}"></div>
                                                            </div>
                                                        @endif

                                                        <div class="col-12">
                                                            @auth('web')
                                           <button class="common_btn" type="submit">{{__('user.submit review')}}</button>
                                                            @else
                                                            <a href="{{ route('login') }}" class="common_btn" type="button">{{__('user.please login first')}}</a>
                                                            @endauth

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wsus__related_menu mt_90 xs_mt_60">
                <h2>{{__('user.related item')}}</h2>
                <div class="row related_product_slider">
                    @foreach ($related_products as $related_product)
                        <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                            <div class="wsus__menu_item">
                                <div class="wsus__menu_item_img">
                                    <img src="{{ asset($related_product->thumb_image) }}" alt="menu" class="img-fluid w-100">
                                    <a class="category" href="{{ route('products', ['category'=> $related_product->category->slug]) }}">{{ $related_product->category->name_translated }}</a>
                                </div>
                                <div class="wsus__menu_item_text">
                                    <p class="rating">

                                        @php
                                            if ($related_product->total_review > 0) {
                                                $average = $related_product->average_rating;

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

                                        @if ($related_product->total_review > 0)
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

                                        <span>{{ $related_product->total_review }}</span>
                                    </p>
                                    <a class="title" href="{{ route('show-product', $related_product->slug) }}">{{ $related_product->name_translated }}</a>


                                    @if ($related_product->is_offer)
                                        <h5 class="price">{{ $currency_icon }}{{ $related_product->offer_price }} <del>{{ $currency_icon }}{{ $related_product->price  }}</del> </h5>
                                    @else
                                        <h5 class="price">{{ $currency_icon }}{{ $related_product->price }}</h5>
                                    @endif

                                    <ul class="d-flex flex-wrap justify-content-center">
                                        <li><a href="javascript:;" onclick="load_product_model({{ $related_product->id }})"><i
                                                    class="fas fa-shopping-basket"></i></a></li>


                                        @auth('web')
                                        <li><a href="javascript:;" onclick="add_to_wishlist({{ $related_product->id }})"><i class="fal fa-heart"></i></a></li>
                                        @else
                                        <li><a href="javascript:;" onclick="before_auth_wishlist({{ $related_product->id }})"><i class="fal fa-heart"></i></a></li>
                                        @endauth

                                        <li><a href="{{ route('show-product', $related_product->slug) }}"><i class="far fa-eye"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if(session()->has("protein_items_{$product->id}"))
    <script>
        const sessionProteinData = @json(session("protein_items_{$product->id}"));
        console.log("📦 Session Protein Data from Product Page:", sessionProteinData);
    </script>
@else
    <script>
        console.warn("⚠️ No session protein data found for Product ID: {{ $product->id }}");
    </script>
@endif
@php
    $sessionProteins = session("protein_items_{$product->id}", []);
@endphp

<script>
    const sessionProteinsOnProductPage = @json($sessionProteins);
    console.log("📦 [Product Page] Protein Items from Session for Product ID coming from add to cart  {{ $product->id }}:", sessionProteinsOnProductPage);
</script>

    </section>

    <!--=============================
        MENU DETAILS END
    ==============================-->

    <script>

(function($) {
    "use strict";
    $(document).ready(function () {

        // ✅ Set the base product price from backend
        const baseProductPrice = parseFloat("{{ $product->is_offer ? $product->offer_price : $product->price }}") || 0;

        // ✅ Set initial base price value in hidden input
        $('#variant_price').val(baseProductPrice);

        // ✅ Calculate initial grand total on load
        calculatePrice();

        // ✅ Handle review form submission
        $("#review_form").on("submit", function(e){
            e.preventDefault();
            var isDemo = "{{ env('APP_MODE') }}";
            if(isDemo == 0){
                toastr.error('This Is Demo Version. You Can Not Change Anything');
                return;
            }

            $.ajax({
                type: 'post',
                data: $('#review_form').serialize(),
                url: "{{ url('/submit-review') }}",
                success: function () {
                    toastr.success("{{ __('user.Review added successfully') }}");
                    $("#review_form").trigger("reset");
                },
                error: function(response) {
                    if (response.status == 422) {
                        if (response.responseJSON.errors.rating) toastr.error(response.responseJSON.errors.rating[0]);
                        if (response.responseJSON.errors.review) toastr.error(response.responseJSON.errors.review[0]);
                        if (response.responseJSON.errors.product_id) toastr.error(response.responseJSON.errors.product_id[0]);
                        else toastr.error("{{ __('user.Please complete the recaptcha to submit the form') }}");
                    } else if (response.status == 500) {
                        toastr.error("{{ __('user.Server error occured') }}");
                    } else if (response.status == 403) {
                        toastr.error(response.responseJSON.message);
                    }
                }
            });
        });

        // ✅ Handle Add to Cart
        $("#add_to_cart").on("click", function(e){
            e.preventDefault();

            $.ajax({
                type: 'get',
                data: $('#add_to_cart_form').serialize(),
                url: "{{ url('/add-to-cart') }}",
                success: function (response) {
    // ✅ This includes the full mini cart HTML (header, items, totals)
    $(".wsus__menu_cart_boody").html(response.html);

    // ✅ Update the cart count at the top of the page (icon)
    $("#cart_count").text(response.count);

    toastr.success("{{ __('user.Item added successfully') }}");
    calculate_mini_total();
}
,
                error: function(response) {
                    if(response.status == 500){
                        toastr.error("{{ __('user.Server error occured') }}");
                    } else if(response.status == 403){
                        toastr.error(response.responseJSON.message);
                    }
                }
            });
        });        

        // ✅ Optional & Protein change triggers
        // $("input[name='optional_items[]'], input[name='protein_items[]'], input[name='soup_items[]'], input[name='wrap_items[]'], input[name='drink_items[]']").on("change", function() {
        //     calculatePrice();
        // });

        $(".check_variant_item").on("change", function() {
            calculatePrice();
        });



        // ✅ Quantity buttons
        $(".increment_qty_detail_page").on("click", function(){
            let qty = parseInt($(".product_qty").val());
            $(".product_qty").val(qty + 1);
            calculatePrice();
        });

        $(".decrement_qty_detail_page").on("click", function(){
            let qty = parseInt($(".product_qty").val());
            if(qty > 1){
                $(".product_qty").val(qty - 1);
                calculatePrice();
            }
        });
    });
})(jQuery);

// ✅ Main calculator function
function calculatePrice(){
    let optional_price = 0;
    let protein_price = 0;
    let soup_price = 0;
    let wrap_price = 0;
    let drink_price = 0;
    let product_qty = parseInt($(".product_qty").val()) || 1;
    let base_price = parseFloat($("#variant_price").val()) || 0;

    $("input[name='optional_items[]']:checked").each(function() {
        let price = parseFloat($(this).data('optional-item')) || 0;
        optional_price += price;
    });

    $("input[name='protein_items[]']:checked").each(function() {
        let price = parseFloat($(this).data('protein-item')) || 0;
        protein_price += price;
    });

        // Soup
    $("input[name='soup_items[]']:checked").each(function() {
        let price = parseFloat($(this).data('soup-item')) || 0;
        soup_price += price;
    });

    // Wrap
    $("input[name='wrap_items[]']:checked").each(function() {
        let price = parseFloat($(this).data('wrap-item')) || 0;
        wrap_price += price;
    });

    // Drink
    $("input[name='drink_items[]']:checked").each(function() {
        let price = parseFloat($(this).data('drink-item')) || 0;
        drink_price += price;
    });

    // Grand total
    let total = (base_price + optional_price + protein_price + soup_price + wrap_price + drink_price) * product_qty;

    $(".grand_total").html(total.toFixed(2));
    $("#price").val(total.toFixed(2));
}

// ✅ Star rating system
function productReview(rating){
    $(".product_rat").each(function(){
        let star = $(this).data('rating');
        if(star > rating){
            $(this).removeClass('fas fa-star').addClass('fal fa-star');
        } else {
            $(this).removeClass('fal fa-star').addClass('fas fa-star');
        }
    });
    $("#product_rating").val(rating);
}
</script>


@endsection

