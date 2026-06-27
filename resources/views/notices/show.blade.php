@extends('layouts.app')

@section('title', $notice->title . ' | CPRC Notices')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">
  <div class="container-row">
    <div class="container-col-8">
      <section class="widget block-widget" style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small);">
        <div style="display:flex; gap:8px; margin-bottom:var(--spacing-medium); align-items:center;">
          <a href="{{ route('notices.index') }}" style="color:var(--color-link-normal); text-decoration:none; font-size:var(--text-small);">
            <i class="ph ph-arrow-left"></i> Back to Notices
          </a>
        </div>

        <h1 style="color:var(--color-primary-bg); font-size:var(--typography-h2-font-size); margin-bottom:var(--spacing-small);">
          {{ $notice->title }}
        </h1>

        <div style="display:flex; gap:16px; margin-bottom:var(--spacing-large); font-size:var(--text-small); color:#666; flex-wrap:wrap;">
          <span><i class="ph ph-calendar-dots"></i> {{ $notice->published_at->format('d F Y') }}</span>
          <span><i class="ph ph-tag"></i> {{ ucfirst($notice->type) }}</span>
          @if($notice->is_new)
            <strong style="background:var(--color-danger-bg); color:#fff; border-radius:20px; padding:2px 12px;">New</strong>
          @endif
        </div>

        <div style="line-height:1.8; font-size:var(--typography-body-font-size);">
          {!! nl2br(e($notice->content)) !!}
        </div>

        @if($notice->attachment)
          <div style="margin-top:var(--spacing-large); padding:var(--spacing-medium); background:var(--color-normal-light); border-radius:var(--radius-small);">
            <p style="margin:0; font-size:var(--text-small);"><i class="ph ph-paperclip"></i> Attachment:</p>
            <a href="{{ asset('storage/'.$notice->attachment) }}" target="_blank"
               style="color:var(--color-link-normal); display:inline-flex; align-items:center; gap:4px; margin-top:4px;">
              <i class="ph ph-file-pdf"></i> Download Attachment
            </a>
          </div>
        @endif
      </section>
    </div>

    <div class="container-col-4">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-file-text"></i> Recent Notices</p>
          <ul class="notice-unordered-list">
            @foreach($recentNotices as $recent)
              <li class="notice-content-list">
                <a class="notice-link" href="{{ route('notices.show', $recent->slug) }}">
                  <div class="notice-content-icon"><i class="dot"></i></div>
                  <div class="notice-text-wrap">
                    <p class="notice-text">{{ $recent->title }}</p>
                    <p class="notice-text">
                      <span class="notice-tag"><i class="ph ph-calendar-dots"></i> {{ $recent->published_at->format('d-m-Y') }}</span>
                    </p>
                  </div>
                  <div class="notice-content-icon"><i class="ph ph-caret-right"></i></div>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection
