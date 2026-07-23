<!-- ==========================================
     HERO SECTION
========================================== -->
<section class="hero" id="home">
    <div class="container">

        <div class="hero-wrapper">

            <!-- Hero Content -->
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

                    @guest
                        <button class="btn btn-primary"
                                onclick="openLogin()">
                            Get Started
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="btn btn-primary">
                            Dashboard
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @endguest

                    <a href="#about"
                       class="btn btn-outline">
                        Learn More
                    </a>

                </div>

            </div>


            <!-- Hero Elder Banner Image -->
            <div class="hero-visual">

                <div class="hero-image-wrapper">

                    <img src="{{ asset('images/elder-banner.png') }}"
                         alt="Happy elderly residents at Caring Hands"
                         class="hero-banner-image">

                    <!-- Floating Info Card -->
                    <div class="hero-floating-card">

                        <div class="hero-floating-icon">
                            <i class="fa-solid fa-heart"></i>
                        </div>

                        <div>
                            <strong>Better Care Starts Here</strong>
                            <span>Compassionate care every day</span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>