@extends('layout')
@section('title')
    <title>{{__('user.Testimonial')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Testimonial')}}">
@endsection

@section('public-content')
    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Testimonial')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="{{ route('testimonial') }}">{{__('user.Testimonial')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->

        <!--=============================
        TESTIMONIAL PAGE START
    ==============================-->
    <section class="wsus__testimonial_page mt_95 xs_mt_65 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">

                @foreach ($testimonials as $index => $single_testimonial)
                    <div class="col-xl-4 col-md-6 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_testimonial">
                            <div class="wsus__testimonial_header d-flex flex-wrap align-items-center">
                                <div class="img">
                                    <img src="{{ asset($single_testimonial->image) }}" alt="clients" class="img-fluid w-100">
                                </div>
                                <div class="text">
                                    <h4>{{ $single_testimonial->name_translated }}</h4>
                                    <p>{{ $single_testimonial->designation_translated }}</p>
                                </div>
                            </div>
                            <div class="wsus__single_testimonial_body">
                                <p class="feedback">{{ $single_testimonial->comment_translated }}</p>
                                <span class="rating">
                                    @for ($i = 1; $i <=5 ; $i++)
                                        @if ($i <= $single_testimonial->rating )
                                        <i class="fas fa-star"></i>
                                        @else
                                        <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </span>
                            </div>
                            <div class="wsus__testimonial_product">
                                <img src="{{ asset($single_testimonial->product_image) }}" alt="product" class="img-fluid w-100">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--=============================
        TESTIMONIAL PAGE END
    ==============================-->
@endsection
