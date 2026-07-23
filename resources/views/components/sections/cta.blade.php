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
            @guest
                <button class="btn" onclick="openLogin()">
                    Access Caring Hands
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            @else
                <a href="{{ route('dashboard') }}" class="btn">
                    Go to Dashboard
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endguest
        </div>
    </div>
</section>