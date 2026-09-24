<section class="section" id="features">
    <div class="container">

        <div class="section-title">
            <span class="section-tag">System Features</span>
            <h2>Smart Tools for Better Management</h2>
            <p>Caring Hands provides the tools required to manage residents, staff and daily care activities efficiently.</p>
        </div>

        @if(isset($features) && $features->count() > 0)

            <div class="features-grid">
                @foreach($features as $feature)
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="{{ $feature->icon ?? 'fa-solid fa-star' }}"></i>
                        </div>
                        <div class="feature-content">
                            <h3>{{ $feature->title }}</h3>
                            <p>{{ $feature->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        @else

            {{-- Fallback: static features --}}
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="feature-content">
                        <h3>Resident Information</h3>
                        <p>Access important resident information from one centralized and secure system.</p>
                    </div>
                </div>
                {{-- ... other static features ... --}}
            </div>

        @endif

    </div>
</section>