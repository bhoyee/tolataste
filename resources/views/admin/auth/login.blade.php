@include('admin.header')

<style>
    body {
        background-color: #f5f7fa;
        margin: 0;
        padding: 0;
    }

    .auth-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
        position: relative;
        padding: 20px;
    }

    .auth-inner {
        display: flex;
        flex-direction: row;
        width: 100%;
        max-width: 1000px;
        height: 600px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        background-color: #fff;
        position: relative;
    }

    .auth-image {
        width: 50%;
        background: url('{{ asset('uploads/gallery/gallery_1746655287_1416.jpeg') }}') center center no-repeat;
        background-size: cover;
    }

    .auth-form-wrapper {
        width: 60%;
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        padding-right: 30px;
        z-index: 2;
    }

    .auth-card {
        background: #fff;
        border: 1px solid #dcdcf1;
        padding: 40px 30px;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        margin-left: auto;
    }

    .auth-card h4 {
        color: #3742fa;
        font-weight: 600;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .form-control {
        font-size: 14px;
        padding: 10px 12px;
        margin-bottom: 20px;
    }

    .btn-login {
        background-color: #3758f9;
        color: white;
        width: 100%;
        padding: 10px;
        font-weight: bold;
        border: none;
        border-radius: 5px;
    }

    .btn-login:hover {
        background-color: #274bdb;
    }

    .form-check-label {
        font-size: 13px;
    }

    .simple-footer {
        text-align: center;
        font-size: 13px;
        margin-top: 20px;
        color: #777;
    }

    .logo {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .logo img {
        max-height: 50px;
        object-fit: contain;
    }

    @media (max-width: 768px) {
        .auth-inner {
            flex-direction: column;
            height: auto;
        }

        .auth-image {
            display: none;
        }

        .auth-form-wrapper {
            position: static;
            transform: none;
            width: 100%;
            padding: 20px;
        }

        .auth-card {
            margin: 0 auto;
        }
    }
</style>

<div class="auth-wrapper">
    <div class="auth-inner">
        <div class="auth-image"></div>

        <div class="auth-form-wrapper">
            <div class="auth-card">
                <div class="logo">
                    <img src="{{ asset($setting->logo) }}" alt="Logo">
                </div>

                <h4>{{ __('admin.Login to Admin Panel') }}</h4>

                <form action="{{ route('admin.login') }}" method="POST" novalidate>
                    @csrf

                    <div class="form-group">
                        <label for="email">{{ __('admin.Email') }}</label>
                        <input type="email" id="email" class="form-control" name="email"
                            value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">{{ __('admin.Password') }}</label>
                        <input type="password" id="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ __('admin.Remember Me') }}</label>
                    </div>

                    <button type="submit" class="btn-login">{{ __('admin.Login') }}</button>
                </form>

                <div class="simple-footer mt-4">
                    {{ $setting->copyright }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.footer')
