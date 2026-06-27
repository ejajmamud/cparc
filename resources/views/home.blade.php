@extends('layouts.app')

@section('title', __('site.club_name') . ' | ' . __('site.tagline'))

@section('banner')
@php
  /* Pick up to 8 slide images from public/images/club/slide_*.jpeg */
  $heroSlides = collect(\Illuminate\Support\Facades\File::files(public_path('images/club')))
      ->filter(fn($f) => str_starts_with($f->getFilename(), 'slide_')
          && in_array(strtolower($f->getExtension()), ['jpg','jpeg','png','webp']))
      ->sortBy(fn($f) => (int) filter_var($f->getFilename(), FILTER_SANITIZE_NUMBER_INT))
      ->values()
      ->map(fn($f) => $f->getFilename())
      ->take(8);

  /* If admin has uploaded BannerImages, use those instead */
  if ($bannerImages->isNotEmpty()) {
      $heroSlides = $bannerImages->map(fn($b) => $b->path);
      $heroIsAdmin = true;
  } else {
      $heroIsAdmin = false;
  }

  $slideCount  = $heroSlides->count();
  $duration    = 5; // seconds per slide
  $totalTime   = $slideCount * $duration;
@endphp

<section class="cprc-hero-slider" style="--slide-count:{{ $slideCount }};--slide-duration:{{ $duration }}s;--total-time:{{ $totalTime }}s;">

  {{-- Slides --}}
  @foreach($heroSlides as $i => $slide)
    <div class="cprc-hero-slide" style="animation-delay:{{ $i * $duration }}s;background-image:url('{{ (str_contains($slide, '/') && !str_starts_with($slide, 'images/')) ? asset('storage/'.$slide) : ($heroIsAdmin ? asset($slide) : asset('images/club/'.$slide)) }}');" aria-hidden="{{ $i > 0 ? 'true' : 'false' }}"></div>
  @endforeach

  {{-- Overlay with club identity --}}
  <div class="cprc-hero-overlay">
    <div class="cprc-hero-brand">
      <img src="{{ asset('images/club/logo.jpeg') }}" alt="CPRC logo" class="cprc-hero-logo"
           onerror="this.style.display='none'">
      <div class="cprc-hero-text">
        <h1 class="cprc-hero-name">{{ __('site.club_name') }}</h1>
        <p class="cprc-hero-auth">{{ __('site.authority') }}</p>
        <p class="cprc-hero-est">{{ __('site.established') }}</p>
      </div>
    </div>

    <div class="cprc-hero-cta">
      <a href="{{ route('booking.form') }}" class="cprc-hero-btn cprc-hero-btn-primary">
        <i class="ph ph-calendar-check"></i>
        {{ app()->getLocale() === 'bn' ? 'হল বুক করুন' : 'Book the Hall' }}
      </a>
      <a href="{{ route('packages.index') }}" class="cprc-hero-btn cprc-hero-btn-outline">
        <i class="ph ph-package"></i>
        {{ app()->getLocale() === 'bn' ? 'প্যাকেজ দেখুন' : 'View Packages' }}
      </a>
    </div>
  </div>

  {{-- Dot indicators (clickable) --}}
  <div class="cprc-hero-dots" role="tablist" aria-label="Slide navigation">
    @for($d = 0; $d < $slideCount; $d++)
      <button class="cprc-hero-dot {{ $d === 0 ? 'active' : '' }}"
              role="tab"
              aria-label="Slide {{ $d + 1 }}"
              aria-selected="{{ $d === 0 ? 'true' : 'false' }}"
              data-index="{{ $d }}"></button>
    @endfor
  </div>

</section>

@push('scripts')
<script>
(function () {
  const slider    = document.querySelector('.cprc-hero-slider');
  if (!slider) return;

  const slides    = slider.querySelectorAll('.cprc-hero-slide');
  const dots      = slider.querySelectorAll('.cprc-hero-dot');
  const total     = slides.length;
  const interval  = 5000; // ms per slide
  let current     = 0;
  let timer       = null;

  function goTo(index) {
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    dots[current].setAttribute('aria-selected', 'false');

    current = (index + total) % total;

    slides[current].classList.add('active');
    dots[current].classList.add('active');
    dots[current].setAttribute('aria-selected', 'true');
  }

  function startAuto() {
    clearInterval(timer);
    timer = setInterval(() => goTo(current + 1), interval);
  }

  // Dot click — jump to slide and restart timer
  dots.forEach(dot => {
    dot.addEventListener('click', function () {
      goTo(parseInt(this.dataset.index));
      startAuto();
    });
  });

  // Init
  goTo(0);
  startAuto();
})();
</script>
@endpush
@endsection

