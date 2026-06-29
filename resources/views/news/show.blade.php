@extends('layouts.app')

@section('title', (app()->getLocale() === 'bn' && $article->title_bn ? $article->title_bn : $article->title) . ' | CPRC News')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">
  <div class="container-row">
    <div class="container-col-8">
      <article style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small);">
        <a href="{{ route('news.index') }}" style="color:var(--color-link-normal); text-decoration:none; font-size:var(--text-small); display:inline-block; margin-bottom:var(--spacing-medium);">
          <i class="ph ph-arrow-left"></i> {{ app()->getLocale() === 'bn' ? 'সংবাদে ফিরে যান' : 'Back to News' }}
        </a>
        @if($article->image)
          <img src="{{ asset('storage/'.$article->image) }}" alt="{{ app()->getLocale() === 'bn' && $article->title_bn ? $article->title_bn : $article->title }}"
               style="width:100%; max-height:400px; object-fit:cover; border-radius:var(--radius-small); margin-bottom:var(--spacing-medium);">
        @endif
        <h1 style="color:var(--color-primary-bg); margin:0 0 var(--spacing-small);">{{ app()->getLocale() === 'bn' && $article->title_bn ? $article->title_bn : $article->title }}</h1>
        <p style="font-size:var(--text-small); color:#666; margin-bottom:var(--spacing-large);">
          <i class="ph ph-calendar-dots"></i> {{ $article->published_at->format('d F Y') }}
        </p>
        <div style="line-height:1.8; font-size:var(--typography-body-font-size);">
          {!! app()->getLocale() === 'bn' && $article->content_bn ? $article->content_bn : $article->content !!}
        </div>
      </article>
    </div>
    <div class="container-col-4">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-newspaper"></i> {{ app()->getLocale() === 'bn' ? 'আরও সংবাদ' : 'More News' }}</p>
          <ul class="notice-unordered-list">
            @foreach($recentNews as $item)
              <li class="notice-content-list">
                <a class="notice-link" href="{{ route('news.show', $item->slug) }}">
                  <div class="notice-content-icon"><i class="dot"></i></div>
                  <div class="notice-text-wrap">
                    <p class="notice-text">{{ app()->getLocale() === 'bn' && $item->title_bn ? $item->title_bn : $item->title }}</p>
                    <p class="notice-text"><span class="notice-tag"><i class="ph ph-calendar-dots"></i> {{ $item->published_at->format('d-m-Y') }}</span></p>
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
