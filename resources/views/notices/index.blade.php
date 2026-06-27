@extends('layouts.app')

@section('title', 'Notices | Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">
  <div class="container-row">
    <div class="container-col-8">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-file-text"></i> Official Notices</p>

          {{-- Filter tabs --}}
          <div style="display:flex; gap:8px; margin-bottom:var(--spacing-medium); flex-wrap:wrap;">
            <a href="{{ route('notices.index') }}"
               style="padding:4px 12px; border-radius:var(--radius-small); text-decoration:none; font-size:var(--text-small); background:{{ !request('type') ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ !request('type') ? '#fff' : 'inherit' }};">
              All
            </a>
            @foreach(['general','tender','recruitment'] as $type)
              <a href="{{ route('notices.index', ['type' => $type]) }}"
                 style="padding:4px 12px; border-radius:var(--radius-small); text-decoration:none; font-size:var(--text-small); background:{{ request('type') === $type ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ request('type') === $type ? '#fff' : 'inherit' }};">
                {{ ucfirst($type) }}
              </a>
            @endforeach
          </div>

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
              <li style="padding:32px; text-align:center; color:#666;">No notices found.</li>
            @endforelse
          </ul>
        </div>
      </section>

      {{-- Pagination --}}
      @if($notices->hasPages())
        <div style="margin-top:var(--spacing-medium);">
          {{ $notices->links() }}
        </div>
      @endif
    </div>

    {{-- Sidebar --}}
    <div class="container-col-4">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-calendar"></i> Recent Events</p>
          <ul class="notice-unordered-list">
            @foreach($recentEvents as $event)
              <li class="notice-content-list">
                <a class="notice-link" href="{{ route('events.show', $event->slug) }}">
                  <div class="notice-content-icon"><i class="dot"></i></div>
                  <div class="notice-text-wrap">
                    <p class="notice-text">{{ $event->title }}</p>
                    <p class="notice-text">
                      <span class="notice-tag"><i class="ph ph-calendar-dots"></i> {{ $event->event_date->format('d-m-Y') }}</span>
                    </p>
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
