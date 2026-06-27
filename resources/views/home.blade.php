@extends('layouts.app')

@section('title', 'Home | Chittagong Port Republic Club')

@section('banner')
{{-- Hero banner slider with logo overlay --}}
<section class="widget banner-slider-image-widget">
  <div class="home-carousel">
    @forelse($bannerImages as $img)
      <a class="slider images" href="#">
        <img class="slider-image" src="{{ asset('storage/' . $img->path) }}" alt="{{ $img->caption ?? 'CPRC Banner' }}">
      </a>
    @empty
      {{-- Fallback: use club WhatsApp images --}}
      @foreach($fallbackImages as $path)
        <a class="slider images" href="#">
          <img class="slider-image" src="{{ asset('images/club/' . $path) }}" alt="Chittagong Port Republic Club">
        </a>
      @endforeach
    @endforelse

    {{-- Logo overlay on slider --}}
    <div class="slider-overlay widget-container-row">
      <div class="slider-left container-col-4">
        <a href="{{ url('/') }}">
          <img class="office-logo"
               src="{{ asset('images/club/logo.png') }}"
               alt="CPRC Logo"
               onerror="this.src='{{ asset('template/site-assets/images/logo.png') }}'">
        </a>
        <div class="office-left-section">
          <h1>
            <a style="text-decoration:none;" href="{{ url('/') }}" class="office-title">
              Chittagong Port Republic Club
            </a>
          </h1>
          <p class="office-subtitle">Chittagong Port Authority, Bangladesh</p>
        </div>
      </div>
      <div class="slider-controls container-col-4">
        <button class="nav-btn slider-previous">
          <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6.70508 11.7868L1.79976 6.88151L6.70508 1.9762" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <button class="nav-btn slider-play">
          <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6445 20.8813C13.2967 20.8813 15.8402 19.8278 17.7156 17.9524C19.591 16.0771 20.6445 13.5335 20.6445 10.8813C20.6445 8.22918 19.591 5.68564 17.7156 3.81028C15.8402 1.93492 13.2967 0.881348 10.6445 0.881348C7.99237 0.881348 5.44883 1.93492 3.57346 3.81028C1.6981 5.68564 0.644531 8.22918 0.644531 10.8813C0.644531 13.5335 1.6981 16.0771 3.57346 17.9524C5.44883 19.8278 7.99237 20.8813 10.6445 20.8813ZM10.0883 7.34135C9.90003 7.21575 9.68121 7.14361 9.45518 7.13263C9.22914 7.12165 9.00436 7.17224 8.80482 7.27901C8.60529 7.38577 8.43848 7.5447 8.32219 7.73884C8.2059 7.93298 8.1445 8.15504 8.14453 8.38135V13.3813C8.1445 13.6077 8.2059 13.8297 8.32219 14.0239C8.43848 14.218 8.60529 14.3769 8.80482 14.4837C9.00436 14.5905 9.22914 14.641 9.45518 14.6301C9.68121 14.6191 9.90003 14.5469 10.0883 14.4213L13.8383 11.9213C14.0095 11.8072 14.1498 11.6525 14.2469 11.4711C14.344 11.2897 14.3948 11.0871 14.3948 10.8813C14.3948 10.6756 14.344 10.473 14.2469 10.2916C14.1498 10.1102 14.0095 9.9555 13.8383 9.84135L10.0883 7.34135Z" fill="currentColor"/>
          </svg>
        </button>
        <button class="nav-btn slider-next">
          <svg width="8" height="13" viewBox="0 0 8 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.58447 11.7868L6.48979 6.88151L1.58447 1.9762" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')

