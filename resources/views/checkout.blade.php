@extends('layout')

@section('title')
    <title>Secure Checkout | TolaTaste of Africa</title>
@endsection

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="Secure checkout at tolatasteofafrica. Complete your order, add your delivery address in Maryland, and confirm your payment with ease.">
<meta name="keywords" content="tolatasteofafrica checkout, secure checkout, Maryland food delivery, African food online order, order food online Maryland">
<meta name="robots" content="index, follow">
@endsection


@section('public-content')
<!-- Flatpickr CSS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


f
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
<!-- Scheduled Date & Time Picker -->
<div class="wsus__check_single_form mt-3" id="schedule_time_section">
    <label><strong>Pickup/Delivery Time</strong></label>

    <!-- Time only (today) -->
    <div id="flat_time_wrapper">
        <input type="text" class="form-control mt-2" id="flat_time_only" name="flat_time_only" placeholder="Select time for today">
    </div>

    <!-- Date + Time (advance order) -->
    <div id="flat_datetime_wrapper" style="display: none;">
        <input type="text" class="form-control mt-2" id="flat_datetime" name="flat_datetime" placeholder="Select date and time">
    </div>

    <small class="text-muted d-block mt-1">Only available during working hours. Sundays are disabled.</small>
    <div id="sunday_warning" class="text-danger fw-bold mt-2" style="display: none;">
        ⚠️ The restaurant is closed today (Sunday). Please schedule for another day.
    </div>

</div>










<!-- Google Address Autocomplete -->
<!-- Autocomplete Input -->
<!-- Nominatim Address Autocomplete -->
<!-- Map and Autocomplete Section -->
<!--<div class="mb-3" id="autocomplete_wrapper" style="display: none;">-->
<!--  <label for="autocomplete_address">Enter Your Address or Postcode</label>-->
<!--  <input type="text" id="autocomplete_address" name="full_address" class="form-control" placeholder="Start typing your address...">-->
<!--  <div id="address_loader" class="mt-2" style="display: none;">-->
<!--    <span class="spinner-border spinner-border-sm text-primary" role="status"></span> Calculating distance...-->
<!--  </div>-->
<!--  <div id="delivery_details" class="mt-2 text-success fw-bold" style="display: none;"></div>-->
<!--</div>-->
<div class="mb-3" id="autocomplete_wrapper" style="display: none;">

  <!-- Section Heading -->
  <label class="form-label fw-bold d-block mb-2">
    Enter Your Full Address
  </label>

  <!-- Apt / Suite / Floor -->
  <label for="unit_number" class="form-label">
    Apt / Suite / Floor (optional)
  </label>
  <input 
    type="text" 
    id="unit_number" 
    name="unit_number" 
    class="form-control mb-3" 
    placeholder="Apt / Suite / Floor"
  >

  <!-- Street + City + ZIP -->
  <label for="autocomplete_address" class="form-label">
    Street, City, MD ZIP Code
  </label>
  <input 
    type="text" 
    id="autocomplete_address" 
    name="street_address" 
    class="form-control" 
    placeholder="Start typing your street address..."
  >

  <!-- Loader -->
  <div id="address_loader" class="mt-2" style="display: none;">
    <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
    Calculating distance...
  </div>

  <!-- Delivery Details -->
  <div id="delivery_details" class="mt-2 text-success fw-bold" style="display: none;"></div>

</div>




