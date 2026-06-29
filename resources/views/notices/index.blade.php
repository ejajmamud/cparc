@extends('layouts.app')

@section('title', app()->getLocale() === 'bn' ? 'বিজ্ঞপ্তি বোর্ড | চট্টগ্রাম বন্দর রিপাবলিক ক্লাব' : 'Notices | Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">
  <div class="container-row">
    <div class="container-col-8">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-file-text"></i> {{ app()->getLocale() === 'bn' ? 'অফিসিয়াল বিজ্ঞপ্তি' : 'Official Notices' }}</p>

          {{-- Filter tabs --}}
          <div style="display:flex; gap:8px; margin-bottom:var(--spacing-medium); flex-wrap:wrap;">
            <a href="{{ route('notices.index') }}"
               style="padding:4px 12px; border-radius:var(--radius-small); text-decoration:none; font-size:var(--text-small); background:{{ !request('type') ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ !request('type') ? '#fff' : 'inherit' }}; font-weight: 500;">
              {{ app()->getLocale() === 'bn' ? 'সব' : 'All' }}
            </a>
            @foreach(['general','tender','recruitment'] as $type)
              @php
                $lbl = $type;
                if(app()->getLocale() === 'bn') {
                  if($type === 'general') $lbl = 'সাধারণ';
                  elseif($type === 'tender') $lbl = 'দরপত্র';
                  elseif($type === 'recruitment') $lbl = 'নিয়োগ';
                } else {
                  $lbl = ucfirst($type);
                }
              @endphp
              <a href="{{ route('notices.index', ['type' => $type]) }}"
                 style="padding:4px 12px; border-radius:var(--radius-small); text-decoration:none; font-size:var(--text-small); background:{{ request('type') === $type ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ request('type') === $type ? '#fff' : 'inherit' }}; font-weight: 500;">
                {{ $lbl }}
              </a>
            @endforeach
          </div>

          <ul class="notice-unordered-list">
            @forelse($notices as $notice)
              <li class="notice-content-list">
                <a class="notice-link" href="{{ route('notices.show', $notice->slug) }}">
                  <div class="notice-content-icon"><i class="dot"></i></div>
                  <div class="notice-text-wrap">
                    <p title="{{ app()->getLocale() === 'bn' && $notice->title_bn ? $notice->title_bn : $notice->title }}" class="notice-text">
                      {{ app()->getLocale() === 'bn' && $notice->title_bn ? $notice->title_bn : $notice->title }}
                    </p>
                    <p class="notice-text">
                      <span class="notice-tag"><i class="ph ph-calendar-dots"></i> {{ $notice->published_at->format('d-m-Y') }}</span>
                      @if($notice->is_new)
                        <strong class="notice-tag">{{ app()->getLocale() === 'bn' ? 'নতুন' : 'New' }}</strong>
                      @endif
                      <strong class="notice-tag">
                        @php
                          $typeLbl = $notice->type;
                          if(app()->getLocale() === 'bn') {
                            if($notice->type === 'general') $typeLbl = 'সাধারণ';
                            elseif($notice->type === 'tender') $typeLbl = 'দরপত্র';
                            elseif($notice->type === 'recruitment') $typeLbl = 'নিয়োগ';
                          } else {
                            $typeLbl = ucfirst($notice->type);
                          }
                        @endphp
                        {{ $typeLbl }}
                      </strong>
                    </p>
                  </div>
                  <div class="notice-content-icon"><i class="ph ph-caret-right"></i></div>
                </a>
              </li>
            @empty
              <li style="padding:32px; text-align:center; color:#666;">{{ app()->getLocale() === 'bn' ? 'কোনো বিজ্ঞপ্তি পাওয়া যায়নি।' : 'No notices found.' }}</li>
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
          <p class="notice-title"><i class="ph ph-calendar"></i> {{ app()->getLocale() === 'bn' ? 'সাম্প্রতিক অনুষ্ঠান' : 'Recent Events' }}</p>
          <ul class="notice-unordered-list">
            @foreach($recentEvents as $event)
              <li class="notice-content-list">
                <a class="notice-link" href="{{ route('events.show', $event->slug) }}">
                  <div class="notice-content-icon"><i class="dot"></i></div>
                  <div class="notice-text-wrap">
                    <p class="notice-text">{{ app()->getLocale() === 'bn' && $event->title_bn ? $event->title_bn : $event->title }}</p>
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
          <a href="{{ route('events.index') }}">{{ app()->getLocale() === 'bn' ? 'সব অনুষ্ঠান' : 'All Events' }} <i class="ph ph-arrow-right"></i></a>
        </div>
      </section>
    </div>
  </div>
</div>
@endsection
