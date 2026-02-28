<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Cart Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h3>Edit Cart Item: {{ $cartItem->name }}</h3>

    <!-- Display Base Product Price -->
    <div class="mb-3">
        <strong>Base Price:</strong> $<span id="base-price">{{ number_format($cartItem->price, 2) }}</span>
    </div>

    <!-- Display Grand Total -->
    <div class="mb-3">
        <strong>Grand Total:</strong> $<span id="grand-total">{{ number_format($cartItem->price, 2) }}</span>
    </div>

    <form method="POST" action="{{ route('cart.update', $cartItem->rowId) }}">
        @csrf

        <!-- Protein Options -->
        <div class="mb-3">
            <label for="proteins">Select Proteins:</label><br>
            @foreach($allProteins as $protein)
                <label>
                    <input type="checkbox" name="proteins[]" value="{{ $protein['item'] }}"
                        data-price="{{ $protein['price'] }}"
                        @if(collect($cartItem->options->protein_items)->pluck('protein_name')->contains($protein['item'])) checked @endif>
                    {{ $protein['item'] }} (+${{ $protein['price'] }})
                </label><br>
            @endforeach
        </div>

        <!-- Food Instruction -->
        <div class="mb-3">
            <label for="food_instruction">Food Instruction:</label>
            <textarea name="food_instruction" class="form-control">{{ $cartItem->options->food_instruction ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Cart</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const basePrice = parseFloat(document.getElementById('base-price').textContent);
        const grandTotalElement = document.getElementById('grand-total');
        const checkboxes = document.querySelectorAll('input[name="proteins[]"]');

        function updateGrandTotal() {
            let total = basePrice;
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    total += parseFloat(checkbox.getAttribute('data-price'));
                }
            });
            grandTotalElement.textContent = total.toFixed(2);
        }

        // Initialize total on page load
        updateGrandTotal();

        // Add event listeners to checkboxes
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', updateGrandTotal);
        });
    });
</script>

</body>
</html>
