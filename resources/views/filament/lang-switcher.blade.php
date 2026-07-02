@php $locale = app()->getLocale(); @endphp
<div class="flex items-center me-3" style="gap:4px;">
    <a href="{{ route('lang.switch', 'en') }}"
       style="padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; line-height:1; text-decoration:none; transition:background .15s,color .15s;
              {{ $locale === 'en' ? 'background:#3b82f6; color:#fff;' : 'background:transparent; color:#6b7280;' }}">
        EN
    </a>
    <span style="color:#d1d5db; font-size:11px; user-select:none;">|</span>
    <a href="{{ route('lang.switch', 'bn') }}"
       style="padding:4px 10px; border-radius:6px; font-size:12px; font-weight:600; line-height:1; text-decoration:none; transition:background .15s,color .15s;
              {{ $locale === 'bn' ? 'background:#3b82f6; color:#fff;' : 'background:transparent; color:#6b7280;' }}">
        বাং
    </a>
</div>
