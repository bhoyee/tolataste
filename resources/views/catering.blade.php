@extends('layout')

@section('title')
    <title>{{ __('user.Catering Services') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Order custom catering for your events: drop-off, setup, buffet, or corporate meals.">
@endsection

@section('public-content')

<!-- ✅ Scoped Styling to force bullet list display -->
<style>
    /* Global Bullet Styling */
    section.catering-page ul {
        list-style-type: disc !important; /* Ensures bullets are visible */
        list-style-position: inside !important; /* Keeps bullets aligned */
        padding-left: 1.5rem !important; /* Adds spacing for bullets */
        margin: 0; /* Removes unwanted margins */
    }

    section.catering-page li {
        display: list-item !important; /* Forces <li> to behave as a list item */
        margin-bottom: 6px; /* Adds spacing between list items */
    }
</style>

<!-- Breadcrumb Section -->
<section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb ?? 'default-image.jpg') }});">
    <div class="wsus__breadcrumb_overlay">
        <div class="container">
            <div class="wsus__breadcrumb_text">
                <h1>{{ __('user.Catering Services') }}</h1>
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('user.Home') }}</a></li>
                    <li><a href="{{ route('gallery') }}">{{ __('user.Catering Services') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Main Content Section -->
<section class="catering-page py-5">
    <div class="container">

        <!-- Introduction -->
        <div class="mb-5">
            <p class="lead">
                <strong>Planning a party or event?</strong> We’ve got your food covered. From quick drop-offs to full buffet service, our catering team is ready to deliver delicious meals tailored to your needs. Browse our options and complete the form below to start your request.
            </p>
        </div>

                @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Service Options -->
        <div class="mb-5">
            <h3>Service Options</h3>
            <ul>
                <li>Drop Off Only</li>
                <li>Drop Off + Set Up</li>
                <li>Full Service Buffet</li>
                <li>Corporate Event (Prepackaged Meals)</li>
                <li>Corporate Event (Buffet Style)</li>
            </ul>
        </div>

        <!-- Menu Categories -->
        <div class="row">
            <div class="col-md-6 mb-5">
                <h4>Proteins</h4>
                <ul>
                    <li>Peppered Beef</li>
                    <li>Beef Dodo</li>
                    <li>Peppered Goat</li>
                    <li>Peppered Fish</li>
                    <li>Peppered Chicken/Hen</li>
                    <li>Fried Drumsticks in sauce</li>
                    <li>Peppered Shrimps</li>
                    <li>Curried Shrimps</li>
                    <li>Salmon</li>
                    <li>Chicken Breast</li>
                    <li>Whole Fish</li>
                    <li>Peppered Snails</li>
                    <li>Peppered Ponmo</li>
                    <li>Fried Chicken Wings</li>
                    <li>Bacon Wrapped Shrimps</li>
                    <li>Bacon wrapped chicken breast</li>
                    <li>BBQ Chicken</li>
                    <li>Beef Suya</li>
                    <li>Suya Wings</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h4>Sides, Pastries & Dessert</h4>
                <ul>
                    <li>Broccoli or Kale Stir-fry</li>
                    <li>Fruit Tray</li>
                    <li>Fried Plantains</li>
                    <li>Moi Moi</li>
                    <li>Akara</li>
                    <li>Puff Puff</li>
                    <li>Cupcake Puff Puff</li>
                    <li>Fish Pie</li>
                    <li>Beef Pie</li>
                    <li>Spring Roll</li>
                    <li>Shrimp Roll</li>
                    <li>Egg Roll</li>
                    <li>Sausage Roll</li>
                    <li>Scotch Eggs</li>
                    <li>Fish Roll</li>
                    <li>ChinChin / Coconut ChinChin</li>
                    <li>Amala / Iyan / Eba</li>
                    <li>Brownie a la mode</li>
                    <li>Cookies & Ice Cream</li>
                </ul>
            </div>

            <div class="col-md-6 mb-5">
                <h4>Starches & More</h4>
                <ul>
                    <li>Jollof Rice</li>
                    <li>Native Jollof</li>
                    <li>Nigerian Fried Rice</li>
                    <li>Jollof Spaghetti</li>
                    <li>Native Spaghetti</li>
                    <li>Bean Porridge</li>
                    <li>Beans & Stew (Ewa Agoyin)</li>
                    <li>Asaro (Yam Porridge)</li>
                    <li>Mac & Cheese</li>
                    <li>Chicken/Shrimp Alfredo</li>
                </ul>
            </div>


            <div class="col-md-6 mb-5">
                <h4>Soups & Stews</h4>
                <ul>
                    <li>Assorted Meat Peppersoup</li>
                    <li>Goat Peppersoup</li>
                    <li>Tilapia Peppersoup</li>
                    <li>Panla Sauce</li>
                    <li>Multipurpose Sauce</li>
                    <li>Ofada / Ayamase Stew</li>
                    <li>Egusi / Vegetable / Assorted / Goat / Chicken / Beef Stew</li>
                    <li>Okra / Ogbono Soup</li>
                    <li>Abula</li>
                </ul>
            </div>

            <div class="col-md-6 mb-5">
                <h4>Drinks</h4>
                <ul>
                    <li>Zobo</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h4>Breakfast / Brunch</h4>
                <ul>
                    <li>Ogi / Akara / Moi Moi</li>
                    <li>Donut / Omelette / Fruit Platter</li>
                    <li>Fried Yams & Sauce</li>
                    <li>Plantains & Eggs / Boiled Plantains & Fish Sauce</li>
                    <li>Bacon, Egg, & Cheese (Croissant/Toast/Bagel)</li>
                    <li>Chicken & Waffles / Pancakes / Scrambled Eggs</li>
                </ul>
            </div>
        </div>

        <hr class="my-5">

        <!-- Catering Request Form -->
        <h3 class="mb-4">Catering Request Form</h3>


<form id="cateringForm" action="{{ route('catering.submit') }}" method="POST">
    <input type="text" name="website" style="display:none;"> <!-- Honeypot -->


            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Telephone *</label>
                    <input type="tel" name="phone" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Delivery Address *</label>
                    <input type="text" name="delivery_address" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Occasion</label>
                    <input type="text" name="occasion" class="form-control" placeholder="Birthday, Wedding, Anniversary, etc.">
                </div>
                <div class="col-md-6">
                    <label>Date of Event *</label>
                    <input type="date" name="event_date" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Type of Catering Service *</label>
                    <select name="catering_type" class="form-control" required>
                        <option value="">-- Select --</option>
                        <option>Drop Off Only</option>
                        <option>Drop Off + Set Up</option>
                        <option>Full Service Buffet</option>
                        <option>Corporate Event (Prepackaged Meals)</option>
                        <option>Corporate Event (Buffet Style)</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>When does the event start?</label>
                    <input type="time" name="event_start_time" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Drop-Off Arrival Time (if applicable)</label>
                    <input type="time" name="dropoff_time" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Number of Guests *</label>
                    <input type="number" name="guest_count" class="form-control" required>
                </div>
                <div class="col-12">
                    <label>List Menu Items Desired *</label>
                    <textarea name="menu_items" rows="5" class="form-control" placeholder="E.g., Jollof rice, plantain, chicken, zobo..." required></textarea>
                </div>
                <div class="col-12">
                <button id="submitCateringBtn" class="btn btn-primary mt-3" type="submit">
                        <span class="spinner-border spinner-border-sm d-none" role="status" id="spinner" aria-hidden="true"></span>
                        <span id="submitText" style="color: #fff;">Submit Catering Request</span>
                    </button>

                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('cateringForm');
        const submitBtn = document.getElementById('submitCateringBtn');
        const spinner = document.getElementById('spinner');
        const submitText = document.getElementById('submitText');

        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            spinner.classList.remove('d-none');
            submitText.textContent = 'Processing...';
        });
    });
</script>
@endpush