@section('content')
<div class="cprc-home-wrapper">

  {{-- ── MAIN COLUMN ── --}}
  <div class="cprc-main-col">

    {{-- Notice + Events panels --}}
    <div class="cprc-two-col">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-file-text"></i> {{ __('site.notice_board') }}</p>
          <ul class="notice-unordered-list">
            @forelse($notices as $notice)
              <li class="notice-content-list">
                <a class="notice-link" href="{{ route('notices.show', $notice->slug) }}">
                  <div class="notice-content-icon"><i class="dot"></i></div>
                  <div class="notice-text-wrap">
                    <p title="{{ app()->getLocale() === 'bn' && $notice->title_bn ? $notice->title_bn : $notice->title }}"
                       class="notice-text">
                      {{ app()->getLocale() === 'bn' && $notice->title_bn ? $notice->title_bn : $notice->title }}
                    </p>
                    <p class="notice-text">
                      <span class="notice-tag"><i class="ph ph-calendar-dots"></i> {{ $notice->published_at->format('d M Y') }}</span>
                      @if($notice->is_new)<strong class="notice-new-badge">{{ __('site.new') }}</strong>@endif
                      <strong class="notice-type-tag">{{ __('site.' . $notice->type) }}</strong>
                    </p>
                  </div>
                  <div class="notice-content-icon"><i class="ph ph-caret-right"></i></div>
                </a>
              </li>
            @empty
              <li class="notice-content-list cprc-empty-item">
                {{ app()->getLocale() === 'bn' ? 'বর্তমানে কোনো বিজ্ঞপ্তি নেই।' : 'No notices at this time.' }}
              </li>
            @endforelse
          </ul>
        </div>
        <div class="all-btn">
          <a href="{{ route('notices.index') }}">{{ __('site.see_all') }} {{ __('site.notices') }} <i class="ph ph-arrow-right"></i></a>
        </div>
        <div class="news-card">
          <section class="widget news-card-widget">
            <div class="news-card-widget-scroll-container">
              <div class="news-card-widget-news-title">{{ __('site.latest_news') }}</div>
              <div class="news-card-widget-ticker">
                @foreach($latestNews as $item)
                  <a href="{{ route('news.show', $item->slug) }}" class="new-content scroll-text">
                    {{ app()->getLocale() === 'bn' && $item->title_bn ? $item->title_bn : $item->title }}
                  </a>
                @endforeach
              </div>
              <div class="all-btn"><a href="{{ route('news.index') }}">{{ __('site.see_all') }} <i class="ph ph-arrow-right"></i></a></div>
            </div>
          </section>
        </div>
      </section>

      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-calendar-check"></i> {{ __('site.upcoming_events') }}</p>
          <ul class="notice-unordered-list">
            @forelse($upcomingEvents as $event)
              <li class="notice-content-list">
                <a class="notice-link" href="{{ route('events.show', $event->slug) }}">
                  <div class="notice-content-icon"><i class="dot"></i></div>
                  <div class="notice-text-wrap">
                    <p title="{{ app()->getLocale() === 'bn' && $event->title_bn ? $event->title_bn : $event->title }}"
                       class="notice-text">
                      {{ app()->getLocale() === 'bn' && $event->title_bn ? $event->title_bn : $event->title }}
                    </p>
                    <p class="notice-text">
                      <span class="notice-tag"><i class="ph ph-calendar-dots"></i> {{ $event->event_date->format('d M Y') }}</span>
                      <strong class="notice-type-tag">
                        {{ app()->getLocale() === 'bn' && $event->venue_bn ? $event->venue_bn : $event->venue }}
                      </strong>
                    </p>
                  </div>
                  <div class="notice-content-icon"><i class="ph ph-caret-right"></i></div>
                </a>
              </li>
            @empty
              <li class="notice-content-list cprc-empty-item">
                {{ app()->getLocale() === 'bn' ? 'কোনো আসন্ন অনুষ্ঠান নেই।' : 'No upcoming events.' }}
              </li>
            @endforelse
          </ul>
        </div>
        <div class="all-btn">
          <a href="{{ route('events.index') }}">{{ __('site.see_all') }} {{ __('site.events') }} <i class="ph ph-arrow-right"></i></a>
        </div>
      </section>
    </div>

    {{-- ── HALL BOOKING / PACKAGES ── --}}
    <div class="cprc-section-block cprc-packages-section">
      <div class="cprc-packages-header">
        <div>
          <h2 class="section-heading"><i class="ph ph-buildings"></i> {{ __('site.hall_booking') }}</h2>
          <p class="cprc-packages-subtitle">{{ __('site.hall_booking_subtitle') }}</p>
        </div>
        <a href="{{ route('packages.index') }}" class="cprc-all-pkg-btn">
          {{ app()->getLocale() === 'bn' ? 'সব প্যাকেজ' : 'All Packages' }} <i class="ph ph-arrow-right"></i>
        </a>
      </div>

      <div class="cprc-pkg-grid">
        @foreach($packages as $pkg)
          <div class="cprc-pkg-card {{ $pkg->is_featured ? 'cprc-pkg-featured' : '' }}">
            @if($pkg->is_featured)
              <div class="cprc-pkg-badge">{{ app()->getLocale() === 'bn' ? 'সবচেয়ে জনপ্রিয়' : 'Most Popular' }}</div>
            @endif
            <div class="cprc-pkg-duration">
              <i class="ph ph-clock"></i>
              {{ app()->getLocale() === 'bn' ? $pkg->duration_label_bn : $pkg->duration_label }}
            </div>
            <h3 class="cprc-pkg-name">
              {{ app()->getLocale() === 'bn' ? $pkg->name_bn : $pkg->name }}
            </h3>
            <div class="cprc-pkg-price">
              <span class="cprc-pkg-note">{{ app()->getLocale() === 'bn' ? '৳' : '৳' }}</span>
              <span class="cprc-pkg-amount">{{ number_format($pkg->price) }}</span>
              <span class="cprc-pkg-per">/ {{ __('site.per_session') }}</span>
            </div>
            <p class="cprc-pkg-desc">
              {{ app()->getLocale() === 'bn' && $pkg->description_bn ? $pkg->description_bn : $pkg->description }}
            </p>
            <ul class="cprc-pkg-features">
              @php $feats = app()->getLocale() === 'bn' && $pkg->features_bn ? $pkg->features_bn : $pkg->features; @endphp
              @foreach(array_slice($feats ?? [], 0, 6) as $feat)
                <li><i class="ph ph-check-circle"></i> {{ $feat }}</li>
              @endforeach
            </ul>
            <a href="{{ route('booking.form') }}?package={{ $pkg->id }}" class="cprc-pkg-btn {{ $pkg->is_featured ? 'cprc-pkg-btn-featured' : '' }}">
              <i class="ph ph-calendar-check"></i> {{ __('site.book_now') }}
            </a>
          </div>
        @endforeach
      </div>

      {{-- WhatsApp booking CTA --}}
      <div class="cprc-booking-cta">
        <i class="ph ph-phone-call cprc-cta-icon"></i>
        <div>
          <strong>{{ app()->getLocale() === 'bn' ? 'সরাসরি যোগাযোগ করুন' : 'Direct Booking Enquiry' }}</strong>
          <p>{{ app()->getLocale() === 'bn' ? 'ফোন বা হোয়াটসঅ্যাপে আমাদের সাথে যোগাযোগ করুন' : 'Call or WhatsApp us for availability & custom packages' }}</p>
        </div>
        <div class="cprc-cta-btns">
          <a href="tel:+8803125000000" class="cprc-cta-phone"><i class="ph ph-phone"></i> +880-31-2500000</a>
          <a href="https://wa.me/8801XXXXXXXXX?text={{ urlencode('হল বুকিং সম্পর্কে জানতে চাই') }}"
             class="cprc-cta-whatsapp" target="_blank">
            <svg viewBox="0 0 24 24" fill="currentColor" width="18" height="18" style="flex-shrink:0">
              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
            WhatsApp
          </a>
        </div>
      </div>
    </div>

    {{-- Services Grid --}}
    <div class="cprc-section-block">
      <h2 class="section-heading"><i class="ph ph-squares-four"></i> {{ __('site.our_services') }}</h2>
      <div class="cprc-services-grid">
        @php
          $locale = app()->getLocale();
          $services = [
            ['icon'=>'ph-buildings',    'en'=>'Event Hall',       'bn'=>'ইভেন্ট হল',         'url'=>route('packages.index')],
            ['icon'=>'ph-trophy',       'en'=>'Sports & Games',   'bn'=>'ক্রীড়া ও খেলাধুলা', 'url'=>route('events.index')],
            ['icon'=>'ph-fork-knife',   'en'=>'Dining & Catering','bn'=>'ডাইনিং ও ক্যাটারিং', 'url'=>route('about')],
            ['icon'=>'ph-tree-palm',    'en'=>'Green Grounds',    'bn'=>'সবুজ মাঠ',            'url'=>route('about')],
            ['icon'=>'ph-music-notes',  'en'=>'Cultural Events',  'bn'=>'সাংস্কৃতিক অনুষ্ঠান','url'=>route('events.index')],
            ['icon'=>'ph-books',        'en'=>'Club Library',     'bn'=>'ক্লাব লাইব্রেরি',    'url'=>route('about')],
          ];
        @endphp
        @foreach($services as $svc)
          <a href="{{ $svc['url'] }}" class="cprc-service-box">
            <i class="ph {{ $svc['icon'] }} cprc-service-icon"></i>
            <span class="cprc-service-label">{{ $locale === 'bn' ? $svc['bn'] : $svc['en'] }}</span>
          </a>
        @endforeach
      </div>
    </div>

    {{-- Photo Gallery --}}
    <div class="cprc-section-block cprc-gallery-section">
      <h2 class="section-heading"><i class="ph ph-images"></i> {{ __('site.photo_gallery') }}</h2>
      <div class="cprc-gallery-grid">
        @forelse($galleryPhotos as $photo)
          <a href="{{ asset($photo->path) }}" target="_blank" class="cprc-gallery-item">
            <img src="{{ asset($photo->thumbnail ?? $photo->path) }}"
                 alt="{{ $photo->caption ?? __('site.club_name') }}">
          </a>
        @empty
          <p class="cprc-empty-item">{{ app()->getLocale() === 'bn' ? 'গ্যালারি ছবি শীঘ্রই আসছে।' : 'Gallery photos coming soon.' }}</p>
        @endforelse
      </div>
      <div class="all-btn" style="margin-top:var(--spacing-medium);">
        <a href="{{ route('gallery.index') }}">{{ __('site.view_full_gallery') }} <i class="ph ph-arrow-right"></i></a>
      </div>
    </div>

  </div>{{-- /cprc-main-col --}}

  {{-- ── RIGHT SIDEBAR ── --}}
  <aside class="cprc-sidebar-col">

    {{-- Leadership Cards --}}
    @php
      $president  = $executives->first();
      $secretary  = $executives->where('sort_order', 2)->first() ?? $executives->skip(1)->first();
    @endphp
    <div class="cprc-sidebar-persons-row">
      @if($president)
      <div class="cprc-sidebar-widget" style="margin-bottom:0;">
        <div class="cprc-sidebar-heading">{{ __('site.president') }}</div>
        <div class="cprc-sidebar-person">
          <img src="{{ $president->photo ? asset('storage/' . $president->photo) : asset('images/club/logo.jpeg') }}"
               alt="{{ $president->name }}" onerror="this.src='{{ asset('images/club/logo.jpeg') }}'">
          <p class="cprc-person-name">
            {{ app()->getLocale() === 'bn' && $president->name_bn ? $president->name_bn : $president->name }}
          </p>
          <p class="cprc-person-desg">
            {{ app()->getLocale() === 'bn' && $president->designation_bn ? $president->designation_bn : $president->designation }}
          </p>
          <a href="{{ route('members.index') }}" class="cprc-detail-btn">{{ __('site.details') }}</a>
        </div>
      </div>
      @endif
      @if($secretary)
      <div class="cprc-sidebar-widget" style="margin-bottom:0;">
        <div class="cprc-sidebar-heading">{{ __('site.general_secretary') }}</div>
        <div class="cprc-sidebar-person">
          <img src="{{ $secretary->photo ? asset('storage/' . $secretary->photo) : asset('images/club/logo.jpeg') }}"
               alt="{{ $secretary->name }}" onerror="this.src='{{ asset('images/club/logo.jpeg') }}'">
          <p class="cprc-person-name">
            {{ app()->getLocale() === 'bn' && $secretary->name_bn ? $secretary->name_bn : $secretary->name }}
          </p>
          <p class="cprc-person-desg">
            {{ app()->getLocale() === 'bn' && $secretary->designation_bn ? $secretary->designation_bn : $secretary->designation }}
          </p>
          <a href="{{ route('members.index') }}" class="cprc-detail-btn">{{ __('site.details') }}</a>
        </div>
      </div>
      @endif
    </div>
    <div style="margin-bottom:var(--spacing-medium);"></div>

    {{-- Quick Booking Widget --}}
    <div class="cprc-sidebar-widget">
      <div class="cprc-sidebar-heading"><i class="ph ph-calendar-check"></i> {{ __('site.hall_booking') }}</div>
      <div style="padding:var(--spacing-medium);">
        <p style="font-size:0.82rem;color:#444;margin:0 0 10px;line-height:1.5;">
          {{ app()->getLocale() === 'bn' ? 'বিবাহ, হলুদ, কর্পোরেট ইভেন্ট ও সাংস্কৃতিক অনুষ্ঠানের জন্য আমাদের হল ভাড়া নিন।' : 'Rent our hall for weddings, holud, corporate events & cultural programmes.' }}
        </p>
        <div style="display:flex;flex-direction:column;gap:6px;">
          <div style="display:flex;justify-content:space-between;font-size:0.8rem;padding:6px;background:#f4f6f8;border-radius:4px;">
            <span>{{ app()->getLocale() === 'bn' ? '৬ ঘণ্টা' : '6 Hours' }}</span>
            <strong style="color:var(--color-primary-bg);">৳৩০,০০০+</strong>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:0.8rem;padding:6px;background:var(--color-primary-bg);color:#fff;border-radius:4px;">
            <span>{{ app()->getLocale() === 'bn' ? '১২ ঘণ্টা' : '12 Hours' }}</span>
            <strong>৳৫৫,০০০+</strong>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:0.8rem;padding:6px;background:#f4f6f8;border-radius:4px;">
            <span>{{ app()->getLocale() === 'bn' ? '২৪ ঘণ্টা' : '24 Hours' }}</span>
            <strong style="color:var(--color-primary-bg);">৳৯০,০০০+</strong>
          </div>
        </div>
        <a href="{{ route('packages.index') }}" class="cprc-detail-btn" style="display:block;text-align:center;margin-top:10px;">
          {{ app()->getLocale() === 'bn' ? 'সব প্যাকেজ দেখুন' : 'View All Packages' }}
        </a>
      </div>
    </div>

    {{-- Important Links --}}
    <div class="cprc-sidebar-widget">
      <div class="cprc-sidebar-heading"><i class="ph ph-link"></i> {{ app()->getLocale() === 'bn' ? 'গুরুত্বপূর্ণ লিঙ্ক' : 'Important Links' }}</div>
      <ul class="cprc-link-list">
        <li><a href="https://www.cpa.gov.bd" target="_blank" rel="noopener"><i class="ph ph-arrow-square-out"></i> {{ app()->getLocale() === 'bn' ? 'চট্টগ্রাম বন্দর কর্তৃপক্ষ' : 'Chittagong Port Authority' }}</a></li>
        <li><a href="https://www.moshippin.gov.bd" target="_blank" rel="noopener"><i class="ph ph-arrow-square-out"></i> {{ app()->getLocale() === 'bn' ? 'নৌপরিবহন মন্ত্রণালয়' : 'Ministry of Shipping' }}</a></li>
        <li><a href="https://www.bangladesh.gov.bd" target="_blank" rel="noopener"><i class="ph ph-arrow-square-out"></i> {{ app()->getLocale() === 'bn' ? 'জাতীয় তথ্য বাতায়ন' : 'Bangladesh National Portal' }}</a></li>
        <li><a href="{{ route('notices.index') }}?type=tender"><i class="ph ph-file-text"></i> {{ __('site.tender') }}</a></li>
        <li><a href="{{ route('notices.index') }}?type=recruitment"><i class="ph ph-user-plus"></i> {{ __('site.recruitment') }}</a></li>
        <li><a href="{{ route('members.index') }}"><i class="ph ph-users"></i> {{ __('site.members') }}</a></li>
      </ul>
    </div>

    {{-- Social + Contact --}}
    <div class="cprc-sidebar-widget">
      <div class="cprc-sidebar-heading"><i class="ph ph-share-network"></i> {{ __('site.follow_us') }}</div>
      <div class="cprc-social-row">
        <a href="#" class="cprc-social-fb"><i class="ph ph-facebook-logo"></i> Facebook</a>
        <a href="https://wa.me/8801XXXXXXXXX" class="cprc-social-wa"><i class="ph ph-whatsapp-logo"></i> WhatsApp</a>
      </div>
    </div>

    <div class="cprc-sidebar-widget cprc-contact-box">
      <div class="cprc-sidebar-heading"><i class="ph ph-phone-call"></i> {{ __('site.contact_us') }}</div>
      <p class="cprc-contact-phone"><i class="ph ph-phone"></i> +880-31-2500000</p>
      <p class="cprc-contact-addr">{{ __('site.address') }}</p>
      <p class="cprc-contact-hours">{{ __('site.office_hours') }}</p>
    </div>

  </aside>

</div>
@endsection
