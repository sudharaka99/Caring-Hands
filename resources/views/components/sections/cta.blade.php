<!-- ==========================================
     CALL-TO-ACTION SECTION
========================================== -->

<section class="cta">
    <div class="container">

        <div class="cta-box">

            <h2>Ready to Transform Elder Care?</h2>

            <p>
                Bring residents, caregivers and healthcare
                professionals together with Caring Hands.
            </p>


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
                   class="btn">

                    Go to Dashboard

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            @else

                <a href="{{ route('login') }}"
                   class="btn">

                    Access Caring Hands

                    <i class="fa-solid fa-arrow-right"></i>

                </a>

            @endauth

        </div>

    </div>
</section>