<!-- ==========================================
     HEADER / NAVBAR
========================================== -->

<header class="site-header">

    <div class="container">

        <nav class="navbar">

            <!-- Logo -->
            <a href="{{ route('home') }}"
               class="logo">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Caring Hands Logo"
                    class="logo-image"
                >

            </a>


            <!-- Navigation -->
            <ul class="nav-menu"
                id="navMenu">

                <li>
                    <a href="{{ route('home') }}"
                       class="{{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route('about') }}"
                       class="{{ request()->routeIs('about') ? 'active' : '' }}">
                        About
                    </a>
                </li>

                <li>
                    <a href="{{ route('services') }}"
                       class="{{ request()->routeIs('services') ? 'active' : '' }}">
                        Services
                    </a>
                </li>

                <li>
                    <a href="{{ route('features') }}"
                       class="{{ request()->routeIs('features') ? 'active' : '' }}">
                        Features
                    </a>
                </li>

                <li>
                    <a href="{{ route('contact') }}"
                       class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                        Contact
                    </a>
                </li>

            </ul>


            <!-- Right Buttons -->
            <div class="nav-buttons">

                @auth

                    @php
                        $dashboardRoute = match (auth()->user()->role) {
                            'admin'      => 'admin.dashboard',
                            'manager'    => 'manager.dashboard',
                            'caregiver'  => 'caregiver.dashboard',
                            'healthcare' => 'healthcare.dashboard',
                            default      => 'home',
                        };
                    @endphp


                    <a href="{{ route($dashboardRoute) }}"
                       class="btn btn-primary">

                        <i class="fa-solid fa-gauge-high"></i>

                        Dashboard

                    </a>

                @else

                    <a href="{{ route('login') }}"
                       class="btn btn-outline">

                        <i class="fa-regular fa-user"></i>

                        Login

                    </a>


                    <a href="{{ route('register') }}"
                       class="btn btn-primary">

                        Get Started

                    </a>

                @endauth

            </div>


            <!-- Mobile Menu -->
            <button
                type="button"
                class="menu-toggle"
                onclick="toggleMenu()"
                aria-label="Toggle navigation"
                aria-controls="navMenu"
            >

                <i class="fa-solid fa-bars"></i>

            </button>

        </nav>

    </div>

</header>