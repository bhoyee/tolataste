@extends('layout')
@section('title')
    <title>{{__('user.FAQ')}}</title>
@endsection
@section('meta')
    <meta name="description" content="cart">
@endsection

@section('public-content')


   <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
        <div class="wsus__breadcrumb_overlay">
            <div class="container">
                <div class="wsus__breadcrumb_text">
                    <h1>{{__('user.FAQ')}}</h1>
                    <ul>
                        <li><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                        <li><a href="{{ route('faq') }}">{{__('user.FAQ')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


        <!--=============================
        FAQ PAGE START
    ==============================-->
    <section class="wsus__faq pt_100 xs_pt_70 pb_100 xs_pb_70">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__faq_area">
                        <div class="accordion" id="accordionExample">
                            @foreach ($faqs as $index => $faq)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne-{{ $faq->id }}">
                                    <button class="accordion-button {{ $index != 1 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne-{{ $faq->id }}" aria-expanded="true" aria-controls="collapseOne-{{ $faq->id }}">
                                        {{ ++ $index }}. {{ $faq->question_translated }}
                                    </button>
                                </h2>
                                <div id="collapseOne-{{ $faq->id }}" class="accordion-collapse collapse {{ $index == 1 ? 'show' : '' }}"
                                    aria-labelledby="headingOne-{{ $faq->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! clean($faq->answer_translated) !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="wsus__faq_form">
                        <form method="POST" action="{{ route('send-contact-us') }}">
                            @csrf
                            <h3>{{__('user.Feel free to contact us')}}</h3>
                            <input type="text" name="name" placeholder="{{__('user.Name')}}">
                            <input type="email" name="email"  placeholder="{{__('user.Email')}}">
                            <input type="text" name="phone"  placeholder="{{__('user.Phone')}}">
                            <input type="text" placeholder="{{__('user.Subject')}}" name="subject">
                            <textarea rows="5" placeholder="{{__('user.Message')}}" name="message"></textarea>

                            @if($recaptcha_setting->status==1)
                            <div class="mt-2">
                                <div class="g-recaptcha" data-sitekey="{{ $recaptcha_setting->site_key }}"></div>
                            </div>
                                @endif
                            <button type="submit" class="common_btn">{{__('user.Send Message')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        FAQ PAGE END
    ==============================-->


@endsection
