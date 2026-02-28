@php
    $setting = App\Models\Setting::first();
    $colorPrimary = $setting->colorPrimary;
    $gradiantBg1 = $setting->gradiantBg1;
    $gradiantBg2 = $setting->gradiantBg2;
    $gradiantBg3 = $setting->gradiantBg3;

    $gradiantHoverBg1 = $setting->gradiantHoverBg1;
    $gradiantHoverBg2 = $setting->gradiantHoverBg2;
    $gradiantHoverBg3 = $setting->gradiantHoverBg3;

    $footer_color = $setting->footer_color;
    $topbar_social_icon_color = $setting->topbar_social_icon_color;

@endphp

<style>
    :root {
    --colorPrimary: {{ $colorPrimary }};
    --paraColor: #494949;
    --colorBlack: #010f1c;
    --colorWhite: #ffffff;
    --paraFont: 'Barlow', sans-serif;
    --headingFont: 'Jost', sans-serif;
    --cursiveFont: 'Lobster', cursive;
    --boxShadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    --gradiantBg: {{ $gradiantBg1 }}linear-gradient(0deg, {{ $gradiantBg2 }} 0%, {{ $gradiantBg3 }} 100%);
    --gradiantHoverBg: {{ $gradiantHoverBg1 }}linear-gradient(0deg, {{ $gradiantHoverBg2 }} 0%, {{ $gradiantHoverBg3 }} 100%);
}


.footer_overlay{
    background: {{ $footer_color }} !important;
}


.topbar_icon li a {
    background: {{ $topbar_social_icon_color }} !important;
}

</style>
