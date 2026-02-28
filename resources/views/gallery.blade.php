@extends('layout')

@section('title')
    <title>{{ __('user.GALLERY') }}</title>
@endsection

@section('meta')
    <meta name="description" content="Gallery of our restaurant">
@endsection

@section('public-content')

<!--=============================
    BREADCRUMB START
==============================-->
<section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb ?? 'default-image.jpg') }});">
    <div class="wsus__breadcrumb_overlay">
        <div class="container">
            <div class="wsus__breadcrumb_text">
                <h1>{{ __('user.GALLERY') }}</h1>
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('user.Home') }}</a></li>
                    <li><a href="{{ route('gallery') }}">{{ __('user.GALLERY') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--=============================
    BREADCRUMB END
==============================-->

<!--=============================
    GALLERY PAGE START
==============================-->
<section class="wsus__gallery pt_100 xs_pt_70 pb_100 xs_pb_70">
    <div class="container">
        <!-- Introductory sentence -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <p class="text-muted" style="font-size: 1.1rem;"><b>
                    Explore our gallery to get a taste of the vibrant dishes and cozy atmosphere that make every visit unforgettable.</b>
                </p>
            </div>
        </div>

        <div class="row">
            @forelse ($galleryImages as $image)
                <div class="col-md-4 mb-4">
                    <img src="{{ asset('uploads/gallery/' . $image->image_path) }}" class="img-fluid rounded shadow" alt="Gallery Image">
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>{{ __('No images available') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!--=============================
    GALLERY PAGE END
==============================-->

@endsection
