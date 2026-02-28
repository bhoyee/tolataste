@extends('layout')
@section('title')
    <title>{{__('user.Shopping Cart')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Shopping Cart')}}">
@endsection

@section('public-content')

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Shopping Cart')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="javascript:;">{{__('user.Shopping Cart')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->



    <section class="wsus__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container cart-main-body">
            @if (count($cart_contents) == 0)
                <div class="row">
                    <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                        <h3 class="text-center cart_empty_text">{{__('user.Your shopping cart is empty!')}}</h3>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__cart_list">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th class="wsus__pro_img">
                                                {{__('user.Image')}}
                                            </th>

                                            <th class="wsus__pro_name">
                                                {{__('user.details')}}
                                            </th>

                                            <th class="wsus__pro_status">
                                                {{__('user.price')}}
                                            </th>

                                            <th class="wsus__pro_select">
                                                {{__('user.quantity')}}
                                            </th>

                                            <th class="wsus__pro_tk">
                                                {{__('user.total')}}
                                            </th>

                                            <th class="wsus__pro_icon">
                                                <a class="clear_all" href="javascript:;">{{__('user.clear all')}}</a>
                                            </th>
                                        </tr>

                                        @php
                                            $sub_total = 0;
                                            $coupon_price = 0.00;
                                        @endphp
                                        @foreach ($cart_contents as $index => $cart_content)
                                            <tr class="main-cart-item-{{ $cart_content->rowId }}">
                                                <td class="wsus__pro_img"><img src="{{ asset($cart_content->options->image) }}" alt="product"
                                                        class="img-fluid w-100">
                                                </td>


                                                <td class="wsus__pro_name">
                                                    <a href="{{ route('show-product', $cart_content->options->slug) }}">
                                                        {{ $cart_content->name }}
                                                    </a>

                                                    {{-- ✅ Show protein items --}}
                                                    @php
                                                        $proteins = $cart_content->options->protein_items ?? [];
                                                    @endphp

                                                    @foreach ($proteins as $protein)
                                                        @php
                                                            $name = is_array($protein) ? $protein['protein_name'] ?? '' : ($protein->protein_name ?? '');
                                                            $price = is_array($protein) ? $protein['protein_price'] ?? '' : ($protein->protein_price ?? '');
                                                        @endphp
                                                        @if (!empty($name))
                                                            <p>{{ $name }} (+{{ $currency_icon }}{{ $price }})</p>
                                                        @endif
                                                    @endforeach

                                                    {{-- ✅ Show soup items --}}
                                                    @foreach ($cart_content->options->soup_items ?? [] as $soup)
                                                        <p>{{ $soup['soup_name'] ?? '' }} (+{{ $currency_icon }}{{ $soup['soup_price'] ?? '' }})</p>
                                                    @endforeach

                                                    {{-- ✅ Show wrap items --}}
                                                    @foreach ($cart_content->options->wrap_items ?? [] as $wrap)
                                                        <p>{{ $wrap['wrap_name'] ?? '' }} (+{{ $currency_icon }}{{ $wrap['wrap_price'] ?? '' }})</p>
                                                    @endforeach

                                                    {{-- ✅ Show drink items --}}
                                                    @foreach ($cart_content->options->drink_items ?? [] as $drink)
                                                        <p>{{ $drink['drink_name'] ?? '' }} (+{{ $currency_icon }}{{ $drink['drink_price'] ?? '' }})</p>
                                                    @endforeach

                                                    {{-- ✅ Show optional items --}}
                                                    @foreach ($cart_content->options->optional_items ?? [] as $optional)
                                                        <p>{{ $optional['optional_name'] ?? '' }} (+{{ $currency_icon }}{{ $optional['optional_price'] ?? '' }})</p>
                                                    @endforeach



                                                    {{-- ✅ Handle food instruction --}}
                                                    @php
                                                        $instruction = $cart_content->options->food_instruction ?? '';
                                                        $short_instruction = \Illuminate\Support\Str::limit($instruction, 30, '...');
                                                        $rowId = $cart_content->rowId; // To ensure unique modal ID
                                                    @endphp

                                                    @if (!empty($instruction))
                                                        <p>
                                                            <strong>{{ __('Food Instruction') }}:</strong>
                                                            {{ $short_instruction }}
                                                            <button class="btn btn-link p-0" data-bs-toggle="modal" data-bs-target="#instructionModal-{{ $rowId }}">
                                                                <small style="color: #007bff; text-decoration: underline;">View More</small>
                                                            </button>
                                                        </p>

                                                        <!-- Modal to show full instruction -->
                                                        <div class="modal fade" id="instructionModal-{{ $rowId }}" tabindex="-1" aria-labelledby="instructionModalLabel-{{ $rowId }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content p-3">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="instructionModalLabel-{{ $rowId }}">{{ __('Full Food Instruction') }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>{{ $instruction }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <p style="color: orange;">{{ __('No food instruction provided') }}</p>
                                                    @endif
                                                </td>


                                                @php
                                                    // price already includes addons, no need to add addons_price separately
                                                    $unit_price_with_addons = $cart_content->price;

                                                    $item_total = $unit_price_with_addons * $cart_content->qty;
                                                    $sub_total += $item_total;
                                                @endphp

                                                <td class="wsus__pro_status">
                                                    <h6>{{ $currency_icon }}{{ number_format($unit_price_with_addons, 2) }}</h6>
                                                </td>




                                                <td class="wsus__pro_select" data-item-price="{{ $cart_content->price }}" data-optional-price="{{ $cart_content->options->optional_item_price }}" data-rowid="{{ $cart_content->rowId }}">
                                                    <div class="quentity_btn">
                                                        <button class="btn btn-danger decrement_product"><i class="fal fa-minus"></i></button>
                                                        <input class="quantity" type="text" readonly value="{{ $cart_content->qty }}">
                                                        <button class="btn btn-success increament_product"><i class="fal fa-plus"></i></button>
                                                    </div>
                                                </td>

                                                <td class="wsus__pro_tk">
                                                    <h6>{{ $currency_icon }}{{ $item_total }}</h6>
                                                    <input type="hidden" class="product_total" value="{{ $item_total }}">
                                                </td>

                                                <td class="wsus__pro_icon" data-remove-rowid="{{ $cart_content->rowId }}">
                                                    <a class="remove_item" href="javascript:;"><i class="far fa-times"></i></a>
                                                    <a href="{{ route('cart.edit.page', $cart_content->rowId) }}">
    <i class="far fa-edit"></i>
</a>

                                                </td>
                                            

                                            </tr>


                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if (Session::get('coupon_price') && Session::get('offer_type'))
                        <input type="hidden" id="couon_price" value="{{ Session::get('coupon_price') }}">
                        <input type="hidden" id="couon_offer_type" value="{{ Session::get('offer_type') }}">

                        @php
                             if(Session::get('offer_type') == 1) {
                                $coupon_price = Session::get('coupon_price');
                                $coupon_price = ($coupon_price / 100) * $sub_total;
                            }else {
                                $coupon_price = Session::get('coupon_price');
                            }
                        @endphp
                    @else
                        <input type="hidden" id="couon_price" value="0.00">
                        <input type="hidden" id="couon_offer_type" value="0">
                    @endif

                    @php
                        $tax_rate = 6; // or pull from DB later
                        $tax = ($sub_total * $tax_rate) / 100;
                        $total_after_coupon = $sub_total - $coupon_price;
                        $grand_total = $total_after_coupon + $tax;
                    @endphp


                    <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__cart_list_footer_button">
                        <div class="grand_total">
                            <h6>{{ __('user.total price') }}</h6>
                            <p>{{ __('user.subtotal') }}: <span>{{ $currency_icon }}{{ number_format($sub_total, 2) }}</span></p>
                            <p>{{ __('user.discount') }} (-): <span>{{ $currency_icon }}{{ number_format($coupon_price, 2) }}</span></p>
                            <p>{{ __('user.tax') }} (+): <span>{{ $currency_icon }}{{ number_format($tax, 2) }}</span></p>
                            <p>{{ __('user.delivery') }} (+): <span>{{ $currency_icon }}0.00</span></p>
                            <p class="total">
                                <span>{{ __('user.Total') }}:</span>
                                <span>{{ $currency_icon }}{{ number_format($grand_total, 2) }}</span>
                            </p>
                        </div>

                            <form id="coupon_form">
                                <input name="coupon" type="text" placeholder="{{__('user.Coupon Code')}}">
                                <button type="submit">{{__('user.apply')}}</button>
                            </form>
                            <!-- <a class="common_btn" href="{{ route('checkout') }}">{{__('user.checkout')}}</a> -->
                            <a href="javascript:void(0);" class="common_btn" onclick="showGuestCheckoutModal()">Checkout</a>

                        </div>
                    </div>
                </div>

            @endif
        </div>

        <!-- Edit Cart Modal -->
<div class="modal fade" id="editCartModal" tabindex="-1" aria-labelledby="editCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Content loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

    </section>



    <script>
        (function($) {
            "use strict";
            $(document).ready(function () {

                $("#coupon_form").on("submit", function(e){
                    e.preventDefault();

                    $.ajax({
                        type: 'get',
                        data: $('#coupon_form').serialize(),
                        url: "{{ url('/apply-coupon') }}",
                        success: function (response) {
                            toastr.success(response.message)
                            $("#coupon_form").trigger("reset");

                            $("#couon_price").val(response.discount);
                            $("#couon_offer_type").val(response.offer_type);

                            calculate_total();
                        },
                        error: function(response) {
                            if(response.status == 422){
                                if(response.responseJSON.errors.coupon)toastr.error(response.responseJSON.errors.coupon[0])
                            }

                            if(response.status == 500){
                                toastr.error("{{__('user.Server error occured')}}")
                            }

                            if(response.status == 403){
                                toastr.error(response.responseJSON.message)
                            }
                        }
                    });
                })
                $("#add_to_cart").on("click", function(e){
                    e.preventDefault();
                    if ($("input[name='size_variant']").is(":checked")) {
                        $("#add_to_cart_form").submit();
                    } else {
                        toastr.error("{{__('user.Please select a size')}}")
                    }
                });

                $("input[name='size_variant']").on("change", function(){
                    $("#variant_price").val($(this).data('variant-price'))
                    calculatePrice()
                })

                $("input[name='optional_items[]']").change(function() {
                    calculatePrice()
                });

                $(".increament_product").on("click", function(){
                    let parernt_td = $(this).parents('td');
                    let item_price = parernt_td.data('item-price')
                    let optional_price = parernt_td.data('optional-price')
                    let quantity = parernt_td.find('.quantity').val();
                    let new_qty = parseInt(quantity) + parseInt(1);
                    parernt_td.find('.quantity').val(new_qty)
                    let new_item_price = parseInt(new_qty) * parseInt(item_price);
                    let new_sub_total_price = parseInt(new_item_price) + parseInt(optional_price);
                    let parent_tr = parernt_td.parents('tr');
                    let product_sub_total_html = `<h6>{{ $currency_icon }}${new_sub_total_price}</h6> <input type="hidden" class="product_total" value="${new_sub_total_price}">`
                    parent_tr.find('.wsus__pro_tk').html(product_sub_total_html);

                    let rowid = parernt_td.data('rowid')
                    $(".mini-price-"+rowid).html(`{{ $currency_icon }}${new_sub_total_price}`)
                    $(".set-mini-input-price-"+rowid).val(new_sub_total_price)
                    update_item_qty(rowid, new_qty);
                })

                $(".decrement_product").on("click", function(){
                    let parernt_td = $(this).parents('td');
                    let item_price = parernt_td.data('item-price')
                    let optional_price = parernt_td.data('optional-price')
                    let quantity = parernt_td.find('.quantity').val();
                    if(quantity == 1)return;
                    let new_qty = parseInt(quantity) - parseInt(1);
                    parernt_td.find('.quantity').val(new_qty)
                    let new_item_price = parseInt(new_qty) * parseInt(item_price);
                    let new_sub_total_price = parseInt(new_item_price) + parseInt(optional_price);
                    let parent_tr = parernt_td.parents('tr');
                    let product_sub_total_html = `<h6>{{ $currency_icon }}${new_sub_total_price}</h6>
                    <input type="hidden" class="product_total" value="${new_sub_total_price}">`
                    parent_tr.find('.wsus__pro_tk').html(product_sub_total_html);

                    let rowid = parernt_td.data('rowid')
                    $(".mini-price-"+rowid).html(`{{ $currency_icon }}${new_sub_total_price}`)
                    $(".set-mini-input-price-"+rowid).val(new_sub_total_price)

                    update_item_qty(rowid, new_qty);

                })

                $(".remove_item").on("click", function(){
                    let parernt_td = $(this).parents('td');
                    let rowid = parernt_td.data('remove-rowid');
                    let parent_tr = parernt_td.parents('tr');
                    parent_tr.remove();
                    calculate_total();
                    remove_mini_item(rowid)

                    $.ajax({
                        type: 'get',
                        url: "{{ url('/remove-cart-item') }}" + "/" + rowid,
                        success: function (response) {
                            toastr.success(response.message);
                        },
                        error: function(response) {
                            if(response.status == 500){
                                toastr.error("{{__('user.Server error occured')}}")
                            }

                            if(response.status == 403){
                                toastr.error("{{__('user.Server error occured')}}")
                            }
                        }
                    });

                })

                $(".clear_all").on("click", function(){

                    let empty_cart = `<div class="row">
                        <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                            <h3 class="text-center cart_empty_text">{{__('user.Your shopping cart is empty!')}}</h3>
                        </div>
                    </div>`;

                    let mini_empty_cart = `<div class="wsus__menu_cart_header">
                                    <h5>{{__('user.Your cart is empty')}}</h5>
                                    <span class="close_cart"><i class="fal fa-times"></i></span>
                                </div>
                                `;

                    $(".cart-main-body").html(empty_cart)
                    $(".wsus__menu_cart_boody").html(mini_empty_cart)
                    $(".topbar_cart_qty").html(0);

                    $.ajax({
                        type: 'get',
                        url: "{{ url('/cart-clear') }}",
                        success: function (response) {
                            toastr.success(response.message);
                        },
                        error: function(response) {
                            if(response.status == 500){
                                toastr.error("{{__('user.Server error occured')}}")
                            }

                            if(response.status == 403){
                                toastr.error("{{__('user.Server error occured')}}")
                            }
                        }
                    });
                })







            });
        })(jQuery);

        function update_item_qty(rowid, quantity){
            calculate_total();
            $.ajax({
                type: 'get',
                data: {rowid, quantity},
                url: "{{ route('cart-quantity-update') }}",
                success: function (response) {

                },
                error: function(response) {
                    if(response.status == 500){
                        toastr.error("{{__('user.Server error occured')}}")
                    }

                    if(response.status == 403){
                        toastr.error("{{__('user.Server error occured')}}")
                    }
                }
            });
        }

        function calculate_total(){
            let sub_total = 0;
            let coupon_price = $("#couon_price").val();
            let couon_offer_type = $("#couon_offer_type").val();


            let total_item = 0;
            $(".product_total").each(function () {
                let current_val = $(this).val();
                sub_total = parseInt(sub_total) + parseInt(current_val);
                total_item = parseInt(total_item) + parseInt(1);
            });


            let apply_coupon_price = 0.00;
            if(couon_offer_type == 1) {
                let percentage = parseInt(coupon_price) / parseInt(100)
                apply_coupon_price = (parseFloat(percentage) * parseFloat(sub_total));
            }else if(couon_offer_type == 2) {
                apply_coupon_price = coupon_price;
            }

            let grand_total = parseInt(sub_total) - parseInt(apply_coupon_price);
            let total_html = `<h6>{{__('user.total cart')}}</h6>
                            <p>{{__('user.subtotal')}}: <span>{{ $currency_icon }}${sub_total}</span></p>
                            <p>{{__('user.discount')}} (-): <span>{{ $currency_icon }}${apply_coupon_price}</span></p>
                            <p>{{__('user.delivery')}} (+): <span>{{ $currency_icon }}0.00</span></p>
                            <p class="total"><span>{{__('user.Total')}}:</span> <span>{{ $currency_icon }}${grand_total}</span></p>`;
            $(".grand_total").html(total_html);
            $(".mini_sub_total").html(`{{ $currency_icon }}${sub_total}`);

            let empty_cart = `<div class="row">
                    <div class="col-12 wow fadeInUp" data-wow-duration="1s">
                        <h3 class="text-center cart_empty_text">{{__('user.Your shopping cart is empty!')}}</h3>
                    </div>
                </div>`;

            let mini_empty_cart = `<div class="wsus__menu_cart_header">
                <h5>{{__('user.Your cart is empty')}}</h5>
                <span class="close_cart"><i class="fal fa-times"></i></span>
            </div>
            `;

            if(total_item == 0){
                $(".cart-main-body").html(empty_cart)
                $(".wsus__menu_cart_boody").html(mini_empty_cart)
            }

            $(".topbar_cart_qty").html(total_item);

        }

        function remove_mini_item(rowid){
            $(".min-item-"+rowid).remove();
        }

function showGuestCheckoutModal() {
    $('#guestCheckoutModal').modal('show');
}

 

    </script>
@endsection
