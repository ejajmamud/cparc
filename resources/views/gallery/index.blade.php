@extends('layouts.app')

@section('title', app()->getLocale() === 'bn' ? 'ফটো গ্যালারি | চট্টগ্রাম বন্দর রিপাবলিক ক্লাব' : 'Gallery | Chittagong Port Republic Club')

@push('styles')
<style>
/* ── Gallery Grid ── */
.gallery-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:12px; }
.gallery-item { position:relative; border-radius:8px; overflow:hidden; cursor:pointer; background:#111; aspect-ratio:4/3; }
.gallery-item img,.gallery-item video { width:100%; height:100%; object-fit:cover; display:block; transition:transform .25s,opacity .25s; }
.gallery-item:hover img,.gallery-item:hover video { transform:scale(1.05); opacity:.85; }
.gallery-item .play-badge { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; pointer-events:none; }
.gallery-item .play-badge i { font-size:2.8rem; color:#fff; filter:drop-shadow(0 2px 6px rgba(0,0,0,.7)); }
.gallery-item .caption-overlay { position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent,rgba(0,0,0,.65)); color:#fff; font-size:.75rem; padding:20px 8px 6px; opacity:0; transition:opacity .2s; }
.gallery-item:hover .caption-overlay { opacity:1; }

/* ── Lightbox ── */
#glb { display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,.95); flex-direction:column; }
#glb.open { display:flex; }
#glb-header { display:flex; align-items:center; justify-content:space-between; padding:10px 16px; color:#fff; flex-shrink:0; }
#glb-caption { font-size:.9rem; opacity:.8; flex:1; text-align:center; }
#glb-close { background:none; border:none; color:#fff; font-size:1.8rem; cursor:pointer; padding:4px 10px; line-height:1; }
#glb-main { flex:1; display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden; min-height:0; }
#glb-main img,#glb-main video { max-width:calc(100% - 100px); max-height:100%; border-radius:6px; object-fit:contain; display:none; }
#glb-main img.active,#glb-main video.active { display:block; }
.glb-arrow { position:absolute; top:50%; transform:translateY(-50%); background:rgba(255,255,255,.15); border:none; color:#fff; font-size:1.8rem; padding:12px 14px; cursor:pointer; border-radius:50%; line-height:1; transition:background .2s; z-index:2; }
.glb-arrow:hover { background:rgba(255,255,255,.3); }
#glb-prev { left:12px; }
#glb-next { right:12px; }
#glb-counter { position:absolute; top:8px; right:12px; background:rgba(0,0,0,.5); color:#fff; font-size:.75rem; padding:3px 8px; border-radius:12px; }

/* ── Thumbnail strip ── */
#glb-strip { flex-shrink:0; background:rgba(0,0,0,.6); padding:8px 12px; display:flex; gap:6px; overflow-x:auto; scrollbar-width:thin; scrollbar-color:rgba(255,255,255,.3) transparent; }
#glb-strip::-webkit-scrollbar { height:4px; }
#glb-strip::-webkit-scrollbar-thumb { background:rgba(255,255,255,.3); border-radius:2px; }
.strip-thumb { flex-shrink:0; width:64px; height:48px; border-radius:4px; overflow:hidden; cursor:pointer; border:2px solid transparent; opacity:.6; transition:opacity .15s,border-color .15s; position:relative; }
.strip-thumb:hover,.strip-thumb.active { opacity:1; border-color:#fff; }
.strip-thumb img,.strip-thumb video { width:100%; height:100%; object-fit:cover; display:block; pointer-events:none; }
.strip-thumb .sv { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; }
.strip-thumb .sv i { font-size:1.1rem; color:#fff; filter:drop-shadow(0 1px 3px rgba(0,0,0,.8)); }
</style>
@endpush

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-images"></i> {{ app()->getLocale() === 'bn' ? 'ফটো গ্যালারি' : 'Photo Gallery' }}
  </h1>

  {{-- Album filter --}}
  @if($albums->count())
    <div style="display:flex; gap:8px; margin-bottom:var(--spacing-large); flex-wrap:wrap;">
      <a href="{{ route('gallery.index') }}"
         style="padding:6px 16px; border-radius:20px; text-decoration:none; font-size:var(--text-small); background:{{ !request('album') ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ !request('album') ? '#fff' : 'inherit' }}; font-weight:500;">
        {{ app()->getLocale() === 'bn' ? 'সব' : 'All' }}
      </a>
      @foreach($albums as $album)
        <a href="{{ route('gallery.index', ['album' => $album->id]) }}"
           style="padding:6px 16px; border-radius:20px; text-decoration:none; font-size:var(--text-small); background:{{ request('album') == $album->id ? 'var(--color-primary-bg)' : 'var(--color-normal-dark)' }}; color:{{ request('album') == $album->id ? '#fff' : 'inherit' }}; font-weight:500;">
          {{ $album->name }}
        </a>
      @endforeach
    </div>
  @endif

  @php
    $videoExts = ['mp4','webm','mov','ogg','avi'];
    function isVideo($path) {
        global $videoExts;
        return in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), $videoExts);
    }
    $mediaItems = $photos->map(function($p) {
        $src = (str_starts_with($p->path,'images/') || str_starts_with($p->path,'http')) ? asset($p->path) : asset('storage/'.$p->path);
        $thumb = $p->thumbnail ? asset('storage/'.$p->thumbnail) : $src;
        $type = in_array(strtolower(pathinfo($p->path, PATHINFO_EXTENSION)), ['mp4','webm','mov','ogg','avi']) ? 'video' : 'image';
        return ['src'=>$src,'thumb'=>$thumb,'caption'=>$p->caption,'type'=>$type];
    });
  @endphp

  {{-- Grid --}}
  <div class="gallery-grid" id="galleryGrid">
    @forelse($mediaItems as $idx => $item)
      <div class="gallery-item" data-idx="{{ $idx }}" onclick="glbOpen({{ $idx }})">
        @if($item['type'] === 'video')
          <video src="{{ $item['src'] }}" preload="none" muted playsinline></video>
          <div class="play-badge"><i class="ph ph-play-circle"></i></div>
        @else
          <img src="{{ $item['thumb'] }}" alt="{{ $item['caption'] ?? '' }}" loading="lazy" decoding="async">
        @endif
        @if($item['caption'])
          <div class="caption-overlay">{{ $item['caption'] }}</div>
        @endif
      </div>
    @empty
      <div style="padding:48px; text-align:center; color:#666; grid-column:1/-1;">
        <i class="ph ph-images" style="font-size:48px; display:block; margin-bottom:8px;"></i>
        {{ app()->getLocale() === 'bn' ? 'বর্তমানে কোনো ছবি উপলব্ধ নেই।' : 'No photos available yet.' }}
      </div>
    @endforelse
  </div>

  @if($photos->hasPages())
    <div style="margin-top:var(--spacing-large);">{{ $photos->links() }}</div>
  @endif
</div>

{{-- ── Lightbox ── --}}
<div id="glb" role="dialog" aria-modal="true">
  <div id="glb-header">
    <div style="width:80px;"></div>
    <div id="glb-caption"></div>
    <button id="glb-close" aria-label="Close" onclick="glbClose()"><i class="ph ph-x"></i></button>
  </div>

  <div id="glb-main">
    <button class="glb-arrow" id="glb-prev" onclick="glbNav(-1)" aria-label="Previous"><i class="ph ph-caret-left"></i></button>
    <img id="glb-img" src="" alt="">
    <video id="glb-vid" src="" controls playsinline></video>
    <div id="glb-counter"></div>
    <button class="glb-arrow" id="glb-next" onclick="glbNav(1)" aria-label="Next"><i class="ph ph-caret-right"></i></button>
  </div>

  <div id="glb-strip"></div>
</div>

@push('scripts')
<script>
(function(){
  const items = @json($mediaItems->values());
  let cur = 0;
  const lb    = document.getElementById('glb');
  const img   = document.getElementById('glb-img');
  const vid   = document.getElementById('glb-vid');
  const strip = document.getElementById('glb-strip');
  const cap   = document.getElementById('glb-caption');
  const ctr   = document.getElementById('glb-counter');

  // Build thumbnail strip once
  items.forEach((item, i) => {
    const t = document.createElement('div');
    t.className = 'strip-thumb';
    t.dataset.idx = i;
    t.onclick = () => glbShow(i);
    if (item.type === 'video') {
      t.innerHTML = `<video src="${item.src}" muted preload="none"></video><div class="sv"><i class="ph ph-play-circle"></i></div>`;
    } else {
      t.innerHTML = `<img src="${item.thumb}" loading="lazy" alt="">`;
    }
    strip.appendChild(t);
  });

  window.glbOpen = function(idx) {
    lb.classList.add('open');
    document.body.style.overflow = 'hidden';
    glbShow(idx);
  };

  window.glbClose = function() {
    lb.classList.remove('open');
    document.body.style.overflow = '';
    vid.pause(); vid.src = '';
  };

  window.glbNav = function(dir) {
    glbShow((cur + dir + items.length) % items.length);
  };

  function glbShow(idx) {
    cur = idx;
    const item = items[idx];
    vid.pause();

    if (item.type === 'video') {
      img.classList.remove('active'); img.src = '';
      vid.src = item.src; vid.classList.add('active');
    } else {
      vid.classList.remove('active'); vid.src = '';
      img.src = item.src; img.classList.add('active');
    }

    cap.textContent = item.caption || '';
    ctr.textContent = `${idx+1} / ${items.length}`;

    // Update thumbnail strip highlight + scroll into view
    strip.querySelectorAll('.strip-thumb').forEach((t,i) => {
      t.classList.toggle('active', i === idx);
      if (i === idx) t.scrollIntoView({behavior:'smooth',block:'nearest',inline:'center'});
    });
  }

  // Keyboard nav
  document.addEventListener('keydown', e => {
    if (!lb.classList.contains('open')) return;
    if (e.key === 'ArrowRight') glbNav(1);
    else if (e.key === 'ArrowLeft') glbNav(-1);
    else if (e.key === 'Escape') glbClose();
  });

  // Click backdrop to close
  lb.addEventListener('click', e => { if (e.target === lb) glbClose(); });
})();
</script>
@endpush
@endsection
