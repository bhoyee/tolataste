@extends('admin.master_layout')

@section('title')
    <title>{{ __('admin.Delivery Settings') }}</title>
@endsection

@section('admin-content')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Delivery Fee Settings (Per Mile Based)</h1>
        </div>
        <div class="section-body">

            {{-- Flash success message --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('admin.delivery-setting.update') }}" id="delivery-setting-form">
                @csrf

                <div class="form-group">
                    <label>Per Mile Fee (0–5 miles)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" step="0.01" name="base_fee_per_mile" class="form-control"
                            value="{{ old('base_fee_per_mile', $deliverySetting->base_fee_per_mile) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Per Mile Fee (5–10 miles)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" step="0.01" name="mid_fee_per_mile" class="form-control"
                            value="{{ old('mid_fee_per_mile', $deliverySetting->mid_fee_per_mile) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label>Per Mile Fee (Above 10 miles)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" step="0.01" name="long_fee_per_mile" class="form-control"
                            value="{{ old('long_fee_per_mile', $deliverySetting->long_fee_per_mile) }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3" id="submit-btn">
                    <span class="spinner-border spinner-border-sm d-none" id="loading-spinner" role="status" aria-hidden="true"></span>
                    <span id="btn-text">Update Settings</span>
                </button>
            </form>
        </div>

        <section>
            <hr class="my-4">
            <h4>Current Delivery Rate Settings</h4>

            @if(isset($deliverySetting) && $deliverySetting->id)
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Distance Range</th>
                            <th>Rate (per mile)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0 – 5 miles</td>
                            <td>${{ number_format((float)$deliverySetting->base_fee_per_mile, 2) }}</td>
                        </tr>
                        <tr>
                            <td>5 – 10 miles</td>
                            <td>${{ number_format((float)$deliverySetting->mid_fee_per_mile, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Above 10 miles</td>
                            <td>${{ number_format((float)$deliverySetting->long_fee_per_mile, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <div class="alert alert-warning">
                    No delivery settings found. Please update and save the form to store values.
                </div>
            @endif
        </section>

    </section>
</div>

{{-- Spinner activation --}}
<script>
    document.getElementById('delivery-setting-form').addEventListener('submit', function() {
        document.getElementById('loading-spinner').classList.remove('d-none');
        document.getElementById('btn-text').textContent = 'Updating...';
    });
</script>
@endsection
