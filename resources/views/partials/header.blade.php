<section class="widget header-widget-section">
  <div class="header-left-section">
    <a class="header-title" href="{{ url('/') }}" title="{{ __('site.club_name') }}">
      {{ __('site.club_name') }}
    </a>
  </div>
  <div class="header-right-tools">
    <span class="header-clock" id="clock"></span>
    <a href="{{ route('notices.index') }}" class="header-icon-link" title="{{ __('site.notices') }}">
      <i class="ph ph-bell"></i>
    </a>
    <a href="{{ route('packages.index') }}" class="header-book-btn">
      <i class="ph ph-calendar-check"></i> {{ __('site.book_now') }}
    </a>
    {{-- Language Switcher --}}
    <div class="lang-switcher">
      <a href="{{ route('lang.switch', 'bn') }}"
         class="lang-btn {{ app()->getLocale() === 'bn' ? 'lang-active' : '' }}">বাংলা</a>
      <span class="lang-sep">|</span>
      <a href="{{ route('lang.switch', 'en') }}"
         class="lang-btn {{ app()->getLocale() === 'en' ? 'lang-active' : '' }}">EN</a>
    </div>
  </div>
</section>

<script>
  (function(){
    var el = document.getElementById('clock');
    if (!el) return;
    function tick() {
      el.textContent = new Date().toLocaleTimeString('{{ app()->getLocale() === 'bn' ? 'bn-BD' : 'en-US' }}', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
    }
    tick(); setInterval(tick, 1000);
  })();
</script>
