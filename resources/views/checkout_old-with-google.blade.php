@extends('layout')
@section('title')
    <title>{{__('user.Checkout')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Checkout')}}">
@endsection

@section('public-content')
<!-- Flatpickr CSS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



<style>
    .btn-outline-primary {
    border-radius: 8px;
    font-weight: 500;
    padding: 12px 20px;
    text-align: center;
    font-size: 16px;
}

.btn-check:checked + .btn-outline-primary {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

</style>

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Checkout')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="javascript:;">{{__('user.Checkout')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


        <!--============================
        CHECK OUT PAGE START
    ==============================-->
    <section class="wsus__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__checkout_form">
                        <div class="wsus__check_form">

                             <!-- Order Type Selection -->
             <!-- Order Type Selection -->
<!-- Order Type Selection -->
<h5 class="mb-3">{{ __('user.Order Type') }}</h5>
<div class="wsus__check_single_form">
    <div class="btn-group w-100" role="group" aria-label="Order Type Toggle">
        <input type="radio" class="btn-check order_type" name="order_type" id="pickup_option" value="pickup" autocomplete="off" checked>
        <label class="btn btn-outline-primary w-50" for="pickup_option">
            <i class="fas fa-store-alt me-2"></i> {{ __('user.Pickup') }}
        </label>

        <input type="radio" class="btn-check order_type" name="order_type" id="delivery_option" value="delivery" autocomplete="off">
        <label class="btn btn-outline-primary w-50" for="delivery_option">
            <i class="fas fa-truck me-2"></i> {{ __('user.Delivery') }}
        </label>
    </div>
</div>

<!-- Pre-Order Toggle -->
<div class="wsus__check_single_form mt-4">
    <label class="form-label d-block mb-2"><strong>Place Order in Advance?</strong></label>
    <div class="form-check form-check-inline">
        <input class="form-check-input pre_order_toggle" type="radio" name="is_preorder" id="pre_order_yes" value="1">
        <label class="form-check-label" for="pre_order_yes">Yes</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input pre_order_toggle" type="radio" name="is_preorder" id="pre_order_no" value="0" checked>
        <label class="form-check-label" for="pre_order_no">No</label>
    </div>
</div>

<!-- Scheduled Date & Time Picker -->
<div class="wsus__check_single_form mt-3" id="schedule_time_section">
    <label><strong>Pickup/Delivery Time</strong></label>

    <!-- Time only (today) -->
    <input type="text" class="form-control mt-2" id="flat_time_only" name="flat_time_only" style="display: block;" placeholder="Select time for today">

    <!-- Date + Time (advance order) -->
    <input type="text" class="form-control mt-2" id="flat_datetime" name="flat_datetime" style="display: none;" placeholder="Select date and time">

    <small class="text-muted d-block mt-1">Only available during working hours. Sundays are disabled.</small>
</div>





<!-- Google Address Autocomplete -->
<!-- Autocomplete Input -->
<div class="mb-3" id="autocomplete_wrapper" style="display: none;">
  <label for="autocomplete_address">Enter Your Address or Postcode</label>
  <input type="text" id="autocomplete_address" name="full_address" class="form-control" placeholder="Start typing your address...">
  <div id="delivery_details" class="mt-2" style="display: none;"></div>
</div>


<!-- 
                            @if ($addresses->count() > 0)
                                <h5>{{__('user.select address')}} <a href="#" data-bs-toggle="modal" data-bs-target="#address_modal"><i
                                            class="far fa-plus"></i> {{__('user.New Address')}}</a></h5>

                                <div class="wsus__address_modal">
                                    <div class="modal fade" id="address_modal" data-bs-backdrop="static"
                                        data-bs-keyboard="false" aria-labelledby="address_modalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="address_modalLabel">{{__('user.add new address')}}
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('store-address-from-checkout') }}" method="POST">
                                                        @csrf

                                                        <div class="row">

                                                            <div class="col-12">
                                                                <div class="wsus__check_single_form">
                                                                    <select name="delivery_area_id" class="modal_select2">
                                                                        <option value="">{{__('user.Select Delivery Area')}}</option>
                                                                        @foreach ($delivery_areas as $delivery_area)
                                                                            <option value="{{ $delivery_area->id }}">{{ $delivery_area->area_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="{{__('user.First Name')}}*" name="first_name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="{{__('user.Last Name')}} *" name="last_name">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" placeholder="{{__('user.Phone')}}" name="phone">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="email" placeholder="{{__('user.Email')}}" name="email">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="wsus__check_single_form">
                                                                    <textarea name="address" cols="3" rows="4"
                                                                        placeholder="{{__('user.Address')}} *"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="wsus__check_single_form check_area">
                                                                    <div class="form-check">
                                                                        <input value="home" class="form-check-input" type="radio"
                                                                            name="address_type" id="flexRadioDefault1">
                                                                        <label class="form-check-label"
                                                                            for="flexRadioDefault1">
                                                                            {{__('user.home')}}
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input value="office" class="form-check-input" type="radio"
                                                                            name="address_type" id="flexRadioDefault2">
                                                                        <label class="form-check-label"
                                                                            for="flexRadioDefault2">
                                                                            {{__('user.office')}}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="wsus__check_single_form m-0">
                                                                    <button type="submit" class="common_btn">{{__('user.Save Address')}}</button>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($addresses as $address)
                                    <div class="col-md-6">
                                        <div class="wsus__checkout_single_address">
                                            <div class="form-check">
                                                <input value="{{ $address->id }}" data-delivery-charge="{{ $address->deliveryArea->delivery_fee }}" class="form-check-input address_id" type="radio" name="address_id"
                                                    id="home-{{ $address->id }}">

                                                    <label class="form-check-label" for="home-{{ $address->id }}">
                                                        @if ($address->type == 'home')
                                                            <span class="icon"><i class="fas fa-home"></i>{{__('user.Home')}}</span>
                                                        @else
                                                            <span class="icon"><i class="far fa-car-building"></i>{{__('user.Office')}}</span>
                                                        @endif
                                                        <span class="address">{{__('user.Name')}} : {{ $address->first_name.' '. $address->last_name }}</span>
                                                        <span class="address">{{__('user.Phone')}} : {{ $address->phone }}</span>
                                                        <span class="address">{{__('user.Delivery area')}} : {{ $address->deliveryArea->area_name }}</span>

                                                        <span class="address">{{__('user.Address')}} : {{ $address->address }}</span>
                                                    </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif -->

                            <!-- @if ($addresses->count() == 0)
                                <form action="{{ route('store-address-from-checkout') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <h5>{{__('user.add new address')}}</h5>
                                        </div>

                                        <div class="col-12">
                                            <div class="wsus__check_single_form">
                                                <select name="delivery_area_id" class="select2">
                                                    <option value="">{{__('user.Select Delivery Area')}}</option>
                                                    @foreach ($delivery_areas as $delivery_area)
                                                        <option value="{{ $delivery_area->id }}">{{ $delivery_area->area_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                            <div class="wsus__check_single_form">
                                                <input type="text" placeholder="{{__('user.First Name')}}*" name="first_name">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                            <div class="wsus__check_single_form">
                                                <input type="text" placeholder="{{__('user.Last Name')}} *" name="last_name">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                            <div class="wsus__check_single_form">
                                                <input type="text" placeholder="{{__('user.Phone')}}" name="phone">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                            <div class="wsus__check_single_form">
                                                <input type="email" placeholder="{{__('user.Email')}}" name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                            <div class="wsus__check_single_form">
                                                <textarea name="address" cols="3" rows="4"
                                                    placeholder="{{__('user.Address')}} *"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="wsus__check_single_form check_area">
                                                <div class="form-check">
                                                    <input value="home" class="form-check-input" type="radio"
                                                        name="address_type" id="flexRadioDefault1">
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault1">
                                                        {{__('user.home')}}
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input value="office" class="form-check-input" type="radio"
                                                        name="address_type" id="flexRadioDefault2">
                                                    <label class="form-check-label"
                                                        for="flexRadioDefault2">
                                                        {{__('user.office')}}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="common_btn">{{__('user.Save Address')}}</button>
                                        </div>
                                    </div>
                                </form>
                            @endif -->

                        </div>
                    </div>
                </div>

                @php
    $sub_total = 0;
    $coupon_price = 0.00;
@endphp

@foreach ($cart_contents as $index => $cart_content)
    @php
        $qty = $cart_content->qty;
        $base_price = $cart_content->price * $qty;
        $item_total = $base_price;
        $sub_total += $item_total;
    @endphp
@endforeach

@if (Session::get('coupon_price') && Session::get('offer_type'))
    @php
        if(Session::get('offer_type') == 1) {
            $coupon_price = Session::get('coupon_price');
            $coupon_price = ($coupon_price / 100) * $sub_total;
        } else {
            $coupon_price = Session::get('coupon_price');
        }
    @endphp
@endif

@php
    $delivery_charge = Session::get('delivery_charge') ?? 0;
    $taxable_amount = $sub_total - $coupon_price + $delivery_charge;
    $session_tax = round($taxable_amount * 0.06, 2);
    $final_total = $taxable_amount + $session_tax;

    // 🔥 ADD these two new variables:
    $tax_without_delivery = round(($sub_total - $coupon_price) * 0.06, 2);
    $final_total_without_delivery = ($sub_total - $coupon_price) + $tax_without_delivery;
@endphp






                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="wsus__cart_list_footer_button">


                        <h6>{{__('user.total price')}}</h6>
                        <p>{{__('user.subtotal')}}: <span class="sub_total_amount">{{ $currency_icon }}{{ $sub_total }}</span></p>
                        <p>{{__('user.discount')}} (-): <span class="coupon_discount_amount">{{ $currency_icon }}{{ $coupon_price }}</span></p>
                        <p>{{__('user.delivery')}} (+): <span class="delivery_charge">{{ $currency_icon }}0.00</span></p>
                        <p>{{ __('user.Tax') }} (6%): <span class="tax_amount">{{ $currency_icon }}{{ number_format($session_tax, 2) }}</span></p>

                        <p class="total"><span>{{__('user.Total')}}:</span> <span class="grand_total">{{ $currency_icon }}{{ number_format($final_total, 2) }}</span></p>

                        <input type="hidden" id="sub_total" value="{{ $sub_total }}">
                        <input type="hidden" id="tax_without_delivery" value="{{ $tax_without_delivery }}">
                        <input type="hidden" id="final_total_without_delivery" value="{{ $final_total_without_delivery }}">
                        <input type="hidden" id="calculated_delivery_distance" value="">






                        <input type="hidden" id="grand_total" value="{{ $final_total }}">
                        <!-- <input type="hidden" id="sub_total" value="{{ $sub_total - $coupon_price }}"> -->

                        <!-- <p>{{ __('user.Tax') }} (6%): <span class="tax_amount">{{ $currency_icon }}0.00</span></p> -->
                        <!-- <p class="total"><span>{{__('user.Total')}}:</span> <span class="grand_total">{{ $currency_icon }}0.00</span></p> -->

                        <!-- <p class="total"><span>{{__('user.Total')}}:</span> <span class="grand_total">{{ $currency_icon }}{{ $sub_total - $coupon_price }}</span></p> -->
                        <!-- <input type="hidden" id="grand_total" value="{{ $sub_total - $coupon_price }}"> -->
                        <input type="hidden" id="calculated_delivery_fee" value=""> {{-- ← ADD THIS --}}
                        <form action="{{ route('apply-coupon-from-checkout') }}">
                            <input name="coupon" type="text" placeholder="{{__('user.Coupon Code')}}">
                            <button type="submit">{{__('user.apply')}}</button>
                        </form>
                        <a class="common_btn" href="javascript:;" id="continue_to_pay">{{__('user.Continue to pay')}}</a>
                        
                    </div>
                </div>

                <!-- payment modal -->
                <div class="modal fade" id="stripePaymentModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md"> {{-- ⬅️ modal-dialog-centered centers it --}}
                        <div class="modal-content shadow rounded-3">
                            <div class="modal-header border-0 pb-0 mb-3">
                                <h5 class="modal-title fw-bold">{{ __('user.Enter Card Details') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body pt-0">
                                <form role="form" action="{{ route('stripe-payment') }}" method="POST" class="require-validation" data-cc-on-file="false" data-stripe-publishable-key="{{ $stripePaymentInfo->stripe_key }}" id="payment-form">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">{{ __('user.Card Number') }}</label>
                                        <input type="text" class="form-control card-number" name="card_number" placeholder="1234 1234 1234 1234" autocomplete="off">
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('user.Month') }}</label>
                                            <input type="text" class="form-control card-expiry-month" name="month" placeholder="MM" autocomplete="off">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">{{ __('user.Year') }}</label>
                                            <input class="form-control card-expiry-year" name="year" type="text" placeholder="YYYY" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label">{{ __('user.CVC') }}</label>
                                        <input class="form-control card-cvc" name="cvc" type="text" placeholder="CVC" autocomplete="off">
                                    </div>

                                    <div class='mt-3 error d-none'>
                                        <div class='alert alert-danger'>{{ __('user.Please provide your valid card information') }}</div>
                                    </div>
                                    <!-- Include schedule fields -->
                                    <input type="hidden" name="is_preorder" id="stripe_is_preorder">
                                    <input type="hidden" name="flat_datetime" id="stripe_flat_datetime">
                                    <input type="hidden" name="flat_time_only" id="stripe_flat_time_only">

                                        <!-- ✅ Inject guest user info if available -->
                                        @if(session()->has('guest_user'))
                                            <input type="hidden" name="guest_name" value="{{ session('guest_user.name') }}">
                                            <input type="hidden" name="guest_email" value="{{ session('guest_user.email') }}">
                                            <input type="hidden" name="guest_phone" value="{{ session('guest_user.phone') }}">
                                        @endif


                                    <div class="d-flex justify-content-between mt-4">
                                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">{{ __('user.Close') }}</button>
                                        <button type="submit" id="submit_payment_btn" class="btn btn-success">{{ __('user.Submit') }}</button>

                                    </div>
                                   
                                    <!-- A loading spinner  -->
                                    <div id="payment_loader" class="text-center d-none mt-3">
                                    <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;">
                                        <span class="visually-hidden">Processing...</span>
                                    </div>
                                    <p class="mt-2 mb-0 text-muted">{{ __('user.Processing payment, please wait...') }}</p>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--============================
        CHECK OUT PAGE END
    ==============================-->
<!-- Google Maps Places API -->

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH9tWBuZvP4ynikRv_0mMgL51pG6076nA&libraries=places&callback=initAutocomplete" async defer></script>

<!-- Stripe Payment Script -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script>
const storeAddress = '5213 Windsor Mill Road, Baltimore, MD, USA';

function initAutocomplete() {
    const input = document.getElementById('autocomplete_address');
    if (!input) return;

    const autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['geocode'],
        componentRestrictions: { country: "us" }
    });

    autocomplete.addListener('place_changed', function () {
        if (!$('#delivery_option').is(':checked')) {
            console.log('Pickup selected, no delivery fee calculation.');
            return;
        }

        const place = autocomplete.getPlace();

        if (!place.geometry || !place.formatted_address) {
            toastr.error("❌ Invalid address. Please try again.");
            return;
        }

        let isInMaryland = false;
        place.address_components.forEach(component => {
            if (
                component.types.includes("administrative_area_level_1") &&
                component.long_name.toLowerCase() === "maryland"
            ) {
                isInMaryland = true;
            }
        });

        if (!isInMaryland) {
            toastr.error("❌ We only deliver within Maryland, USA.");
            input.value = '';
            $('#delivery_details').hide();
            $('#calculated_delivery_fee').val('');
            $(".delivery_charge").html(`{{ $currency_icon }}0.00`);
            $(".grand_total").html(`{{ $currency_icon }}{{ $sub_total - $coupon_price }}`);
            return;
        }

        const service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins: [place.formatted_address],
            destinations: [storeAddress],
            travelMode: google.maps.TravelMode.DRIVING,
            unitSystem: google.maps.UnitSystem.IMPERIAL,
        }, function (response, status) {
            if (status === 'OK') {
                const element = response.rows[0].elements[0];
                if (element.status === "OK") {
                    const distanceInMiles = element.distance.value / 1609.34;
                    $('#calculated_delivery_distance').val(distanceInMiles.toFixed(2));

                    let fee = 0;

                    if (distanceInMiles <= 3) {
                        fee = 2;
                    } else if (distanceInMiles <= 5) {
                        fee = 3;
                    } else {
                        const extraMiles = distanceInMiles - 5;
                        fee = 3 + (extraMiles * 0.5);
                        fee = Math.round(fee * 100) / 100;
                    }

                    // Update delivery fee
                    $('#calculated_delivery_fee').val(fee.toFixed(2));
                    $(".delivery_charge").html(`{{ $currency_icon }}${fee.toFixed(2)}`);
                    $('#delivery_details').html(`✅ Distance: ${distanceInMiles.toFixed(2)} miles<br>🚚 Delivery Fee: $${fee.toFixed(2)}`).show();

                    // 🚀 Recalculate and force DOM update
                    recalculateTotal(fee);
                    
                    // 🚀 Force blur on address input to repaint DOM immediately
                    $('#autocomplete_address').trigger('blur');

                    // Optional: tiny timeout to refresh smoother
                    setTimeout(function(){
                        let tax = $(".tax_amount").text();
                        let total = $(".grand_total").text();
                        $(".tax_amount").text(tax);
                        $(".grand_total").text(total);
                    }, 50);

                   // ✅ Set CSRF token for all AJAX calls
                   $.ajax({
    type: 'GET',
    url: "{{ url('/set-delivery-charge') }}",
    data: { charge: fee.toFixed(2) },
    xhrFields: {
        withCredentials: true
    },
    success: function (res) {
        console.log('✅ Delivery fee saved:', res);

        // Save address
        $.ajax({
            type: 'POST',
            url: "{{ url('/set-typed-delivery-address') }}",
            data: {
                _token: "{{ csrf_token() }}",
                address: place.formatted_address,
                distance: distanceInMiles.toFixed(2),
                fee: fee.toFixed(2)
            },
            success: function (res) {
                console.log('✅ Address and distance saved.', res);
            },
            error: function () {
                toastr.error("⚠️ Could not save address.");
            }
        });

    },
    error: function (xhr) {
        console.error('❌ Delivery fee save failed:', xhr.responseText);
        toastr.error("⚠️ Could not save delivery fee.");
    }
});

                }
            }
        });
    });
}


// ✅ Clean recalculateTotal function
function recalculateTotal(delivery_fee = null) {
    let base_total = parseFloat($("#sub_total").val()) || 0;
    let coupon = parseFloat($(".coupon_discount_amount").text().replace("{{ $currency_icon }}", "").trim()) || 0;
    let fee = delivery_fee !== null ? parseFloat(delivery_fee) : (parseFloat($("#calculated_delivery_fee").val()) || 0);

    let taxable_amount = base_total - coupon + fee;
    let tax = (taxable_amount * 6) / 100;
    let grand_total = taxable_amount + tax;

    $(".delivery_charge").html(`{{ $currency_icon }}${fee.toFixed(2)}`);
    $(".tax_amount").html(`{{ $currency_icon }}${tax.toFixed(2)}`);
    $(".grand_total").html(`{{ $currency_icon }}${grand_total.toFixed(2)}`);

    $("#grand_total").val(grand_total.toFixed(2));
    $("#calculated_delivery_fee").val(fee.toFixed(2));
}


(function($) {
    "use strict";
    $(document).ready(function () {

        if ($('#pickup_option').is(':checked')) {
            let base_total = parseFloat($("#sub_total").val()) || 0;
            let tax = parseFloat($("#tax_without_delivery").val()) || 0;
            let grand_total = parseFloat($("#final_total_without_delivery").val()) || 0;

            $(".delivery_charge").html(`{{ $currency_icon }}0.00`);
            $(".tax_amount").html(`{{ $currency_icon }}${tax.toFixed(2)}`);
            $(".grand_total").html(`{{ $currency_icon }}${grand_total.toFixed(2)}`);
        }

        // Order Type Toggle
        $('.order_type').on('change', function () {
    let base_total = parseFloat($("#sub_total").val()) || 0;

    if ($('#delivery_option').is(':checked')) {
        $('#autocomplete_wrapper').slideDown();

        $('#autocomplete_address').val('');
        $('#calculated_delivery_fee').val('');
        $('#delivery_details').html('').hide();
        $(".delivery_charge").html(`{{ $currency_icon }}0.00`);
        $(".tax_amount").html(`{{ $currency_icon }}0.00`);
        $(".grand_total").html(`{{ $currency_icon }}${base_total.toFixed(2)}`);

        recalculateTotal(); // 🔥 call here

        // ✅ Save order type as "delivery" immediately when user selects
        $.ajax({
            url: "{{ url('/set-order-type') }}",
            method: "GET",
            data: { order_type: 'delivery' }, // 🛠️ Set to 'delivery' directly
            success: function (res) {
                console.log('✅ Order type set to delivery.', res);
            },
            error: function () {
                toastr.error("⚠️ Unable to set order type.");
            }
        });

        setTimeout(() => {
            initAutocomplete(); // 🔥 Reinitialize Google Autocomplete
        }, 300);

    } else {
        $('#autocomplete_wrapper').slideUp();

        $('#autocomplete_address').val('');
        $('#calculated_delivery_fee').val('');
        $('#delivery_details').html('').hide();
        $(".delivery_charge").html(`{{ $currency_icon }}0.00`);
        let tax = (base_total * 6) / 100;
        $(".tax_amount").html(`{{ $currency_icon }}${tax.toFixed(2)}`);
        $(".grand_total").html(`{{ $currency_icon }}${(base_total + tax).toFixed(2)}`);

        recalculateTotal(); // 🔥 call here

        // ✅ Save order type as "pickup"
        $.ajax({
            url: "{{ url('/set-order-type') }}",
            method: "GET",
            data: { order_type: 'pickup' }, // 🛠️ Set to 'pickup' directly
            success: function (res) {
                console.log('✅ Order type set to pickup.', res);
            },
            error: function () {
                toastr.error("⚠️ Unable to set order type.");
            }
        });
    }
});


        // If user manually changes address
        $('#autocomplete_address').on('blur', function () {
            const fee = $('#calculated_delivery_fee').val();
            if (fee) {
                recalculateTotal(parseFloat(fee));
            }
        });

        $('#continue_to_pay').on('click', function(e) {
            e.preventDefault();

                // Show loading spinner
            $('#continue_to_pay').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...`);
            $('#continue_to_pay').addClass('disabled');

            if ($('#delivery_option').is(':checked')) {
                const addressFilled = $('#autocomplete_address').val();
                const fee = $('#calculated_delivery_fee').val();
                if (!addressFilled || !fee) {
                    toastr.error("{{ __('user.Please enter a valid delivery address within Maryland.') }}");

                                        // Reset button
                    $('#continue_to_pay').html(`{{ __('user.Continue to pay') }}`);
                    $('#continue_to_pay').removeClass('disabled');
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ url('/set-typed-delivery-address') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        address: addressFilled,
                        distance: $('#calculated_delivery_distance').val(),

                        fee: fee
                    },
                    success: function (res) {
                        if (res.status === 'success') {
                            console.log('✅ Address re-saved before payment.', res);
                            saveCheckoutSession(); // ✅ Proceed
                        } else {
                            toastr.error("⚠️ Could not save delivery address.");
                              // Reset button
                            $('#continue_to_pay').html(`{{ __('user.Continue to pay') }}`);
                            $('#continue_to_pay').removeClass('disabled');
                        }
                    },
                    error: function () {
                        toastr.error("⚠️ Could not save delivery address (server error).");

                             // Reset button
                            $('#continue_to_pay').html(`{{ __('user.Continue to pay') }}`);
                            $('#continue_to_pay').removeClass('disabled');
                    }
                });

            } else {
                // If pickup selected, no address to save, just continue
                saveCheckoutSession();
            }
        });






// 🛠 Move this function out separately
function saveCheckoutSession() {
    $.ajax({
        url: "{{ route('save.checkout.session') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            sub_total: parseFloat($("#sub_total").val()) || 0,
            grand_total: parseFloat($(".grand_total").text().replace("{{ $currency_icon }}", "").trim()) || 0,
            tax: parseFloat($(".tax_amount").text().replace("{{ $currency_icon }}", "").trim()) || 0,
            delivery_charge: parseFloat($(".delivery_charge").text().replace("{{ $currency_icon }}", "").trim()) || 0,
            coupon_price: parseFloat($(".coupon_discount_amount").text().replace("{{ $currency_icon }}", "").trim()) || 0,
        },
        success: function(response) {
            console.log('✅ Checkout totals saved to session.', response);

               // After saving everything, hide spinner
               $('#continue_to_pay').html(`{{ __('user.Continue to pay') }}`);
               $('#continue_to_pay').removeClass('disabled');

            // ✅ After saving everything, open Stripe modal
            $('#stripePaymentModal').modal('show');
        },
        error: function () {
            toastr.error("⚠️ Could not prepare payment session. Try again.");

             // Reset button
            $('#continue_to_pay').html(`{{ __('user.Continue to pay') }}`);
            $('#continue_to_pay').removeClass('disabled');
        }
    });
}



    });
})(jQuery);
</script>
    <script>
    // Stripe validation & dynamic pickup/delivery time logic
    $(document).ready(function () {
        const $form = $(".require-validation");

       // Stripe Validation
       $('form.require-validation').on('submit', function (e) {
            const $form = $(".require-validation");
            const $inputs = $form.find('input[type=text], input[type=email], input[type=password], input[type=file], textarea');
            const $errorMessage = $form.find('div.error');

            $errorMessage.addClass('d-none');
            $('.has-error').removeClass('has-error');

            $inputs.each(function (i, el) {
                if ($(el).val() === '') {
                    $(el).parent().addClass('has-error');
                    $errorMessage.removeClass('d-none');
                    e.preventDefault();
                }
            });

            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey($form.data('stripe-publishable-key'));

                // ✅ Inject preorder toggle value
                let isPreorder = $('input[name="is_preorder"]:checked').val();
                $('#stripe_is_preorder').val(isPreorder);

                // ✅ Time values
                let flatTimeOnly = $('#flat_time_only').val();
                let flatDateTime = $('#flat_datetime').val();

                // ✅ If not preorder, build valid datetime from today + flatTimeOnly
                if (isPreorder === "0" && flatTimeOnly) {
                    const today = new Date().toISOString().slice(0, 10); // YYYY-MM-DD
                    flatDateTime = today + ' ' + flatTimeOnly;
                }

                // ✅ Set both hidden fields
                $('#stripe_flat_datetime').val(flatDateTime || '');
                $('#stripe_flat_time_only').val(flatTimeOnly || '');

                // Show loader
                $('#payment_loader').removeClass('d-none');
                $('#submit_payment_btn').addClass('d-none');

                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, function (status, response) {
                    if (response.error) {
                        $('.error').removeClass('d-none').find('.alert').text(response.error.message);
                        $('#payment_loader').addClass('d-none');
                        $('#submit_payment_btn').removeClass('d-none');
                    } else {
                        const token = response.id;
                        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                        $form.get(0).submit();
                    }
                });
            }
        });

    // Set min time for both inputs
    function setTimeOnlyMin() {
        const now = new Date();
        now.setHours(now.getHours() + 1);
        $('#time_only').attr('min', now.toTimeString().slice(0, 5)); // HH:MM
    }

    function setDateTimeMin() {
        const now = new Date();
        now.setHours(now.getHours() + 1);
        $('#datetime_full').attr('min', now.toISOString().slice(0, 16)); // YYYY-MM-DDTHH:MM
    }

    function toggleInputView() {
        if ($('#pre_order_yes').is(':checked')) {
            $('#time_only').hide().prop('disabled', true);
            $('#datetime_full').show().prop('disabled', false);
            setDateTimeMin();
        } else {
            $('#time_only').show().prop('disabled', false);
            $('#datetime_full').hide().prop('disabled', true);
            setTimeOnlyMin();
        }
    }

    // Init on load
    toggleInputView();

    // Toggle on pre-order change
    $('.pre_order_toggle').on('change', function () {
        toggleInputView();
    });

    // Validate time on Continue
    $('#continue_to_pay').on('click', function () {
        let selectedTime;
        if ($('#pre_order_yes').is(':checked')) {
            const dt = $('#flat_datetime').val(); // ✅ corrected ID
            if (!dt) {
                toastr.error("⚠️ Please select a valid date and time.");
                return false;
            }
            selectedTime = new Date(dt);
        } else {
            const timeVal = $('#flat_time_only').val(); // ✅ corrected ID
            if (!timeVal) {
                toastr.error("⚠️ Please select a valid pickup/delivery time.");
                return false;
            }
            const now = new Date();
            const parts = timeVal.split(':');
            selectedTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), parts[0], parts[1]);
        }


        // Must be at least 1hr from now
        const oneHourLater = new Date(Date.now() + 60 * 60000);
        if (selectedTime < oneHourLater) {
            toastr.error("⚠️ Time must be at least 1 hour from now.");
            return false;
        }

        const day = selectedTime.getDay(); // 0 = Sunday
        const hour = selectedTime.getHours();
        const minute = selectedTime.getMinutes();

        let isValid = false;
        if (day === 0) {
            isValid = false; // Sunday
        } else if (day >= 1 && day <= 5) {
            isValid = hour >= 9 && (hour < 22 || (hour === 22 && minute === 0));
        } else if (day === 6) {
            isValid = hour >= 10 && (hour < 20 || (hour === 20 && minute === 0));
        }

        if (!isValid) {
            toastr.error("⚠️ Selected time is outside working hours.");
            return false;
        }

        // ✅ All checks passed, let flow continue
    });
});
</script>
<script>
$(document).ready(function () {
    const now = new Date();
    const oneHourLater = new Date(now.getTime() + 61 * 60 * 1000); // Add 61 mins instead of 60


    // Pad helper for HH:MM formatting
    function pad(n) {
        return n < 10 ? '0' + n : n;
    }

    // Format time as HH:MM from a Date object
    function formatTime(date) {
        return `${pad(date.getHours())}:${pad(date.getMinutes())}`;
    }

    // Determine min/max time based on day and if today
    function getAllowedTimes(date) {
        const day = date.getDay();
        const isToday = date.toDateString() === new Date().toDateString();
        let minTime = "00:00", maxTime = "23:59";

        if (day === 0) return null; // Sunday closed

        if (day >= 1 && day <= 5) { // Mon–Fri
            minTime = isToday ? formatTime(oneHourLater) : "09:00";
            maxTime = "22:00";
        } else if (day === 6) { // Saturday
            minTime = isToday ? formatTime(oneHourLater) : "10:00";
            maxTime = "20:00";
        }

        return { minTime, maxTime };
    }

    // === Flatpickr for TIME-ONLY (same-day only) ===
    const flatTimeOnly = flatpickr("#flat_time_only", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: formatTime(oneHourLater),
        onReady: function (selectedDates, dateStr, instance) {
            const limits = getAllowedTimes(new Date());
            if (limits) {
                instance.set('minTime', limits.minTime);
                instance.set('maxTime', limits.maxTime);
            } else {
                instance.set('minTime', null);
                instance.set('maxTime', null);
                instance.input.disabled = true;
                instance.input.placeholder = "Restaurant is closed today (Sunday)";
            }
        }
    });

    // === Flatpickr for DATE + TIME (pre-orders) ===
    const flatDateTime = flatpickr("#flat_datetime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: oneHourLater,
        disable: [
            function(date) {
                return date.getDay() === 0; // Disable Sundays
            }
        ],
        onReady: function (selectedDates, dateStr, instance) {
            updateMinMaxTime(instance, oneHourLater);
        },
        onChange: function (selectedDates, dateStr, instance) {
            if (!selectedDates.length) return;
            updateMinMaxTime(instance, selectedDates[0]);
        }
    });

    // Helper: update min/max time based on selected date
    function updateMinMaxTime(instance, selectedDate) {
        const limits = getAllowedTimes(selectedDate);
        if (limits) {
            instance.set('minTime', limits.minTime);
            instance.set('maxTime', limits.maxTime);
        } else {
            instance.set('minTime', null);
            instance.set('maxTime', null);
            instance.input.disabled = true;
            instance.input.placeholder = "Restaurant is closed (Sunday)";
        }
    }

    // Toggle based on pre-order selection
    function toggleSchedulePicker() {
        if ($('#pre_order_yes').is(':checked')) {
            $('#flat_time_only').hide().prop('disabled', true);
            $('#flat_datetime').show().prop('disabled', false);
        } else {
            $('#flat_datetime').hide().prop('disabled', true);
            $('#flat_time_only').show().prop('disabled', false);
        }
    }

    // Run on load and change
    toggleSchedulePicker();
    $('.pre_order_toggle').on('change', toggleSchedulePicker);
});
</script>




@endsection
