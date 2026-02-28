<form id="modal_add_to_cart_form" method="POST">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">
    <input type="hidden" name="variant_price" id="modal_variant_price" value="{{ $product->is_offer ? $product->offer_price : $product->price }}">
    <input type="hidden" name="price" id="modal_price" value="0">

    <!--<div class="wsus__cart_popup_img">-->
    <!--    <img src="{{ asset($product->thumb_image) }}" alt="menu" class="img-fluid w-100">-->
    <!--</div>-->
    @if($product->galleryImages->isNotEmpty())
    <img src="{{ asset($product->galleryImages->first()->image) }}" alt="menu"
         class="img-fluid rounded"
         style="max-width:420px; height: auto;">
@else
    <img src="{{ asset('default.jpg') }}" alt="menu"
         class="img-fluid rounded"
         style="max-width: 420px; height: auto;">
@endif


    <div class="wsus__cart_popup_text">
        <a href="#" class="title">{{ $product->name_translated }}</a>

        <p class="rating">
            @php
                $average = $product->total_review > 0 ? $product->average_rating : 0;
                $int_average = intval($average);
                $next_value = $int_average + 1;
                $review_point = $int_average;
                $half_review = ($int_average < $average && $average < $next_value);
            @endphp
            @for ($i = 1; $i <=5; $i++)
                @if ($i <= $review_point)
                    <i class="fas fa-star"></i>
                @elseif ($half_review)
                    <i class="fas fa-star-half-alt"></i>
                    @php $half_review = false; @endphp
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
            <span>({{ $product->total_review }})</span>
        </p>

        <h3 class="price">
            @if ($product->is_offer)
                {{ $currency_icon }}{{ $product->offer_price }} <del>{{ $currency_icon }}{{ $product->price }}</del>
            @else
                {{ $currency_icon }}{{ $product->price }}
            @endif
        </h3>

        {{-- ✅ Protein --}}
        @if (!empty($protein_items))
        <div class="details_extra_item mt-3">
            <h5>{{ __('user.select Protein') }}</h5>
            @foreach ($protein_items as $index => $item)
                <div class="form-check">
                    <input type="checkbox" name="protein_items[]"
                        class="form-check-input modal_check_addon"
                        value="{{ $item['item'] }}__{{ $item['price'] }}"
                        data-price="{{ $item['price'] }}">
                    <label class="form-check-label">
                        {{ $item['item'] }} (+{{ $currency_icon }}{{ $item['price'] }})
                    </label>
                </div>
            @endforeach
        </div>
        @endif

        {{-- ✅ Soup --}}
        @if (!empty($soup_items))
        <div class="details_extra_item mt-3">
            <h5>{{ __('user.select Soup') }}</h5>
            @foreach ($soup_items as $item)
                <div class="form-check">
                    <input type="checkbox" name="soup_items[]"
                        class="form-check-input modal_check_addon"
                        value="{{ $item['item'] }}__{{ $item['price'] }}"
                        data-price="{{ $item['price'] }}">
                    <label class="form-check-label">
                        {{ $item['item'] }} (+{{ $currency_icon }}{{ $item['price'] }})
                    </label>
                </div>
            @endforeach
        </div>
        @endif

        {{-- ✅ Wrap --}}
        @if (!empty($wrap_items))
        <div class="details_extra_item mt-3">
            <h5>{{ __('user.select Wrap / Swallow') }}</h5>
            @foreach ($wrap_items as $item)
                <div class="form-check">
                    <input type="checkbox" name="wrap_items[]"
                        class="form-check-input modal_check_addon"
                        value="{{ $item['item'] }}__{{ $item['price'] }}"
                        data-price="{{ $item['price'] }}">
                    <label class="form-check-label">
                        {{ $item['item'] }} (+{{ $currency_icon }}{{ $item['price'] }})
                    </label>
                </div>
            @endforeach
        </div>
        @endif

        {{-- ✅ Drink --}}
        @if (!empty($drink_items))
        <div class="details_extra_item mt-3">
            <h5>{{ __('user.select Drink') }}</h5>
            @foreach ($drink_items as $item)
                <div class="form-check">
                    <input type="checkbox" name="drink_items[]"
                        class="form-check-input modal_check_addon"
                        value="{{ $item['item'] }}__{{ $item['price'] }}"
                        data-price="{{ $item['price'] }}">
                    <label class="form-check-label">
                        {{ $item['item'] }} (+{{ $currency_icon }}{{ $item['price'] }})
                    </label>
                </div>
            @endforeach
        </div>
        @endif

        {{-- ✅ Food Instruction --}}
        <div class="details_instruction mt-3 mb-3">
            <h5>{{ __('user.Food Instruction') }} <span>({{ __('user.optional') }})</span></h5>
            <textarea name="food_instruction" class="form-control" rows="3" placeholder="{{ __('Add your menu preference or instruction') }}"></textarea>
        </div>

        {{-- ✅ Quantity --}}
        <div class="details_quentity">
            <h5>{{ __('user.select quantity') }}</h5>
            <div class="quentity_btn_area d-flex align-items-center">
                <div class="quentity_btn">
                    <button type="button" class="btn btn-danger modal_decrement_qty_detail_page"><i class="fal fa-minus"></i></button>
                    <input type="text" value="1" name="qty" class="modal_product_qty" readonly>
                    <button type="button" class="btn btn-success modal_increment_qty_detail_page"><i class="fal fa-plus"></i></button>
                </div>
                <h3 class="ms-3">{{ $currency_icon }} <span class="modal_grand_total">0.00</span></h3>
            </div>
        </div>

        {{-- ✅ Add to cart button --}}
        <ul class="details_button_area d-flex flex-wrap mt-3">
            <li><a id="modal_add_to_cart" class="common_btn" href="javascript:;">{{ __('user.add to cart') }}</a></li>
        </ul>
    </div>