{{-- Notice Board + News Ticker --}}
<div class="notice-section">
  <div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-medium);">
    <div class="container-row">
      <div class="container-col-6">
        <section class="widget notice-news-card-widget">
          <div class="notice-card">
            <p class="notice-title">
              <i class="ph ph-file-text"></i> Notice Board
            </p>
            <ul class="notice-unordered-list">
              @forelse($notices as $notice)
                <li class="notice-content-list">
                  <a class="notice-link" href="{{ route('notices.show', $notice->slug) }}">
                    <div class="notice-content-icon"><i class="dot"></i></div>
                    <div class="notice-text-wrap">
                      <p title="{{ $notice->title }}" class="notice-text">{{ $notice->title }}</p>
                      <p class="notice-text">
                        <span class="notice-tag"><i class="ph ph-calendar-dots"></i> {{ $notice->published_at->format('d-m-Y') }}</span>
                        @if($notice->is_new)
                          <strong class="notice-tag">New</strong>
                        @endif
                        <strong class="notice-tag">{{ ucfirst($notice->type) }}</strong>
                      </p>
                    </div>
                    <div class="notice-content-icon"><i class="ph ph-caret-right"></i></div>
                  </a>
                </li>
              @empty
                <li class="notice-content-list" style="padding:16px; color:#666;">
                  No notices at this time.
                </li>
              @endforelse
            </ul>
          </div>
          <div class="all-btn">
            <a href="{{ route('notices.index') }}">See All Notices <i class="ph ph-arrow-right"></i></a>
          </div>

          {{-- News ticker --}}
          <div class="news-card">
            <section class="widget news-card-widget">
              <div class="news-card-widget-scroll-container">
                <div class="news-card-widget-news-title">Latest News</div>
                <div class="news-card-widget-ticker">
                  @foreach($latestNews as $item)
                    <a href="{{ route('news.show', $item->slug) }}" class="new-content scroll-text">{{ $item->title }}</a>
                  @endforeach
                </div>
                <div class="all-btn">
                  <a href="{{ route('news.index') }}">All News <i class="ph ph-arrow-right"></i></a>
                </div>
              </div>
            </section>
          </div>
        </section>
      </div>

      {{-- Events / Important Links column --}}
      <div class="container-col-6">
        <section class="widget notice-news-card-widget">
          <div class="notice-card">
            <p class="notice-title">
              <i class="ph ph-calendar"></i> Upcoming Events
            </p>
            <ul class="notice-unordered-list">
              @forelse($upcomingEvents as $event)
                <li class="notice-content-list">
                  <a class="notice-link" href="{{ route('events.show', $event->slug) }}">
                    <div class="notice-content-icon"><i class="dot"></i></div>
                    <div class="notice-text-wrap">
                      <p title="{{ $event->title }}" class="notice-text">{{ $event->title }}</p>
                      <p class="notice-text">
                        <span class="notice-tag"><i class="ph ph-calendar-dots"></i> {{ $event->event_date->format('d-m-Y') }}</span>
                        <strong class="notice-tag">{{ $event->venue }}</strong>
                      </p>
                    </div>
                    <div class="notice-content-icon"><i class="ph ph-caret-right"></i></div>
                  </a>
                </li>
              @empty
                <li class="notice-content-list" style="padding:16px; color:#666;">
                  No upcoming events.
                </li>
              @endforelse
            </ul>
          </div>
          <div class="all-btn">
            <a href="{{ route('events.index') }}">See All Events <i class="ph ph-arrow-right"></i></a>
          </div>
        </section>
      </div>
    </div>
  </div>
</div>

{{-- Executive Committee / Person Cards --}}
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-medium);">
  <section class="widget person-card-stack-widget">
    <div class="person-card-stack-title">
      <h2>Executive Committee</h2>
    </div>
    <div class="person-card-stack-list container-row">
      @forelse($executives as $member)
        <div class="container-col-3">
          <div class="person-card-widget">
            <div class="person-card-image-wrapper">
              <img class="person-card-image"
                   src="{{ $member->photo ? asset('storage/'.$member->photo) : asset('images/club/default-avatar.png') }}"
                   alt="{{ $member->name }}"
                   onerror="this.src='{{ asset('template/site-assets/images/logo.png') }}'">
            </div>
            <div class="person-card-info">
              <p class="person-card-name">{{ $member->name }}</p>
              <p class="person-card-designation">{{ $member->designation }}</p>
              @if($member->phone)
                <p class="person-card-phone"><i class="ph ph-phone"></i> {{ $member->phone }}</p>
              @endif
            </div>
          </div>
        </div>
      @empty
        <p style="padding:16px; color:#666;">Committee information will be updated soon.</p>
      @endforelse
    </div>
  </section>
</div>

{{-- Photo Gallery --}}
<div style="background:var(--color-normal-light); padding:var(--spacing-large) 0; margin-top:var(--spacing-large);">
  <div style="max-width:var(--container-large); margin:0 auto; padding:0 var(--spacing-medium);">
    <section class="widget home-photo-slider-widget">
      <div class="home-photo-slider-header">
        <h2 style="color:var(--color-primary-bg); margin:0 0 var(--spacing-medium) 0;">Photo Gallery</h2>
      </div>
      <div class="home-photo-slider-list container-row">
        @forelse($galleryPhotos as $photo)
          <div class="container-col-3" style="margin-bottom:var(--spacing-medium);">
            <a href="{{ asset('storage/'.$photo->path) }}" target="_blank">
              <img src="{{ asset('storage/'.$photo->thumbnail ?? $photo->path) }}"
                   alt="{{ $photo->caption ?? 'CPRC Photo' }}"
                   style="width:100%;height:180px;object-fit:cover;border-radius:var(--radius-small);box-shadow:var(--shadow-small);">
            </a>
            @if($photo->caption)
              <p style="font-size:var(--text-small); margin:4px 0 0; text-align:center;">{{ $photo->caption }}</p>
            @endif
          </div>
        @empty
          <p style="padding:16px; color:#666;">Gallery photos will be added soon.</p>
        @endforelse
      </div>
      <div class="all-btn" style="margin-top:var(--spacing-medium);">
        <a href="{{ route('gallery.index') }}">View Full Gallery <i class="ph ph-arrow-right"></i></a>
      </div>
    </section>
  </div>
</div>

@endsection
