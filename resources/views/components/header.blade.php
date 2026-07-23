<!-- ==========================================
     HEADER / NAVBAR
     ========================================== -->
<header>
    <div class="container">
        <nav class="navbar">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}"
                    alt="Caring Hands Logo"
                    class="logo-image">
            </a>

            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('services') }}">Services</a></li>
                <li><a href="{{ route('features') }}">Features</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
            </ul>

            <div class="nav-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fa-regular fa-user"></i>
                        Dashboard
                    </a>
                @else
                    <button class="btn btn-outline" onclick="openLogin()">
                        <i class="fa-regular fa-user"></i>
                        Login
                    </button>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Get Started
                    </a>
                @endauth
            </div>

            <button class="menu-toggle" onclick="toggleMenu()">
                <i class="fa-solid fa-bars"></i>
            </button>
        </nav>
    </div>
</header>