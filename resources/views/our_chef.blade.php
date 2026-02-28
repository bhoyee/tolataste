@extends('layout')
@section('title')
    <title>{{__('user.Our Chef')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Our Chef')}}">
@endsection

@section('public-content')
    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Our Chef')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="{{ route('our-chef') }}">{{__('user.Our Chef')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->

   <!--=============================
        TEAM PAGE START
    ==============================-->
    <section class="wsus__team_page pt_95 xs_pt_65 pb_100 xs_pb_70">
        <div class="container">
            <div class="row">

                @foreach ($our_chefs as $index => $single_chef )
                    <div class="col-xl-3 col-sm-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="wsus__single_team">
                            <div class="wsus__single_team_img">
                                <img src="{{ asset($single_chef->image) }}" alt="team" class="img-fluid w-100">
                            </div>
                            <div class="wsus__single_team_text">
                                <h4>{{ $single_chef->name_translated }}</h4>
                                <p>{{ $single_chef->designation_translated }}</p>
                                <ul class="d-flex flex-wrap justify-content-center">
                                    @if ($single_chef->facebook)
                                        <li><a href="{{ $single_chef->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif

                                    @if ($single_chef->linkedin)
                                        <li><a href="{{ $single_chef->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif

                                    @if ($single_chef->twitter)
                                        <li><a href="{{ $single_chef->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                    @endif

                                    @if ($single_chef->instagram)
                                        <li><a href="{{ $single_chef->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--=============================
        TEAM PAGE END
    ==============================-->
@endsection
