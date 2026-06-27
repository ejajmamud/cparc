@extends('layouts.app')

@section('title', $event->title . ' | CPRC Events')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">
  <div class="container-row">
    <div class="container-col-8">
      <article style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small);">
        <a href="{{ route('events.index') }}" style="color:var(--color-link-normal); text-decoration:none; font-size:var(--text-small); display:inline-block; margin-bottom:var(--spacing-medium);">
          <i class="ph ph-arrow-left"></i> Back to Events
        </a>
        @if($event->image)
          <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}"
               style="width:100%; max-height:400px; object-fit:cover; border-radius:var(--radius-small); margin-bottom:var(--spacing-medium);">
        @endif
        <h1 style="color:var(--color-primary-bg); margin:0 0 var(--spacing-medium);">{{ $event->title }}</h1>
        <div style="display:flex; gap:16px; margin-bottom:var(--spacing-large); flex-wrap:wrap; font-size:var(--text-small); color:#555;">
          <span><i class="ph ph-calendar-dots"></i> {{ $event->event_date->format('d F Y, l') }}</span>
          @if($event->time)
            <span><i class="ph ph-clock"></i> {{ $event->time }}</span>
          @endif
          @if($event->venue)
            <span><i class="ph ph-map-pin"></i> {{ $event->venue }}</span>
          @endif
        </div>
        <div style="line-height:1.8; font-size:var(--typography-body-font-size);">
          {!! nl2br(e($event->description)) !!}
        </div>
      </article>
    </div>
    <div class="container-col-4">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-calendar-star"></i> Other Events</p>
          <ul class="notice-unordered-list">
            @foreach($otherEvents as $other)
              <li class="notice-content-list">
                <a class="notice-link" href="{{ route('events.show', $other->slug) }}">
                  <div class="notice-content-icon"><i class="dot"></i></div>
                  <div class="notice-text-wrap">
                    <p class="notice-text">{{ $other->title }}</p>
                    <p class="notice-text"><span class="notice-tag">{{ $other->event_date->format('d-m-Y') }}</span></p>
                  </div>
                  <div class="notice-content-icon"><i class="ph ph-caret-right"></i></div>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        <div class="all-btn">
          <a href="{{ route('events.index') }}">All Events <i class="ph ph-arrow-right"></i></a>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection
