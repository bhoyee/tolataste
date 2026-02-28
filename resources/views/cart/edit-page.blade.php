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
                <h1>Edit Shopping Cart</h1>
                <ul>
                    <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                    <li><a href="{{ route('cart') }}">{{__('user.Shopping Cart')}}</a></li>
                    <li><a href="javascript:;">Edit Shopping Cart</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--=============================
    BREADCRUMB END
==============================-->

<section class="wsus__search_menu mt_120 xs_mt_90 mb_100 xs_mb_70">
    <div class="container">

        <h3>Edit Cart Item: {{ $cartItem->name }}</h3>

        @php
    $basePrice = $cartItem->price; // NOT cartItem->options->base_price
@endphp


        <!-- Base Price -->
        <div class="mb-3">
            <strong>Base Price:</strong>
            $<span id="base-price">{{ number_format($basePrice, 2) }}</span>
        </div>

        <!-- Grand Total -->
        <div class="mb-3">
            <strong>Grand Total:</strong>
            $<span id="grand-total">0.00</span> <!-- We will calculate using JavaScript -->
        </div>

        <form method="POST" action="{{ route('cart.update', $cartItem->rowId) }}" id="cartForm">
            @csrf

            <input type="hidden" id="hidden-base-price" value="{{ $basePrice }}">
            <input type="hidden" id="hidden-tax-rate" value="6"> <!-- if 6% tax -->
            <!-- ✅ Add these two hidden inputs BELOW the buttons -->
<input type="hidden" name="final_unit_price" id="final-unit-price" value="{{ $basePrice }}">
<input type="hidden" name="final_total" id="final-total" value="">




            <!-- All Variant Options -->

            @if (!empty($allOptionals))
    <div class="mb-3 mt-5">
        <label><strong>Optional Add-ons:</strong></label><br>
        @foreach($allOptionals as $optional)
            @php
                $isChecked = collect($cartItem->options->optional_items ?? [])->pluck('optional_name')->contains($optional['item']);
            @endphp
            <label class="d-block">
                <input type="checkbox" 
                    name="optionals[]" 
                    value="{{ $optional['item'] }}__{{ $optional['price'] }}"
                    data-price="{{ $optional['price'] }}"
                    class="variant-checkbox"
                    {{ $isChecked ? 'checked' : '' }}>
                {{ $optional['item'] }} (+${{ $optional['price'] }})
            </label>
        @endforeach
    </div>
