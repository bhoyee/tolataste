@extends('layout')

@section('title')
    <title>{{ $seo_setting->seo_title }}</title>
@endsection

@section('meta')
    <meta name="description" content="{{ $seo_setting->seo_description }}">
@endsection

@section('public-content')

<!--=============================
    BREADCRUMB START
==============================-->
<section class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb) }});">
    <div class="wsus__breadcrumb_overlay">
        <div class="container">
            <div class="wsus__breadcrumb_text">
                <h1>{{ __('user.Contact us') }}</h1>
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('user.Home') }}</a></li>
                    <li><a href="{{ route('contact-us') }}">{{ __('user.Contact us') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--=============================
    BREADCRUMB END
==============================-->

<!--=============================
    CONTACT PAGE START
==============================-->
<section class="wsus__contact mt_100 xs_mt_70 mb_100 xs_mb_70">
    <div class="container">
        <div class="row">
            <!-- Contact Info Boxes -->
            <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__contact_info" style="background: url({{ asset($contact->image) }});">
                    <span><i class="fal fa-phone-alt"></i></span>
                    <h3>{{ __('user.call') }}</h3>
                    <p>{!! nl2br($contact->phone) !!}</p>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__contact_info" style="background: url({{ asset($contact->image) }});">
                    <span><i class="fal fa-envelope"></i></span>
                    <h3>{{ __('user.Email') }}</h3>
                    <p>{!! nl2br($contact->email) !!}</p>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 col-lg-4 wow fadeInUp" data-wow-duration="1s">
                <div class="wsus__contact_info" style="background: url({{ asset($contact->image) }});">
                    <span><i class="fas fa-street-view"></i></span>
                    <h3>{{ __('user.Location') }}</h3>
                    <p>{!! nl2br($contact->address) !!}</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="wsus__contact_form_area mt_100 xs_mt_70">
            <div class="row">
        <div id="contactAlert" class="alert alert-warning" style="{{ $contact_setting->enable_save_contact_message == 0 ? '' : 'display: none;' }}">
    {{ __('The contact form is currently disabled by the administrator.') }}
</div>


                <div class="col-xl-7 wow fadeInUp" data-wow-duration="1s">
                   <form class="wsus__contact_form" method="POST" action="{{ route('send-contact-us') }}">
    <h3>{{ __('user.Feel free to contact us') }}</h3>
    <input type="text" name="websitess" style="display:none;"> <!-- Honeypot -->

    @csrf
    <div class="row">
        <div class="col-xl-12 col-lg-6">
            <div class="wsus__contact_form_input">
                <span><i class="fal fa-user-alt"></i></span>
                <input type="text" id="name" name="name" placeholder="{{ __('user.Name') }}"
                    {{ $contact_setting->enable_save_contact_message == 0 ? 'disabled' : '' }} required>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="wsus__contact_form_input">
                <span><i class="fal fa-envelope"></i></span>
                <input type="email" id="email" name="email" placeholder="{{ __('user.Email') }}"
                    {{ $contact_setting->enable_save_contact_message == 0 ? 'disabled' : '' }} required>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="wsus__contact_form_input">
                <span><i class="fal fa-phone-alt"></i></span>
                <input type="number" id="phone" name="phone" placeholder="{{ __('user.Phone') }}"
                    {{ $contact_setting->enable_save_contact_message == 0 ? 'disabled' : '' }} required>
            </div>
        </div>

        <div class="col-xl-12 col-lg-6">
            <div class="wsus__contact_form_input">
                <span><i class="fal fa-book"></i></span>
                <input type="text" id="subject" name="subject" placeholder="{{ __('user.Subject') }}"
                    {{ $contact_setting->enable_save_contact_message == 0 ? 'disabled' : '' }} required>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="wsus__contact_form_input textarea">
                <span><i class="fal fa-book"></i></span>
                <textarea rows="5" id="message" name="message" placeholder="{{ __('user.Message') }}"
                    {{ $contact_setting->enable_save_contact_message == 0 ? 'disabled' : '' }} required></textarea>
            </div>
        </div>

        <div class="col-xl-12 mt-3">
            <button type="submit" id="contactSubmitBtn"
                class="btn {{ $contact_setting->enable_save_contact_message == 1 ? 'btn-primary' : 'btn-secondary' }}"
                {{ $contact_setting->enable_save_contact_message == 0 ? 'disabled' : '' }}>
                <span class="btn-text text-light">
                    {{ $contact_setting->enable_save_contact_message == 1
                        ? __('user.send now')
                        : __('No message is allowed now, check back later') }}
                </span>
                <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</form>

                </div>
                <div class="col-xl-5 wow fadeInUp" data-wow-duration="1s">
                    <div class="wsus__contact_map">
                        {!! $contact->map !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--=============================
    CONTACT PAGE END
==============================-->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('.wsus__contact_form');
        const submitBtn = document.getElementById('contactSubmitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                const spinner = submitBtn.querySelector('.spinner-border');
                const text = submitBtn.querySelector('.btn-text');

                // Show spinner, hide text, disable button
                spinner.classList.remove('d-none');
                text.classList.add('d-none');
                submitBtn.disabled = true;
            });
        }
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fields = ['name', 'email', 'phone', 'subject', 'message'].map(id => document.getElementById(id));
    const submitBtn = document.getElementById('contactSubmitBtn');
    const btnText = submitBtn?.querySelector('.btn-text');
    const disabledNotice = "{{ __('No message is allowed now, check back later') }}";
    const enabledText = "{{ __('user.send now') }}";

     function toggleForm(enabled) {
        fields.forEach(field => field.disabled = !enabled);
        submitBtn.disabled = !enabled;
        btnText.textContent = enabled ? enabledText : disabledNotice;
        submitBtn.classList.toggle('btn-primary', enabled);
        submitBtn.classList.toggle('btn-secondary', !enabled);
    
        // NEW: toggle the warning alert
        const alertBox = document.getElementById('contactAlert');
        if (alertBox) {
            alertBox.style.display = enabled ? 'none' : 'block';
        }
    }


    async function checkToggle() {
        try {
            const res = await fetch("{{ url('/api/contact-message-toggle') }}");
            const data = await res.json();
            toggleForm(data.enabled == 1);
        } catch (err) {
            console.error('Toggle check failed:', err);
        }
    }

    checkToggle(); // Initial
    setInterval(checkToggle, 10000); // Every 10s
});
</script>

@endsection





