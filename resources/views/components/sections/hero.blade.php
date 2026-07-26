<!-- ==========================================
     HERO SECTION
========================================== -->

<section class="hero" id="home">

    <div class="container">

        <div class="hero-wrapper">

            <!-- ==================================
                 LEFT CONTENT
            =================================== -->

            <div class="hero-content">

                <div class="hero-badge">
                    <i class="fa-solid fa-heart-pulse"></i>
                    We Care Your Hearts
                </div>


                <h1>
                    Compassionate Care,
                    <span>Connected by Technology</span>
                </h1>


                <p>
                    Caring Hands brings elderly residents,
                    caregivers, healthcare professionals and
                    families together through one secure and
                    easy-to-use elder home management platform.
                </p>


                <div class="hero-buttons">

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

                            Dashboard

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>

                    @else

                        <a href="{{ route('register') }}"
                           class="btn btn-primary">

                            Get Started

                            <i class="fa-solid fa-arrow-right"></i>

                        </a>

                    @endauth


                    <a href="{{ route('about') }}"
                       class="btn btn-outline">

                        Learn More

                    </a>

                </div>

            </div>


            <!-- ==================================
                 RIGHT BANNER IMAGE
            =================================== -->

            <div class="hero-visual">

                <div class="hero-image-wrapper">

                    <img
                        src="{{ asset('images/elder-banner.png') }}"
                        alt="Caring Hands elder care"
                        class="hero-banner-image"
                    >


                    <!-- Floating Card -->
                    <div class="hero-floating-card">

                        <div class="hero-floating-icon">

                            <i class="fa-solid fa-heart"></i>

                        </div>


                        <div class="hero-floating-content">

                            <strong>
                                Better Care Starts Here
                            </strong>

                            <span>
                                Compassionate care every day
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>