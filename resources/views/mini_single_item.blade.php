@php
    use Gloudemans\Shoppingcart\Facades\Cart;

    $mini_cart_contents = Cart::content();
    $mini_sub_total = 0;
    $currency_icon = config('currency.icon', '$');

    function ensureArray($data) {
        if (is_array($data)) return $data;
        if ($data instanceof \Illuminate\Support\Collection) return $data->toArray();
        if ($data instanceof \stdClass) return json_decode(json_encode($data), true);
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }
@endphp

<div>
    <div class="wsus__menu_cart_header">
        <h5 class="mini_cart_body_item">
            {{ __('user.Total Item') }} ({{ $mini_cart_contents->count() }})
        </h5>
        <span class="close_cart"><i class="fas fa-times"></i></span>
    </div>

    <ul class="mini_cart_list">
    @foreach ($mini_cart_contents as $cart)
    @php
        $rowId = $cart->rowId;
        $qty = $cart->qty;
        $total_price = $cart->price * $qty;
        $mini_sub_total += $total_price;
    @endphp

    <li class="min-item-{{ $rowId }}">
        <div class="menu_cart_img">
            <img src="{{ asset($cart->options->image) }}" alt="menu" class="img-fluid w-100">
        </div>

        <div class="menu_cart_text">
            <a class="title" href="{{ route('show-product', $cart->options->slug) }}">
                {{ $cart->name }}
            </a>

            @foreach ($cart->options->optional_items ?? [] as $item)
                <span class="extra">{{ $item['optional_name'] ?? '' }} (+{{ $currency_icon }}{{ $item['optional_price'] ?? '0' }})</span>
            @endforeach

            @foreach ($cart->options->protein_items ?? [] as $item)
                <span class="extra">{{ $item['protein_name'] ?? '' }} (+{{ $currency_icon }}{{ $item['protein_price'] ?? '0' }})</span>
            @endforeach

            @foreach ($cart->options->soup_items ?? [] as $item)
                <span class="extra">{{ $item['soup_name'] ?? '' }} (+{{ $currency_icon }}{{ $item['soup_price'] ?? '0' }})</span>
            @endforeach

            @foreach ($cart->options->wrap_items ?? [] as $item)
                <span class="extra">{{ $item['wrap_name'] ?? '' }} (+{{ $currency_icon }}{{ $item['wrap_price'] ?? '0' }})</span>
            @endforeach

            @foreach ($cart->options->drink_items ?? [] as $item)
                <span class="extra">{{ $item['drink_name'] ?? '' }} (+{{ $currency_icon }}{{ $item['drink_price'] ?? '0' }})</span>
            @endforeach

            <p class="price mini-price-{{ $rowId }}">
                {{ $currency_icon }}{{ number_format($total_price, 2) }}
            </p>
        </div>

     <div class="cart-item-actions">
        <a href="{{ route('cart.edit.page', $rowId) }}" class="edit_item">
            <i class="fal fa-edit"></i>
        </a>
        <span class="delete-item mini-item-remove" data-rowid="{{ $rowId }}">
            <i class="fal fa-times"></i>
        </span>
    </div>

        <input type="hidden" class="mini-input-price" value="{{ $total_price }}">
    </li>
@endforeach

    </ul>

    <p class="subtotal">
        {{ __('user.Sub Total') }}
        <span class="mini_sub_total">{{ $currency_icon }}{{ number_format($mini_sub_total, 2) }}</span>
    </p>

    <a class="cart_view" href="{{ route('cart') }}">{{ __('user.view cart') }}</a>
    <!-- <a class="checkout" href="{{ route('checkout') }}">{{ __('user.checkout') }}</a> -->
    <!--<a href="javascript:void(0);" class="checkout" onclick="showGuestCheckoutModal()">Checkout</a>-->
               @auth
<a href="{{ route('checkout') }}" class="checkout">Checkout</a>
@else
<a href="javascript:void(0);" class="checkout" onclick="showGuestCheckoutModal()">Checkout</a>
@endauth

</div>


<script>
        (function($) {
            "use strict";
            $(document).ready(function () {

                function showGuestCheckoutModal() {
                    $('#guestCheckoutModal').modal('show');
                }
            })})