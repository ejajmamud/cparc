@extends('layouts.app')

@section('title', 'Gallery | Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-images"></i> Photo Gallery
  </h1>

  {{-- Filter by album --}}
  @if($albums->count())
    <div style="display:flex; gap:8px; margin-bottom:var(--spacing-large); flex-wrap:wrap;">
      <a href="{{ route('gallery.index') }}"
         style="padding:6px 16px; border-radius:20px; text-decoration:none; font-size:var(--text-small); background:{{ !request('album') ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ !request('album') ? '#fff' : 'inherit' }};">
        All Albums
      </a>
      @foreach($albums as $album)
        <a href="{{ route('gallery.index', ['album' => $album->id]) }}"
           style="padding:6px 16px; border-radius:20px; text-decoration:none; font-size:var(--text-small); background:{{ request('album') == $album->id ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ request('album') == $album->id ? '#fff' : 'inherit' }};">
          {{ $album->name }}
        </a>
      @endforeach
    </div>
  @endif

  <div class="container-row">
    @forelse($photos as $photo)
      <div class="container-col-3" style="margin-bottom:var(--spacing-medium);">
        <a href="{{ asset('storage/'.$photo->path) }}" target="_blank"
           style="display:block; border-radius:var(--radius-medium); overflow:hidden; box-shadow:var(--shadow-small);">
          <img src="{{ $photo->thumbnail ? asset('storage/'.$photo->thumbnail) : asset('storage/'.$photo->path) }}"
               alt="{{ $photo->caption ?? 'CPRC Photo' }}"
               style="width:100%; height:200px; object-fit:cover; display:block; transition:transform 0.2s;"
               onmouseover="this.style.transform='scale(1.03)'"
               onmouseout="this.style.transform='scale(1)'">
        </a>
        @if($photo->caption)
          <p style="font-size:var(--text-small); margin:4px 0 0; text-align:center; color:#555;">{{ $photo->caption }}</p>
        @endif
      </div>
    @empty
      <div style="padding:32px; text-align:center; color:#666; width:100%;">
        <i class="ph ph-images" style="font-size:48px; display:block; margin-bottom:8px;"></i>
        No photos available yet.
      </div>
    @endforelse
  </div>

  @if($photos->hasPages())
    <div style="margin-top:var(--spacing-large);">
      {{ $photos->links() }}
    </div>
  @endif
</div>
@endsection
