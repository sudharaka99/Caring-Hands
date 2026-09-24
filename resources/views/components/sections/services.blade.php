<section class="section section-light" id="services">
    <div class="container">

        <div class="section-title">
            <span class="section-tag">Our Services</span>
            <h2>Comprehensive Elder Care Solutions</h2>
            <p>Discover how Caring Hands can transform your elder care facility.</p>
        </div>

        @if(isset($services) && $services->count() > 0)

            <div class="services-grid">
                @foreach($services as $service)
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="{{ $service->icon ?? 'fa-solid fa-heart' }}"></i>
                        </div>
                        <h3>{{ $service->title }}</h3>
                        <p>{{ $service->description }}</p>
                    </div>
                @endforeach
            </div>

        @endif

    </div>
</section>