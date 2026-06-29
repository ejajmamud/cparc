@extends('layouts.app')

@section('title', app()->getLocale() === 'bn' ? 'সংবাদ | চট্টগ্রাম বন্দর রিপাবলিক ক্লাব' : 'News | Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">
  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-newspaper"></i> {{ app()->getLocale() === 'bn' ? 'সর্বশেষ সংবাদ' : 'Latest News' }}
  </h1>
  <div class="container-row">
    @forelse($news as $item)
      <div class="container-col-4" style="margin-bottom:var(--spacing-large);">
        <article style="background:#fff; border-radius:var(--radius-medium); overflow:hidden; box-shadow:var(--shadow-small); height:100%;">
          @if($item->image)
            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ app()->getLocale() === 'bn' && $item->title_bn ? $item->title_bn : $item->title }}"
                 style="width:100%; height:180px; object-fit:cover;">
          @else
            <div style="width:100%; height:180px; background:var(--color-normal-light); display:flex; align-items:center; justify-content:center;">
              <i class="ph ph-newspaper" style="font-size:48px; color:var(--color-border-dark);"></i>
            </div>
          @endif
          <div style="padding:var(--spacing-medium);">
            <p style="font-size:var(--text-small); color:#666; margin:0 0 8px;">
              <i class="ph ph-calendar-dots"></i> {{ $item->published_at->format('d F Y') }}
            </p>
            <h3 style="margin:0 0 8px; font-size:var(--typography-h4-font-size);">
              <a href="{{ route('news.show', $item->slug) }}" style="color:var(--color-dark-dark); text-decoration:none;">
                {{ app()->getLocale() === 'bn' && $item->title_bn ? $item->title_bn : $item->title }}
              </a>
            </h3>
            <p style="font-size:var(--typography-body-font-size); color:#555; margin:0 0 var(--spacing-medium);">
              {{ Str::limit(strip_tags(app()->getLocale() === 'bn' && $item->content_bn ? $item->content_bn : $item->content), 120) }}
            </p>
            <a href="{{ route('news.show', $item->slug) }}" style="color:var(--color-link-normal); font-size:var(--text-small);">
              {{ app()->getLocale() === 'bn' ? 'আরও পড়ুন' : 'Read More' }} <i class="ph ph-arrow-right"></i>
            </a>
          </div>
        </article>
      </div>
    @empty
      <p style="padding:32px; color:#666;">{{ app()->getLocale() === 'bn' ? 'কোনো সংবাদ নিবন্ধ পাওয়া যায়নি।' : 'No news articles yet.' }}</p>
    @endforelse
  </div>
  @if($news->hasPages())
    <div style="margin-top:var(--spacing-large);">{{ $news->links() }}</div>
  @endif
</div>
@endsection
