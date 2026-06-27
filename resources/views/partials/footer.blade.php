<footer class="widget footer-widget">
  <div class="footer-widget-image"></div>
  <div class="footer-body">
    <div>
      <ul class="left-ul">
        <li class="left-ul-list">
          <a class="footer-link" href="{{ route('about') }}">About Us</a>
        </li>
        <li class="left-ul-list">
          <a class="footer-link" href="{{ route('contact') }}">Contact</a>
        </li>
        <li class="left-ul-list">
          <a class="footer-link" href="{{ route('notices.index') }}">Notices</a>
        </li>
        <li class="left-ul-list">
          <a class="footer-link" href="{{ route('gallery.index') }}">Gallery</a>
        </li>
        <li class="left-ul-list">
          <a class="footer-link" href="#">Privacy Policy</a>
        </li>
      </ul>
      <div class="site-update-block">
        <p>Chittagong Port Republic Club &copy; {{ date('Y') }}. All rights reserved.</p>
        <p>Port Area, Chittagong, Bangladesh</p>
      </div>
    </div>
    <div class="text-xs">
      <div class="technical-support-block">
        <img class="technical-support-image" src="{{ asset('images/club/logo.png') }}"
             alt="CPRC Logo"
             onerror="this.style.display='none'"
             style="max-height:60px;object-fit:contain;">
      </div>
    </div>
  </div>
</footer>
