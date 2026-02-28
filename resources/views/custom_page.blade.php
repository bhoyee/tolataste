@extends('layout')

@section('title')
    <title>{{ $page->page_name_translated ?? 'Untitled Page' }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ $page->page_name_translated ?? '' }}">
@endsection

@section('public-content')

@if ($page)
    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{ $page->page_name_translated }}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{ __('user.Home') }}</a></li>
                        <li><a href="javascript:;">{{ $page->page_name_translated }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->

    <!--================================
        PRIVACY POLICY START
    =================================-->
    <section class="wsus__terms_condition mt_120 xs_mt_90 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__career_det_text">
                        {!! clean($page->description_translated ?? '') !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================================
        PRIVACY POLICY END
    =================================-->

@else
    <!-- If $page is null -->
    <section class="wsus__breadcrumb">
        <div class="container text-center py-5">
            <h2>Sorry, this page is not available.</h2>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">Return to Home</a>
        </div>
    </section>
@endif

@endsection
