@extends('layouts.app')

@section('title', 'Register | Caring Hands')

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
                    <i class="fa-solid fa-hands-holding-heart"></i>
                    Join Caring Hands
                </span>

                <h1>
                    Together for
                    <span>better elder care.</span>
                </h1>

                <p>
                    Create your Caring Hands account and stay
                    connected with the people and care services
                    that matter.
                </p>


                <div class="auth-features">

                    <div class="auth-feature">

                        <i class="fa-solid fa-user-shield"></i>

                        <div>
                            <strong>Secure Account</strong>
                            <span>Your personal information stays protected.</span>
                        </div>

                    </div>


                    <div class="auth-feature">

                        <i class="fa-solid fa-notes-medical"></i>

                        <div>
                            <strong>Care Information</strong>
                            <span>Access relevant care information easily.</span>
                        </div>

                    </div>


                    <div class="auth-feature">

                        <i class="fa-solid fa-comments"></i>

                        <div>
                            <strong>Connected Care</strong>
                            <span>Better communication through one platform.</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Right -->
        <div class="auth-form-side">

            <div class="auth-form-box">

                <div class="auth-form-header">

                    <div class="auth-form-icon">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>

                    <h2>Create Account</h2>

                    <p>
                        Enter your information to get started.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('register') }}"
                >

                    @csrf


                    <!-- Name -->
                    <div class="auth-form-group">

                        <label for="name">
                            Full Name
                        </label>

                        <div class="auth-input-wrapper">

                            <i class="fa-regular fa-user"></i>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Enter your full name"
                                autocomplete="name"
                                required
                                autofocus
                                class="@error('name') input-error @enderror"
                            >

                        </div>

                        @error('name')
                            <span class="auth-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


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

                        <label for="password">
                            Password
                        </label>

                        <div class="auth-input-wrapper">

                            <i class="fa-solid fa-lock"></i>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Create a password"
                                autocomplete="new-password"
                                required
                                class="@error('password') input-error @enderror"
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


                    <!-- Confirm Password -->
                    <div class="auth-form-group">

                        <label for="password_confirmation">
                            Confirm Password
                        </label>

                        <div class="auth-input-wrapper">

                            <i class="fa-solid fa-lock"></i>

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                autocomplete="new-password"
                                required
                            >

                            <button
                                type="button"
                                class="password-toggle"
                                onclick="togglePassword('password_confirmation', this)"
                                aria-label="Show or hide password"
                            >

                                <i class="fa-regular fa-eye"></i>

                            </button>

                        </div>

                    </div>


                    <!-- Terms -->
                    <div class="auth-options">

                        <label class="remember-me">

                            <input
                                type="checkbox"
                                name="terms"
                                value="1"
                                required
                            >

                            <span>
                                I agree to the Terms & Conditions
                                and Privacy Policy.
                            </span>

                        </label>

                    </div>


                    <!-- Register -->
                    <button
                        type="submit"
                        class="auth-submit-btn">

                        Create Account

                        <i class="fa-solid fa-arrow-right"></i>

                    </button>


                    <div class="auth-bottom-text">

                        Already have an account?

                        <a href="{{ route('login') }}">
                            Login
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

        const input =
            document.getElementById(inputId);

        const icon =
            button.querySelector('i');


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