<!-- Hidden Fields -->
<input type="hidden" id="calculated_delivery_distance">
<input type="hidden" id="calculated_delivery_fee">







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
                        <div class="wsus__check_single_form mt-3">
                            <label for="tip_amount"><strong>Would you like to leave a tip?</strong></label>
                            <input type="number" min="0" step="0.01" class="form-control mt-2" id="tip_amount" placeholder="Enter tip amount (optional)">
                        </div>


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
                                <form action="{{ route('stripe-payment') }}" method="POST" id="payment-form">
    @csrf
    <input type="hidden" name="tip" id="stripe_tip">
    <input type="hidden" name="is_preorder" id="stripe_is_preorder">
    <input type="hidden" name="flat_datetime" id="stripe_flat_datetime">
    <input type="hidden" name="flat_time_only" id="stripe_flat_time_only">
    <input type="hidden" name="payment_intent_id" id="payment_intent_id">

    @if(session()->has('guest_user'))
        <input type="hidden" name="guest_name" value="{{ session('guest_user.name') }}">
        <input type="hidden" name="guest_email" value="{{ session('guest_user.email') }}">
        <input type="hidden" name="guest_phone" value="{{ session('guest_user.phone') }}">
    @endif

    <div class="mb-3">
        <label class="form-label">{{ __('Cardholder Name') }}</label>
        <input type="text" class="form-control" id="card-name" name="card_name" placeholder="Your name" required>
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('Card Details') }}</label>
        <div id="card-element" class="form-control p-2"></div>
    </div>

    <div id="card-errors" class="text-danger mt-2"></div>

    <div class="d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">{{ __('user.Close') }}</button>
        <button type="submit" id="submit_payment_btn" class="btn btn-success">{{ __('user.Submit') }}</button>
    </div>

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



<!-- Leaflet Control Geocoder for Nominatim autocomplete -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />


<!-- Stripe Payment Script -->
<!--<script type="text/javascript" src="https://js.stripe.com/v2/"></script>-->
<script src="https://js.stripe.com/v3/"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH9tWBuZvP4ynikRv_0mMgL51pG6076nA&libraries=places"></script>
<script>
    const ORS_API_KEY = @json(config('services.openrouteservice.key'));
</script>


<script>
const storeLat = 39.322476;
const storeLng = -76.714881;

function initGoogleAutocomplete() {
  const input = document.getElementById('autocomplete_address');
  const loader = document.getElementById('address_loader');
  const deliveryDetails = document.getElementById('delivery_details');

  // Update placeholder to guide users
  input.placeholder = 'Enter street, city, MD ZIP Code';

  // Enable Google Places autocomplete
  const autocomplete = new google.maps.places.Autocomplete(input, {
    fields: ['formatted_address', 'address_components', 'geometry'],
    componentRestrictions: { country: 'us' },
    types: ['address']
  });

  // When user selects an address
  autocomplete.addListener('place_changed', async function () {
    const place = autocomplete.getPlace();

    if (!place || !place.geometry || !place.formatted_address) {
      toastr.error('❌ Please pick an address from the list');
      return;
    }

    // Must be Maryland
    const addr = place.address_components || [];
    const inMD = addr.some(c =>
      (c.types || []).includes('administrative_area_level_1') &&
      (c.short_name === 'MD' || c.long_name === 'Maryland')
    );
    if (!inMD) {
      toastr.error('❌ We only deliver within Maryland, USA');
      input.value = '';
      return;
    }

    const lat = place.geometry.location.lat();
    const lon = place.geometry.location.lng();
    //const fullAddress = place.formatted_address;
    const unit = document.getElementById('unit_number').value.trim();
    const fullAddress = unit ? `${place.formatted_address}, ${unit}` : place.formatted_address;


    loader.style.display = 'block';

    try {
      // Call ORS to get distance in miles
      const res = await fetch('https://api.openrouteservice.org/v2/matrix/driving-car', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': ORS_API_KEY // define this in your app
        },
        body: JSON.stringify({
          locations: [[storeLng, storeLat], [lon, lat]], // lon,lat order
          metrics: ['distance'],
          units: 'mi'
        })
      });
      const data = await res.json();
      loader.style.display = 'none';

      const distance = data?.distances?.[0]?.[1] || 0;
      if (!distance) {
        toastr.error('❌ Invalid distance data');
        return;
      }

      $('#calculated_delivery_distance').val(distance.toFixed(2));

      // Load your fee settings
      const settings = await fetch('/api/delivery-settings').then(r => r.json());

      let fee = 0;
      if (distance <= 5) fee = distance * parseFloat(settings.base_fee_per_mile);
      else if (distance <= 10) fee = distance * parseFloat(settings.mid_fee_per_mile);
      else fee = distance * parseFloat(settings.long_fee_per_mile);

      $('#calculated_delivery_fee').val(fee.toFixed(2));
      $('.delivery_charge').html(`$${fee.toFixed(2)}`);

      deliveryDetails.innerHTML =
        `✅ ${fullAddress}<br>📍 Distance: ${distance.toFixed(2)} miles<br>🚚 Delivery Fee: $${fee.toFixed(2)}`;
      deliveryDetails.style.display = 'block';

      recalculateTotal(fee);

      // Save to backend
      $.get("{{ url('/set-delivery-charge') }}", { charge: fee.toFixed(2) })
        .done(() => {
          $.post("{{ url('/set-typed-delivery-address') }}", {
            _token: "{{ csrf_token() }}",
            address: fullAddress,
            distance: distance.toFixed(2),
            fee: fee.toFixed(2)
          });
        });

    } catch (e) {
      loader.style.display = 'none';
      toastr.error('❌ Failed to calculate distance');
    }
  });
}

