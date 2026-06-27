<section class="widget header-widget-section">
  <div class="header-left-section">
    <a class="header-title" href="{{ url('/') }}" title="Chittagong Port Republic Club">
      Chittagong Port Republic Club
    </a>
  </div>
  <div class="header-left-section" style="flex:1; justify-content:flex-end; display:flex; align-items:center; gap:16px;">
    <a href="{{ route('notices.index') }}" class="header-title" style="font-size:var(--text-small);">
      <i class="ph ph-bell"></i> Notices
    </a>
    <a href="{{ route('gallery.index') }}" class="header-title" style="font-size:var(--text-small);">
      <i class="ph ph-images"></i> Gallery
    </a>
    <span class="header-title" id="clock" style="font-size:var(--text-small);"></span>
  </div>
</section>

<script>
  (function(){
    function updateClock(){
      var now = new Date();
      document.getElementById('clock').textContent = now.toLocaleTimeString('en-BD');
    }
    updateClock();
    setInterval(updateClock, 1000);
  })();
</script>
