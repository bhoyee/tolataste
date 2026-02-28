@extends('layout')
@section('title')
    <title>{{__('user.Reset Password')}}</title>
@endsection
@section('meta')
    <meta name="description" content="{{__('user.Reset Password')}}">
@endsection

@section('public-content')



    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.Reset Password')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="javascript:;">{{__('user.Reset Password')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->

     <!--=========================
        SIGNIN START
    ==========================-->
    <section class="wsus__signin" style="background: url({{ asset($setting->login_page_image) }});">
        <div class="wsus__signin_overlay pt_125 xs_pt_95 pb_100 xs_pb_70">
            <div class="container">
                <div class="row wow fadeInUp" data-wow-duration="1s">
                    <div class="col-xxl-5 col-xl-6 col-md-9 col-lg-7 m-auto">
                        <div class="wsus__login_area">
                            <h2>{{__('user.Reset Password')}}</h2>
                            <p>{{__('user.Please fill up the form below and reset your password')}}</p>
                            <form method="POST" action="{{ route('store-reset-password', $token) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>{{__('user.Email')}}</label>
                                            <input type="email" name="email" value="{{ $user->email }}" readonly>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>{{__('user.Password')}}</label>
                                            <input type="password" name="password" placeholder="{{__('user.Password')}}">
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <label>{{__('user.Confirm Password')}}</label>
                                            <input type="password" name="password_confirmation" placeholder="{{__('user.Confirm Password')}}">
                                        </div>
                                    </div>

                                    @if($recaptcha_setting->status==1)
                                        <div class="col-xl-12 mb-3">
                                            <div class="g-recaptcha" data-sitekey="{{ $recaptcha_setting->site_key }}"></div>
                                        </div>
                                    @endif

                                    <div class="col-xl-12">
                                        <div class="wsus__login_imput">
                                            <button type="submit" class="common_btn">{{__('user.Reset Password')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <p class="create_account">{{__('user.Back to login page')}} <a href="{{ route('login') }}">{{__('user.Login page')}}</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        SIGNIN END
    ==========================-->
@endsection
