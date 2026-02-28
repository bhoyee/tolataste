@extends('admin.master_layout')

@section('title')
<title>{{ __('admin.Catering Request Details') }}</title>
@endsection

@section('admin-content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-utensils mr-2"></i>{{ __('admin.Catering Request Details') }}</h1>
        </div>

        <a href="{{ route('admin.catering.index') }}" class="btn btn-secondary mb-4">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Request Information</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6 mb-2"><strong>Name:</strong> {{ $catering->full_name }}</div>
                    <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $catering->email }}</div>
                    <div class="col-md-6 mb-2"><strong>Phone:</strong> {{ $catering->phone }}</div>
                    <div class="col-md-6 mb-2"><strong>Occasion:</strong> {{ $catering->occasion }}</div>
                    <div class="col-md-6 mb-2"><strong>Date of Event:</strong> {{ $catering->event_date }}</div>
                    <div class="col-md-6 mb-2"><strong>Event Start Time:</strong> {{ $catering->event_start_time }}</div>
                    <div class="col-md-6 mb-2"><strong>Dropoff Time:</strong> {{ $catering->dropoff_time }}</div>
                    <div class="col-md-6 mb-2"><strong>Catering Type:</strong> {{ $catering->catering_type }}</div>
                    <div class="col-md-6 mb-2"><strong>Guests:</strong> {{ $catering->guest_count }}</div>
                    <div class="col-md-12 mb-3"><strong>Delivery Address:</strong> {{ $catering->delivery_address }}</div>
                    <div class="col-md-12">
                        <strong>Menu Items:</strong>
                        <div class="border rounded p-3 bg-light mt-2">
                            {!! nl2br(e($catering->menu_items)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
