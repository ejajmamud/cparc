@extends('layouts.app')

@section('title', app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটি | চট্টগ্রাম বন্দর রিপাবলিক ক্লাব' : 'Executive Committee | Chittagong Port Republic Club')

@push('styles')
<style>
  /* Members page: remove grey body wash + widget white box so site background shows through */
  body { background-color: transparent !important; }
  main { background: transparent !important; }
  .person-card-stack-widget { background: transparent !important; }
</style>
@endpush

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-users"></i> {{ app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটি' : 'Executive Committee' }}
  </h1>

  @if($members->count())
    <section class="widget person-card-stack-widget">
      <div class="person-card-stack-list container-row">
        @foreach($members as $i => $member)
          @php
            $imgSrc = $member->photo ? asset('storage/' . $member->photo) : asset('images/club/logo.jpeg');
          @endphp
          <div class="container-col-3" style="margin-bottom:var(--spacing-large); display:flex; flex-direction:column;">
            <div class="person-card-widget"
                 style="background:#fff; border-radius:var(--radius-medium); overflow:hidden; box-shadow:var(--shadow-small); text-align:center; padding-bottom:var(--spacing-medium); display:flex; flex-direction:column; height:100%;">
              <div class="person-card-image-wrapper" style="background:transparent; height:200px; display:flex; align-items:flex-end; justify-content:center; overflow:hidden;">
                <img class="person-card-image member-photo"
                     {{-- Eager load first 3, lazy load the rest --}}
                     src="{{ $i < 3 ? $imgSrc : asset('images/club/logo.jpeg') }}"
                     data-src="{{ $imgSrc }}"
                     alt="{{ app()->getLocale() === 'bn' && $member->name_bn ? $member->name_bn : $member->name }}"
                     style="width:auto; max-width:100%; height:200px; object-fit:contain; object-position:center bottom; filter: {{ $i < 3 ? 'none' : 'blur(4px)' }}; transition: filter 0.3s ease;"
                     loading="{{ $i < 3 ? 'eager' : 'lazy' }}"
                     decoding="async"
                     onerror="this.src='{{ asset('images/club/logo.jpeg') }}'; this.style.filter='none';">
              </div>
              <div class="person-card-info" style="padding:var(--spacing-medium); display:flex; flex-direction:column; flex-grow:1;">
                <p class="person-card-name" style="font-weight:600; font-size:var(--text-large); margin:0 0 4px;">
                  {{ app()->getLocale() === 'bn' && $member->name_bn ? $member->name_bn : $member->name }}
                </p>
                <p class="person-card-designation" style="color:var(--color-primary-bg); font-size:var(--text-medium); margin:0 0 8px;">
                  {{ app()->getLocale() === 'bn' && $member->designation_bn ? $member->designation_bn : $member->designation }}
                </p>
                @if($member->phone)
                  <p style="font-size:var(--text-small); color:#555; margin:0;">
                    <i class="ph ph-phone"></i> {{ $member->phone }}
                  </p>
                @endif
                @if($member->email)
                  <p style="font-size:var(--text-small); color:#555; margin:4px 0 0;">
                    <i class="ph ph-envelope"></i> {{ $member->email }}
                  </p>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </section>
  @else
    <p style="color:#666;">{{ app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটির তথ্য শীঘ্রই আপডেট করা হবে।' : 'Executive committee information will be updated soon.' }}</p>
  @endif

</div>

@push('scripts')
<script>
(function() {
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.member-photo[data-src]').forEach(function(img) {
      img.src = img.dataset.src;
      img.style.filter = 'none';
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
            img.style.filter = 'none';
          };
          tempImg.onerror = function() {
            img.style.filter = 'none';
          };
          tempImg.src = newSrc;
        } else {
          img.style.filter = 'none';
        }
        observer.unobserve(img);
      }
    });
  }, {
    rootMargin: '250px 0px',
    threshold: 0.01
  });

  document.querySelectorAll('.member-photo[data-src]').forEach(function(img) {
    if (img.getAttribute('loading') !== 'eager') {
      observer.observe(img);
    }
  });
})();
</script>
@endpush
@endsection
