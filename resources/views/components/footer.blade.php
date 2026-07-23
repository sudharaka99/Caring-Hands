<!-- ==========================================
     FOOTER SECTION
     ========================================== -->
<footer>
    <div class="container">
        <div class="footer-grid">
            <!-- About -->
            <div class="footer-about">
                <a href="{{ route('home') }}" class="logo footer-logo">
                    <div class="logo-icon">
                        <i class="fa-solid fa-hands-holding-heart"></i>
                    </div>
                    Caring Hands
                </a>
                <p>
                    A modern elder home management solution
                    designed to improve care, communication
                    and everyday operations.
                </p>
                <div class="social-links">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('services') }}">Services</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h4 class="footer-title">Services</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('services') }}">Elder Management</a></li>
                    <li><a href="{{ route('services') }}">Caregiver Management</a></li>
                    <li><a href="{{ route('services') }}">Healthcare</a></li>
                    <li><a href="{{ route('services') }}">Care Plans</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="footer-title">Contact</h4>
                <ul class="footer-links">
                    <li>Colombo, Sri Lanka</li>
                    <li>+94 11 234 5678</li>
                    <li>info@caringhands.com</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>
                &copy; {{ date('Y') }}
                Caring Hands Elder Home Management System.
                All Rights Reserved.
            </p>
        </div>
    </div>
</footer>