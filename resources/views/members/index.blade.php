@extends('layouts.app')

@section('title', app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটি | চট্টগ্রাম বন্দর রিপাবলিক ক্লাব' : 'Executive Committee | Chittagong Port Republic Club')

@push('styles')
<style>
  .member-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    padding: 0;
  }
  .member-card {
    background: #fff;
    border-radius: var(--radius-medium);
    overflow: hidden;
    box-shadow: var(--shadow-small);
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  .member-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
  }
  .member-img-wrap {
    background: var(--color-normal-light);
    height: 180px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .member-img-wrap img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    object-position: top center;
    display: block;
    /* Placeholder blur until loaded */
    filter: blur(6px);
    transition: filter 0.4s ease;
  }
  .member-img-wrap img.loaded {
    filter: none;
  }
  .member-info {
    padding: 12px 14px;
  }
  .member-name {
    font-weight: 700;
    font-size: 0.95rem;
    margin: 0 0 4px;
    color: var(--color-dark-bg);
    line-height: 1.3;
  }
  .member-designation {
    color: var(--color-primary-bg);
    font-size: 0.8rem;
    margin: 0 0 6px;
    line-height: 1.3;
  }
  .member-contact {
    font-size: 0.75rem;
    color: #666;
    margin: 2px 0 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
  }
</style>
@endpush

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-users"></i> {{ app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটি' : 'Executive Committee' }}
  </h1>

  @if($members->count())
    <div class="member-grid">
      @foreach($members as $i => $member)
        @php
          $imgSrc = $member->photo
            ? asset('storage/' . $member->photo)
            : asset('images/club/logo.jpeg');
          $memberName = app()->getLocale() === 'bn' && $member->name_bn ? $member->name_bn : $member->name;
          $memberDesig = app()->getLocale() === 'bn' && $member->designation_bn ? $member->designation_bn : $member->designation;
        @endphp
        <div class="member-card">
          <div class="member-img-wrap">
            <img
              {{-- First 3 load eagerly; rest lazy --}}
              src="{{ $i < 3 ? $imgSrc : asset('images/club/logo.jpeg') }}"
              data-src="{{ $imgSrc }}"
              alt="{{ $memberName }}"
              width="200"
              height="180"
              loading="{{ $i < 3 ? 'eager' : 'lazy' }}"
              decoding="async"
              class="member-photo{{ $i < 3 ? ' loaded' : '' }}"
              onerror="this.src='{{ asset('images/club/logo.jpeg') }}'; this.classList.add('loaded')"
            >
          </div>
          <div class="member-info">
            <p class="member-name">{{ $memberName }}</p>
            <p class="member-designation">{{ $memberDesig }}</p>
            @if($member->phone)
              <p class="member-contact"><i class="ph ph-phone"></i> {{ $member->phone }}</p>
            @endif
            @if($member->email)
              <p class="member-contact"><i class="ph ph-envelope"></i> {{ $member->email }}</p>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  @else
    <p style="color:#666;">{{ app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটির তথ্য শীঘ্রই আপডেট করা হবে।' : 'Executive committee information will be updated soon.' }}</p>
  @endif

</div>

@push('scripts')
<script>
(function() {
  // IntersectionObserver lazy load for member images
  if (!('IntersectionObserver' in window)) {
    // Fallback: load all immediately
    document.querySelectorAll('.member-photo[data-src]').forEach(function(img) {
      img.src = img.dataset.src;
      img.classList.add('loaded');
    });
    return;
  }

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        const img = entry.target;
        const newSrc = img.dataset.src;
        if (newSrc && img.src !== newSrc) {
          const tempImg = new Image();
          tempImg.onload = function() {
            img.src = newSrc;
            img.classList.add('loaded');
          };
          tempImg.onerror = function() {
            img.classList.add('loaded');
          };
          tempImg.src = newSrc;
        } else {
          img.classList.add('loaded');
        }
        observer.unobserve(img);
      }
    });
  }, {
    rootMargin: '200px 0px', // Start loading 200px before visible
    threshold: 0.01
  });

  document.querySelectorAll('.member-photo:not(.loaded)').forEach(function(img) {
    observer.observe(img);
  });
})();
</script>
@endpush
@endsection