const storeAddress = '5213 Windsor Mill Road, Baltimore, MD, USA';


// ✅ Clean recalculateTotal function
function recalculateTotal(delivery_fee = null) {
    let base_total = parseFloat($("#sub_total").val()) || 0;
    let coupon = parseFloat($(".coupon_discount_amount").text().replace("{{ $currency_icon }}", "").trim()) || 0;
    let fee = delivery_fee !== null ? parseFloat(delivery_fee) : (parseFloat($("#calculated_delivery_fee").val()) || 0);
    let tip = parseFloat($("#tip_amount").val()) || 0;

    let taxable_amount = base_total - coupon + fee;
    let tax = (taxable_amount * 6) / 100;
    let grand_total = taxable_amount + tax + tip;

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

        //Trigger total update on tip input
        $('#tip_amount').on('input', function () {
        recalculateTotal();
    });


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
  initGoogleAutocomplete();
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
<style>
/* CSS for suggestions */
.suggestion-box {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #ddd;
    z-index: 9999;
    display: none;   /* ❌ THIS is the problem */
    max-height: 200px;
    overflow-y: auto;
}

</style>
<script>
// Stripe validation & dynamic pickup/delivery time logic
$(document).ready(function () {
    const $form = $(".require-validation");

    // Helper: Get store time in Baltimore (America/New_York)
    function getStoreTime() {
        const storeTimeStr = new Date().toLocaleString("en-US", { timeZone: "America/New_York" });
        return new Date(storeTimeStr);
    }

    // ✅ CSRF Token Validation Block
    const csrfMeta = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : '';

    const stripe = Stripe("{{ $stripePaymentInfo->stripe_key }}");
    const elements = stripe.elements();
    const card = elements.create("card", {
        style: {
            base: {
                color: "#32325d",
                fontSize: "16px",
                '::placeholder': { color: '#aab7c4' }
            },
            invalid: {
                color: "#fa755a",
                iconColor: "#fa755a"
            }
        }
    });
    card.mount("#card-element");

    card.on("change", function (event) {
        document.getElementById("card-errors").textContent = event.error ? event.error.message : "";
    });

    const form = document.getElementById("payment-form");

    form.addEventListener("submit", async function (event) {
        event.preventDefault();

        document.getElementById("submit_payment_btn").disabled = true;
        document.getElementById("payment_loader").classList.remove("d-none");

        const cardholderName = document.getElementById("card-name").value;
        const tipAmount = parseFloat(document.getElementById("tip_amount")?.value || 0).toFixed(2);

        document.getElementById("stripe_tip").value = tipAmount;

        try {
            const response = await fetch("{{ route('create-payment-intent') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    tip: tipAmount,
                    name: cardholderName
                })
            });

            const data = await response.json();

            if (!data.clientSecret) {
                throw new Error("❌ Failed to initialize Stripe payment.");
            }

            const result = await stripe.confirmCardPayment(data.clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: cardholderName
                    }
                }
            });

            if (result.error) {
                document.getElementById("card-errors").textContent = result.error.message;
                document.getElementById("submit_payment_btn").disabled = false;
                document.getElementById("payment_loader").classList.add("d-none");
            } else if (result.paymentIntent.status === "succeeded") {
                document.getElementById("payment_intent_id").value = result.paymentIntent.id;

                // ✅ Update preorder & time inputs before form submit
                document.getElementById("stripe_is_preorder").value = document.querySelector('.pre_order_toggle:checked')?.value || 0;
                document.getElementById("stripe_flat_datetime").value = document.getElementById("flat_datetime")?.value || '';
                document.getElementById("stripe_flat_time_only").value = document.getElementById("flat_time_only")?.value || '';

                form.submit();
            }
        } catch (err) {
            document.getElementById("card-errors").textContent = err.message;
            document.getElementById("submit_payment_btn").disabled = false;
            document.getElementById("payment_loader").classList.add("d-none");
        }
    });

    // Set min time for both inputs
    function setTimeOnlyMin() {
        const now = getStoreTime();
        now.setHours(now.getHours() + 1);
        $('#time_only').attr('min', now.toTimeString().slice(0, 5)); // HH:MM
    }

    function setDateTimeMin() {
        const now = getStoreTime();
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
        const now = getStoreTime(); // ✅ Baltimore time

        if ($('#pre_order_yes').is(':checked')) {
            const dt = $('#flat_datetime').val();
            if (!dt) {
                toastr.error("⚠️ Please select a valid date and time.");
                return false;
            }
            selectedTime = new Date(dt);
        } else {
            const timeVal = $('#flat_time_only').val();
            if (!timeVal) {
                toastr.error("⚠️ Please select a valid pickup/delivery time.");
                return false;
            }
            const parts = timeVal.split(':');
            selectedTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), parts[0], parts[1]);
        }

        // Must be at least 1hr from now
        const oneHourLater = new Date(now.getTime() + 60 * 60000);
        if (selectedTime < oneHourLater) {
            toastr.error("⚠️ Time must be at least 1 hour from now.");
            return false;
        }

        const day = selectedTime.getDay();
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
   // const now = new Date();
       function getStoreTime() {
        // Get store time in Baltimore timezone
        const storeTimeStr = new Date().toLocaleString("en-US", { timeZone: "America/New_York" });
        return new Date(storeTimeStr);
    }
    const now = getStoreTime();
    const oneHourLater = new Date(now.getTime() + 61 * 60 * 1000);
    // const oneHourLater = new Date(now.getTime() + 61 * 60 * 1000);

    // Pad helper for HH:MM formatting
    function pad(n) {
        return n < 10 ? '0' + n : n;
    }

    function formatTime(date) {
        return `${pad(date.getHours())}:${pad(date.getMinutes())}`;
    }

    // Time range logic based on weekday
    function getAllowedTimes(date) {
        const day = date.getDay();
        const isToday = date.toDateString() === new Date().toDateString();
        let minTime = "00:00", maxTime = "23:59";

        if (day === 0) return null; // Sunday = closed
        if (day >= 1 && day <= 5) { // Mon–Fri
            minTime = isToday ? formatTime(oneHourLater) : "09:00";
            maxTime = "22:00";
        } else if (day === 6) { // Saturday
            minTime = isToday ? formatTime(oneHourLater) : "10:00";
            maxTime = "20:00";
        }

        return { minTime, maxTime };
    }

    // Initialize time-only picker
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
                instance.input.placeholder = "Closed on Sundays";
            }
        }
    });

    // Initialize date+time picker (will be re-inited later too)
    function initFlatDateTime() {
        return flatpickr("#flat_datetime", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: oneHourLater,
            disable: [
                function(date) {
                    return date.getDay() === 0; // Disable Sundays
                }
            ],
            onReady: function (selectedDates, dateStr, instance) {
                const limits = getAllowedTimes(oneHourLater);
                if (limits) {
                    instance.set('minTime', limits.minTime);
                    instance.set('maxTime', limits.maxTime);
                }
            },
            onChange: function (selectedDates, dateStr, instance) {
                if (!selectedDates.length) return;
                const limits = getAllowedTimes(selectedDates[0]);
                if (limits) {
                    instance.set('minTime', limits.minTime);
                    instance.set('maxTime', limits.maxTime);
                }
            }
        });
    }

    let flatDateTimeInstance = initFlatDateTime();

    // 🔄 Toggle visibility and reinit Flatpickr
    function toggleScheduleInput() {
        const isPreorder = $('#pre_order_yes').is(':checked');

        if (isPreorder) {
            $('#flat_time_only').parent().hide();
            $('#flat_datetime').parent().show();
            $('#flat_time_only').prop('disabled', true);
            $('#flat_datetime').prop('disabled', false);

            // 🔁 Destroy and re-init datetime picker
            if ($('#flat_datetime')[0]._flatpickr) {
                $('#flat_datetime')[0]._flatpickr.destroy();
            }
            flatDateTimeInstance = initFlatDateTime();

        } else {
            $('#flat_datetime').parent().hide();
            $('#flat_time_only').parent().show();
            $('#flat_datetime').prop('disabled', true);
            $('#flat_time_only').prop('disabled', false);
        }
    }

    // Schedule restrictions
    function updateScheduleRestrictions() {
    const now = getStoreTime(); // ✅ Use Baltimore time
    const currentDay = now.getDay(); // 0 = Sunday
    const preorderYes = $('#pre_order_yes').is(':checked');


    // Define business hours
    const businessHours = {
        0: null, // Sunday: Closed
        1: { start: "09:00", end: "22:00" }, // Monday
        2: { start: "09:00", end: "22:00" }, // Tuesday
        3: { start: "09:00", end: "22:00" }, // Wednesday
        4: { start: "09:00", end: "22:00" }, // Thursday
        5: { start: "09:00", end: "22:00" }, // Friday
        6: { start: "10:00", end: "20:00" }  // Saturday
    };

    const todayHours = businessHours[currentDay];

    function parseTime(t) {
        const [h, m] = t.split(":").map(Number);
        return new Date(now.getFullYear(), now.getMonth(), now.getDate(), h, m);
    }

    let isOpenNow = false;
    if (todayHours) {
        const start = parseTime(todayHours.start);
        const end = parseTime(todayHours.end);
        isOpenNow = now >= start && now <= end;
    }

    const openTimeMessages = {
        1: "⚠️ The restaurant is currently closed. Opens in the morning at 9:00 AM (Monday).",
        2: "⚠️ The restaurant is currently closed. Opens in the morning at 9:00 AM (Tuesday).",
        3: "⚠️ The restaurant is currently closed. Opens in the morning at 9:00 AM (Wednesday).",
        4: "⚠️ The restaurant is currently closed. Opens in the morning at 9:00 AM (Thursday).",
        5: "⚠️ The restaurant is currently closed. Opens in the morning at 9:00 AM (Friday).",
        6: "⚠️ The restaurant is currently closed. Opens in the morning at 10:00 AM (Saturday).",
        0: "⚠️ The restaurant is closed today (Sunday). Please schedule for another day."
    };

    if (!todayHours || !isOpenNow) {
        // Closed today or currently outside business hours
        if (!preorderYes) {
            $('#flat_time_only').prop('disabled', true).val('').attr('placeholder', 'Closed now');
            $('#flat_datetime').prop('disabled', true);
            $('#autocomplete_address').prop('disabled', true).val('').attr('placeholder', 'Closed');
            $('#continue_to_pay')
                .addClass('disabled')
                .css({ pointerEvents: 'none', opacity: 0.6 })
                .html('We are currently closed');

            // Show day-specific warning
            $('#sunday_warning')
                .text(openTimeMessages[currentDay] || '⚠️ The restaurant is currently closed. Please try again later.')
                .show();

            return;
        } else {
            // Allow preorder
            $('#flat_time_only').prop('disabled', true);
            $('#flat_datetime').prop('disabled', false);
            $('#autocomplete_address').prop('disabled', false);
            $('#continue_to_pay')
                .removeClass('disabled')
                .css({ pointerEvents: 'auto', opacity: 1 })
                .html('Continue to pay');
            $('#sunday_warning').hide();
        }
    } else {
        // Business is open now
        $('#flat_time_only').prop('disabled', false);
        $('#autocomplete_address').prop('disabled', false);
        $('#continue_to_pay')
            .removeClass('disabled')
            .css({ pointerEvents: 'auto', opacity: 1 })
            .html('Continue to pay');
        $('#sunday_warning').hide();
    }

    toggleScheduleInput();
}


    // Run on load
    updateScheduleRestrictions();

    $('.pre_order_toggle').on('change', function () {
        updateScheduleRestrictions();
    });
});
</script>



@endsection