</form>


{{-- ✅ JavaScript --}}
<script>
(function($) {
    "use strict";
    $(document).ready(function () {
        calculateModalPrice(); // ✅ on load

        $("#modal_add_to_cart").on("click", function(e){
    e.preventDefault();

    $.ajax({
        type: 'get',
        data: $('#modal_add_to_cart_form').serialize(),
        url: "{{ url('/add-to-cart') }}",
        success: function (response) {
            // ✅ Replace the full mini cart content
            $(".wsus__menu_cart_boody").html(response.html);

            // ✅ Fire toast and close modal
            toastr.success("{{ __('user.Item added successfully') }}");
            $("#cartModal").modal('hide');

            // ✅ Update totals and item count
            calculate_mini_total();
        },
        error: function(response) {
            toastr.error(response.status === 403 ? response.responseJSON.message : "{{ __('user.Server error occured') }}");
        }
    });
});

  

        $(".modal_check_protein_item, .modal_check_addon").on("change", calculateModalPrice);

        $(".modal_increment_qty_detail_page").on("click", function(){
            let qty = parseInt($(".modal_product_qty").val()) + 1;
            $(".modal_product_qty").val(qty);
            calculateModalPrice();
        });

        $(".modal_decrement_qty_detail_page").on("click", function(){
            let qty = parseInt($(".modal_product_qty").val());
            if (qty > 1) {
                $(".modal_product_qty").val(qty - 1);
                calculateModalPrice();
            }
        });
    });

    function calculateModalPrice(){
        let totalAddonPrice = 0;
        let qty = parseInt($(".modal_product_qty").val()) || 1;
        let base_price = parseFloat($("#modal_variant_price").val()) || 0;

        $(".modal_check_addon:checked, .modal_check_protein_item:checked").each(function () {
            totalAddonPrice += parseFloat($(this).data('price') || $(this).data('protein-item')) || 0;
        });

        let total = (base_price + totalAddonPrice) * qty;
        $(".modal_grand_total").html(total.toFixed(2));
        $("#modal_price").val(total.toFixed(2));
    }
})(jQuery);
</script>
