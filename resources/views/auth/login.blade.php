@extends('layouts.app')

@section('title', 'Login | Caring Hands')

@section('content')

<section class="auth-section">

    <div class="auth-container">

        <!-- Left Side -->
        <div class="auth-info">

            <a href="{{ route('home') }}" class="auth-logo">
                <img src="{{ asset('images/logo.png') }}"
                     alt="Caring Hands Logo">
            </a>

            <div class="auth-info-content">

                <span class="auth-badge">
                    <i class="fa-solid fa-heart-pulse"></i>
                    Welcome Back
                </span>

                <h1>
                    Caring for people,
                    <span>made simpler.</span>
                </h1>

                <p>
                    Access Caring Hands to manage residents,
                    care activities, healthcare information
                    and communication securely.
                </p>

                <div class="auth-features">

                    <div class="auth-feature">
                        <i class="fa-solid fa-shield-heart"></i>

                        <div>
                            <strong>Secure Access</strong>
                            <span>Your information is protected.</span>
                        </div>
                    </div>

                    <div class="auth-feature">
                        <i class="fa-solid fa-heart"></i>

                        <div>
                            <strong>Better Care</strong>
                            <span>Everything you need in one place.</span>
                        </div>
                    </div>

                    <div class="auth-feature">
                        <i class="fa-solid fa-users"></i>

                        <div>
                            <strong>Stay Connected</strong>
                            <span>Connect residents, staff and families.</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <!-- Right Side -->
        <div class="auth-form-side">

            <div class="auth-form-box">

                <div class="auth-form-header">

                    <div class="auth-form-icon">
                        <i class="fa-regular fa-user"></i>
                    </div>

                    <h2>Welcome Back</h2>

                    <p>
                        Enter your details to access your account.
                    </p>

                </div>


                <!-- Session Status -->
                @if (session('status'))

                    <div class="auth-alert success">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('status') }}
                    </div>

                @endif


                <!-- General Error -->
                @if ($errors->has('login'))

                    <div class="auth-alert error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ $errors->first('login') }}
                    </div>

                @endif


                <form method="POST" action="{{ route('authenticate') }}">
                    @csrf


                    <!-- Email -->
                    <div class="auth-form-group">

                        <label for="email">
                            Email Address
                        </label>

                        <div class="auth-input-wrapper">

                            <i class="fa-regular fa-envelope"></i>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email"
                                autocomplete="email"
                                required
                                autofocus
                                class="@error('email') input-error @enderror"
                            >

                        </div>

                        @error('email')
                            <span class="auth-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- Password -->
                    <div class="auth-form-group">

                        <div class="auth-label-row">

                            <label for="password">
                                Password
                            </label>

                            @if (Route::has('password.request'))

                                <a href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>

                            @endif

                        </div>


                        <div class="auth-input-wrapper">

                            <i class="fa-solid fa-lock"></i>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword('password', this)"
                                aria-label="Show or hide password"
                            >
                                <i class="fa-regular fa-eye"></i>
                            </button>

                        </div>

                        @error('password')
                            <span class="auth-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- Remember -->
                    <div class="auth-options">

                        <label class="remember-me">

                            <input
                                type="checkbox"
                                name="remember"
                                {{ old('remember') ? 'checked' : '' }}
                            >

                            <span>Remember me</span>

                        </label>

                    </div>


                    <!-- Login -->
                    <button
                        type="submit"
                        class="auth-submit-btn">

                        Login

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>


                    <!-- Register -->
                    <div class="auth-bottom-text">

                        Don't have an account?

                        <a href="{{ route('register') }}">
                            Create Account
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection


@push('scripts')

<script>

    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);

        const icon = button.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');

        }

    }

</script>

@endpush