@endif

            @if (!empty($allProteins))
                <div class="mb-3">
                    <label><strong>Protein Options:</strong></label><br>
                    @foreach($allProteins as $protein)
                        @php
                            $isChecked = collect($cartItem->options->protein_items ?? [])->pluck('protein_name')->contains($protein['item']);
                        @endphp
                        <label class="d-block">
                            <input type="checkbox" 
                                name="proteins[]" 
                                value="{{ $protein['item'] }}__{{ $protein['price'] }}"
                                data-price="{{ $protein['price'] }}"
                                class="variant-checkbox"
                                {{ $isChecked ? 'checked' : '' }}>
                            {{ $protein['item'] }} (+${{ $protein['price'] }})
                        </label>
                    @endforeach
                </div>
            @endif

            @if (!empty($allSoups))
                <div class="mb-3">
                    <label><strong>Soup Options:</strong></label><br>
                    @foreach($allSoups as $soup)
                        @php
                            $isChecked = collect($cartItem->options->soup_items ?? [])->pluck('soup_name')->contains($soup['item']);
                        @endphp
                        <label class="d-block">
                            <input type="checkbox" 
                                name="soups[]" 
                                value="{{ $soup['item'] }}__{{ $soup['price'] }}"
                                data-price="{{ $soup['price'] }}"
                                class="variant-checkbox"
                                {{ $isChecked ? 'checked' : '' }}>
                            {{ $soup['item'] }} (+${{ $soup['price'] }})
                        </label>
                    @endforeach
                </div>
            @endif

            @if (!empty($allWraps))
                <div class="mb-3">
                    <label><strong>Wrap Options:</strong></label><br>
                    @foreach($allWraps as $wrap)
                        @php
                            $isChecked = collect($cartItem->options->wrap_items ?? [])->pluck('wrap_name')->contains($wrap['item']);
                        @endphp
                        <label class="d-block">
                            <input type="checkbox" 
                                name="wraps[]" 
                                value="{{ $wrap['item'] }}__{{ $wrap['price'] }}"
                                data-price="{{ $wrap['price'] }}"
                                class="variant-checkbox"
                                {{ $isChecked ? 'checked' : '' }}>
                            {{ $wrap['item'] }} (+${{ $wrap['price'] }})
                        </label>
                    @endforeach
                </div>
            @endif

            @if (!empty($allDrinks))
                <div class="mb-3">
                    <label><strong>Drink Options:</strong></label><br>
                    @foreach($allDrinks as $drink)
                        @php
                            $isChecked = collect($cartItem->options->drink_items ?? [])->pluck('drink_name')->contains($drink['item']);
                        @endphp
                        <label class="d-block">
                            <input type="checkbox" 
                                name="drinks[]" 
                                value="{{ $drink['item'] }}__{{ $drink['price'] }}"
                                data-price="{{ $drink['price'] }}"
                                class="variant-checkbox"
                                {{ $isChecked ? 'checked' : '' }}>
                            {{ $drink['item'] }} (+${{ $drink['price'] }})
                        </label>
                    @endforeach
                </div>
            @endif


            <!-- Food Instruction -->
            <div class="mb-3">
                <label for="food_instruction">Food Instruction:</label>
                <textarea name="food_instruction" class="form-control">{{ $cartItem->options->food_instruction ?? '' }}</textarea>
            </div>

            <!-- Buttons -->
            <button type="submit" class="btn btn-primary" id="updateCartBtn">
                <span id="btn-text" style="color: white;">Update Cart</span>
                <span id="btn-spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>

        </form>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const initialBasePrice = parseFloat(document.getElementById('hidden-base-price').value);
    const taxRate = parseFloat(document.getElementById('hidden-tax-rate').value);
    const basePriceElement = document.getElementById('base-price');
    const totalPriceElement = document.getElementById('grand-total');
    const checkboxes = document.querySelectorAll('.variant-checkbox');

    // Calculate prices from only newly selected or deselected items
    function updateTotals() {
    let extraPrice = 0;

    checkboxes.forEach(cb => {
        const isInitiallyChecked = cb.defaultChecked;
        const isCurrentlyChecked = cb.checked;
        if (isCurrentlyChecked !== isInitiallyChecked) {
            extraPrice += isCurrentlyChecked ? parseFloat(cb.dataset.price || 0) : -parseFloat(cb.dataset.price || 0);
        }
    });

    const newSubtotal = initialBasePrice + extraPrice;
    const taxAmount = (newSubtotal * taxRate) / 100;
    const grandTotal = newSubtotal + taxAmount;

    basePriceElement.textContent = newSubtotal.toFixed(2);
    totalPriceElement.textContent = grandTotal.toFixed(2);

    // ✅ Update hidden fields for controller
    document.getElementById('final-unit-price').value = newSubtotal.toFixed(2);
    document.getElementById('final-total').value = grandTotal.toFixed(2);
}


    // Initial load - don't change the base price
    const initialTax = (initialBasePrice * taxRate) / 100;
    const initialGrandTotal = initialBasePrice + initialTax;
    totalPriceElement.textContent = initialGrandTotal.toFixed(2);

    // Listen for user interaction
    checkboxes.forEach(function (cb) {
        cb.addEventListener('change', updateTotals);
    });

    const form = document.getElementById('cartForm');
    const updateCartBtn = document.getElementById('updateCartBtn');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');

    form.addEventListener('submit', function () {
        updateCartBtn.disabled = true;
        btnText.classList.add('d-none');
        btnSpinner.classList.remove('d-none');
    });
});

</script>


@endsection
