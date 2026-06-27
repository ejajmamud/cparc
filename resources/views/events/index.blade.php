@extends('layouts.app')

@section('title', 'Events | Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">
  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-calendar-star"></i> Events
  </h1>

  <div style="display:flex; gap:8px; margin-bottom:var(--spacing-large); flex-wrap:wrap;">
    <a href="{{ route('events.index') }}"
       style="padding:6px 16px; border-radius:20px; text-decoration:none; font-size:var(--text-small); background:{{ !request('type') ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ !request('type') ? '#fff' : 'inherit' }};">All</a>
    <a href="{{ route('events.index', ['type' => 'upcoming']) }}"
       style="padding:6px 16px; border-radius:20px; text-decoration:none; font-size:var(--text-small); background:{{ request('type') === 'upcoming' ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ request('type') === 'upcoming' ? '#fff' : 'inherit' }};">Upcoming</a>
    <a href="{{ route('events.index', ['type' => 'past']) }}"
       style="padding:6px 16px; border-radius:20px; text-decoration:none; font-size:var(--text-small); background:{{ request('type') === 'past' ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ request('type') === 'past' ? '#fff' : 'inherit' }};">Past</a>
  </div>

  <div class="container-row">
    @forelse($events as $event)
      <div class="container-col-4" style="margin-bottom:var(--spacing-large);">
        <article class="notice-news-card-widget" style="height:100%;">
          @if($event->image)
            <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}"
                 style="width:100%; height:160px; object-fit:cover; border-radius:var(--radius-small) var(--radius-small) 0 0;">
          @endif
          <div style="padding:var(--spacing-medium);">
            <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
              <span style="background:var(--color-primary-bg); color:#fff; border-radius:var(--radius-small); padding:4px 10px; font-size:var(--text-small);">
                {{ $event->event_date->format('d M Y') }}
              </span>
              @if($event->event_date->isFuture())
                <span style="background:#d4edda; color:#155724; border-radius:var(--radius-small); padding:4px 10px; font-size:var(--text-small);">Upcoming</span>
              @else
                <span style="background:var(--color-normal-dark); color:#555; border-radius:var(--radius-small); padding:4px 10px; font-size:var(--text-small);">Past</span>
              @endif
            </div>
            <h3 style="margin:0 0 8px; font-size:var(--typography-h4-font-size);">
              <a href="{{ route('events.show', $event->slug) }}" style="color:var(--color-dark-dark); text-decoration:none;">{{ $event->title }}</a>
            </h3>
            @if($event->venue)
              <p style="font-size:var(--text-small); color:#666; margin:0 0 8px;">
                <i class="ph ph-map-pin"></i> {{ $event->venue }}
              </p>
            @endif
            <p style="font-size:var(--typography-body-font-size); color:#555; margin:0 0 var(--spacing-medium);">
              {{ Str::limit($event->description, 100) }}
            </p>
            <a href="{{ route('events.show', $event->slug) }}" style="color:var(--color-link-normal); font-size:var(--text-small);">
              Details <i class="ph ph-arrow-right"></i>
            </a>
          </div>
        </article>
      </div>
    @empty
      <p style="padding:32px; color:#666;">No events found.</p>
    @endforelse
  </div>

  @if($events->hasPages())
    <div style="margin-top:var(--spacing-large);">{{ $events->links() }}</div>
  @endif
</div>
@endsection
