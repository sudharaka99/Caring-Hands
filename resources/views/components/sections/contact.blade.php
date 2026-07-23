<!-- ==========================================
     CONTACT SECTION
     ========================================== -->
<section class="section section-light" id="contact">
    <div class="container">
        <div class="contact-wrapper">
            <!-- Contact Info -->
            <div class="contact-info">
                <span class="section-tag">Contact Us</span>
                <h2>We're Here to Help</h2>
                <p>
                    Have questions about Caring Hands?
                    Send us a message and our team will
                    be happy to assist you.
                </p>

                <div class="contact-item">
                    <div class="contact-item-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <h4>Email</h4>
                        <p>info@caringhands.com</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-item-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <h4>Phone</h4>
                        <p>+94 11 234 5678</p>
                    </div>
                </div>

                <div class="contact-item">
                    <div class="contact-item-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h4>Location</h4>
                        <p>Colombo, Sri Lanka</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <form class="contact-form" method="POST" action="{{ route('contact.submit') }}" onsubmit="submitContact(event)">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" 
                               id="first_name"
                               name="first_name"
                               class="form-control @error('first_name') is-invalid @enderror" 
                               placeholder="Your first name" 
                               value="{{ old('first_name') }}"
                               required>
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" 
                               id="last_name"
                               name="last_name"
                               class="form-control @error('last_name') is-invalid @enderror" 
                               placeholder="Your last name" 
                               value="{{ old('last_name') }}"
                               required>
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" 
                           id="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror" 
                           placeholder="example@email.com" 
                           value="{{ old('email') }}"
                           required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" 
                           id="subject"
                           name="subject"
                           class="form-control @error('subject') is-invalid @enderror" 
                           placeholder="How can we help?"
                           value="{{ old('subject') }}">
                    @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message"
                              name="message"
                              class="form-control @error('message') is-invalid @enderror" 
                              placeholder="Write your message..."
                              required>{{ old('message') }}</textarea>
                    @error('message')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Send Message
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>
</section>