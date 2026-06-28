<footer class="widget footer-widget cprc-footer">
  <div class="footer-widget-image"></div>

  <div class="cprc-footer-main">

    {{-- Column 1: Club Identity --}}
    <div class="cprc-footer-col cprc-footer-brand">
      <div class="cprc-footer-logo-row">
        <img src="{{ asset('images/club/logo.jpeg') }}" alt="{{ __('site.club_name_short') }}"
             class="cprc-footer-logo" onerror="this.style.display='none'">
        <div>
          <p class="cprc-footer-club-name">{{ __('site.club_name') }}</p>
          <p class="cprc-footer-authority">{{ __('site.authority') }}</p>
        </div>
      </div>
      <p class="cprc-footer-about">
        @if(app()->getLocale() === 'bn')
          চট্টগ্রাম বন্দর রিপাবলিক ক্লাব (সিপিআরসি) বন্দর নগরীর অন্যতম প্রাচীন ও মর্যাদাপূর্ণ সামাজিক ক্লাব। বিবাহ, অনুষ্ঠান ও কর্পোরেট ইভেন্টের জন্য আমাদের হল ভাড়া নিন।
        @else
          Chittagong Port Republic Club (CPRC) is one of the oldest and most prestigious social clubs in Port City — available for weddings, ceremonies & corporate events.
        @endif
      </p>
      <p class="cprc-footer-est">{{ __('site.established') }}</p>
    </div>

    {{-- Column 2: Quick Links --}}
    <div class="cprc-footer-col">
      <h4 class="cprc-footer-heading">{{ __('site.quick_links') }}</h4>
      <ul class="cprc-footer-links">
        <li><a href="{{ url('/') }}"><i class="ph ph-house"></i> {{ __('site.home') }}</a></li>
        <li><a href="{{ route('about') }}"><i class="ph ph-info"></i> {{ __('site.about') }}</a></li>
        <li><a href="{{ route('packages.index') }}"><i class="ph ph-calendar-check"></i> {{ __('site.hall_booking') }}</a></li>
        <li><a href="{{ route('notices.index') }}"><i class="ph ph-file-text"></i> {{ __('site.notices') }}</a></li>
        <li><a href="{{ route('events.index') }}"><i class="ph ph-calendar"></i> {{ __('site.events') }}</a></li>
        <li><a href="{{ route('gallery.index') }}"><i class="ph ph-images"></i> {{ __('site.gallery') }}</a></li>
        <li><a href="{{ route('news.index') }}"><i class="ph ph-newspaper"></i> {{ __('site.news') }}</a></li>
        <li><a href="{{ route('members.index') }}"><i class="ph ph-users"></i> {{ __('site.members') }}</a></li>
        <li><a href="{{ route('contact') }}"><i class="ph ph-envelope"></i> {{ __('site.contact') }}</a></li>
      </ul>
    </div>

    {{-- Column 3: Booking Info --}}
    <div class="cprc-footer-col">
      <h4 class="cprc-footer-heading">{{ __('site.hall_booking') }}</h4>
      <div class="cprc-footer-packages">
        <div class="cprc-footer-pkg">
          <i class="ph ph-clock"></i>
          <div>
            <strong>{{ app()->getLocale() === 'bn' ? 'হাফ ডে (৬ ঘণ্টা)' : 'Half Day (6 hrs)' }}</strong>
            <span>{{ app()->getLocale() === 'bn' ? '৳৩০,০০০ থেকে শুরু' : 'From ৳30,000' }}</span>
          </div>
        </div>
        <div class="cprc-footer-pkg">
          <i class="ph ph-sun"></i>
          <div>
            <strong>{{ app()->getLocale() === 'bn' ? 'ফুল ডে (১২ ঘণ্টা)' : 'Full Day (12 hrs)' }}</strong>
            <span>{{ app()->getLocale() === 'bn' ? '৳৫৫,০০০ থেকে শুরু' : 'From ৳55,000' }}</span>
          </div>
        </div>
        <div class="cprc-footer-pkg">
          <i class="ph ph-moon-stars"></i>
          <div>
            <strong>{{ app()->getLocale() === 'bn' ? 'গ্র্যান্ড (২৪ ঘণ্টা)' : 'Grand (24 hrs)' }}</strong>
            <span>{{ app()->getLocale() === 'bn' ? '৳৯০,০০০ থেকে শুরু' : 'From ৳90,000' }}</span>
          </div>
        </div>
      </div>
      <a href="{{ route('booking.form') }}" class="cprc-footer-book-btn">
        <i class="ph ph-calendar-check"></i>
        {{ app()->getLocale() === 'bn' ? 'এখনই বুক করুন' : 'Book Hall Now' }}
      </a>

      {{-- Newsletter signup --}}
      <div class="cprc-footer-newsletter">
        <h5>{{ app()->getLocale() === 'bn' ? 'আপডেট পান' : 'Stay Updated' }}</h5>
        @if(session('newsletter_success'))
          <p class="newsletter-success">✓ {{ session('newsletter_success') }}</p>
        @else
          <form action="{{ route('newsletter.subscribe') }}" method="POST" class="newsletter-form" id="newsletterForm">
            @csrf
            <input type="email" name="email" required
                   placeholder="{{ app()->getLocale() === 'bn' ? 'আপনার ইমেইল' : 'Your email' }}"
                   class="newsletter-input">
            <button type="submit" class="newsletter-btn">
              <i class="ph ph-paper-plane-tilt"></i>
            </button>
          </form>
        @endif
      </div>
    </div>

    {{-- Column 4: Contact --}}
    <div class="cprc-footer-col">
      <h4 class="cprc-footer-heading">{{ __('site.contact_us') }}</h4>
      <ul class="cprc-footer-contact-list">
        <li>
          <i class="ph ph-map-pin"></i>
          <span>{{ __('site.address') }}</span>
        </li>
        <li>
          <i class="ph ph-phone"></i>
          <span>+880-31-2500000</span>
        </li>
        <li>
          <i class="ph ph-phone"></i>
          <span>+880-31-2500001</span>
        </li>
        <li>
          <i class="ph ph-whatsapp-logo"></i>
          <a href="https://wa.me/8801XXXXXXXXX" style="color:inherit;">WhatsApp {{ app()->getLocale() === 'bn' ? 'যোগাযোগ' : 'Enquiry' }}</a>
        </li>
        <li>
          <i class="ph ph-envelope"></i>
          <a href="mailto:info@cprc.cpa.gov.bd" style="color:inherit;">info@cprc.cpa.gov.bd</a>
        </li>
        <li>
          <i class="ph ph-clock"></i>
          <span>{{ __('site.office_hours') }}</span>
        </li>
      </ul>

      <h4 class="cprc-footer-heading" style="margin-top:16px;">{{ __('site.follow_us') }}</h4>
      <div class="cprc-footer-social">
        <a href="#" class="cprc-fsoc-fb" aria-label="Facebook"><i class="ph ph-facebook-logo"></i></a>
        <a href="#" class="cprc-fsoc-yt" aria-label="YouTube"><i class="ph ph-youtube-logo"></i></a>
        <a href="https://wa.me/8801XXXXXXXXX" class="cprc-fsoc-wa" aria-label="WhatsApp"><i class="ph ph-whatsapp-logo"></i></a>
      </div>
    </div>

  </div>

  {{-- Bottom bar --}}
  <div class="cprc-footer-bottom" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
    <div>
      @if(app()->getLocale() === 'bn')
        কপিরাইট &copy; ২০২৬ - চট্টগ্রাম বন্দর রিপাবলিক ক্লাব। সর্বস্বত্ব সংরক্ষিত।
      @else
        Copyright &copy; 2026 - Chittagong Port Republic Club. All rights reserved.
      @endif
    </div>
    <div>
      @if(app()->getLocale() === 'bn')
        ডিজাইন এবং ডেভেলপমেন্ট করেছেন এজাজ মাহমুদ।
      @else
        Designed and Developed by Ejaj Mahmud.
      @endif
    </div>
  </div>

</footer>
