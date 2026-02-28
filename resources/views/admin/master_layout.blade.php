@php
    use App\Models\Setting;
    use App\Models\BannerImage;
    use Illuminate\Support\Facades\Auth;

    $setting = Setting::first();
    $header_admin = Auth::guard('admin')->user();

    // Get default profile image or fallback if not found
    $defaultProfile = BannerImage::find(15);
    $defaultImage = optional($defaultProfile)->image ?? 'uploads/default-profile.jpg';

    // Final image to display: admin image or fallback
    $profileImage = $header_admin->image ?? $defaultImage;
@endphp

@include('admin.header')

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li>
              <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg custom_click">
                <i class="fas fa-bars"></i>
              </a>
            </li>
            <li>
              <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                <i class="fas fa-search"></i>
              </a>
            </li>
          </ul>
        </div>

        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle">
            <a target="_blank" href="{{ route('home') }}" class="nav-link nav-link-lg">
              <i class="fas fa-home"></i> {{ __('admin.Visit Website') }}
            </a>
          </li>

          <li class="dropdown dropdown-list-toggle">
            <form id="setLanguage" action="{{ route('set-language') }}">
              <select class="form-control select2" name="code">
                <option value="">{{ __('admin.Select Language') }}</option>
                @forelse($languages as $language)
                  <option value="{{ $language->code }}"
                    {{ session()->get('lang') == $language->code ? 'selected' : '' }}>
                    {{ $language->name }}
                  </option>
                @empty
                  <option value="en">English</option>
                @endforelse
              </select>
            </form>
          </li>

          <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <img alt="image" src="{{ asset($profileImage) }}" class="rounded-circle mr-1">
              <!--<div class="d-sm-none d-lg-inline-block">{{ $header_admin->name }}</div>-->
              <div class="d-sm-none d-lg-inline-block">{{ optional($header_admin)->name ?? 'Admin' }}</div>

            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> {{ __('admin.Profile') }}
              </a>
              <div class="dropdown-divider"></div>
              <a href="{{ route('admin.logout') }}" class="dropdown-item has-icon text-danger"
                 onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('admin.Logout') }}
              </a>
              <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </nav>

      @include('admin.sidebar')

      @yield('admin-content')

      <footer class="main-footer">
        <div class="footer-left">
          {{ $footer->copyright }}
        </div>
        <div class="footer-right">
          App Version : {{ $setting->app_version }}
        </div>
      </footer>
    </div>
  </div>

@include('admin.footer')
