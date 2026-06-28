<section class="widget menus-expandable-widget max-view">
  <div class="menus-widget-container" style="--home-label:'Home';">
    <section class="widget menu-widget">
      {{-- Standalone Mobile Nav Bar --}}
      <div class="cprc-mobile-nav-bar">
        <a href="{{ url('/') }}" class="cprc-mobile-brand">
          <img src="{{ asset('images/club/logo.jpeg') }}" alt="Logo" class="cprc-mobile-logo">
          <span class="cprc-mobile-title">{{ app()->getLocale() === 'bn' ? 'সিপিআরসি' : 'CPRC' }}</span>
        </a>
        <div class="cprc-mobile-right">
          {{-- Language Switcher for Mobile --}}
          <div class="mobile-lang-switcher">
            <a href="{{ route('lang.switch', 'bn') }}" class="mobile-lang-btn {{ app()->getLocale() === 'bn' ? 'active' : '' }}">বাংলা</a>
            <span class="lang-sep">|</span>
            <a href="{{ route('lang.switch', 'en') }}" class="mobile-lang-btn {{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
          </div>
          {{-- Hamburger Toggle Icon --}}
          <span id="menu-toggle" class="hamburger-menu-block">
            <i class="ph ph-list hamburger-icon"></i>
          </span>
        </div>
      </div>

      <ul class="menu-list menu-parent-unordered-list cprc-nav-center">

        @if(!request()->routeIs('home'))
        <li class="nav-logo-item">
          <a href="{{ url('/') }}" title="{{ __('site.club_name') }}" style="display: flex; align-items: center;">
            <img src="{{ asset('images/club/logo.jpeg') }}" alt="Logo" class="nav-logo-img">
          </a>
        </li>
        @endif
        <li class="megamenu-link">
          <a class="menu-parent-list-link home-link-vector" href="{{ url('/') }}" title="{{ __('site.home') }}" style="display: flex; align-items: center; justify-content: center; height: 100%; padding: 0 16px;">
            <i class="ph ph-house" style="font-size: 20px; color: #ffffff;"></i>
          </a>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="{{ __('site.about') }}" href="#" class="menu-parent-list-link">
            {{ __('site.about') }} <icon class="menu-parent-list-link-icon ph ph-caret-double-down"></icon>
          </a>
          <div class="mega-menu-dropdown megaMenu">
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>{{ app()->getLocale() === 'bn' ? 'ক্লাব তথ্য' : 'Club Information' }}</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('about') }}"><div>{{ app()->getLocale() === 'bn' ? 'ইতিহাস ও পটভূমি' : 'History & Background' }}</div></a></li>
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('about') }}#mission"><div>{{ app()->getLocale() === 'bn' ? 'লক্ষ্য ও উদ্দেশ্য' : 'Mission & Vision' }}</div></a></li>
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('about') }}#facilities"><div>{{ app()->getLocale() === 'bn' ? 'সুযোগ-সুবিধা' : 'Facilities' }}</div></a></li>
              </ul>
            </div>
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>{{ app()->getLocale() === 'bn' ? 'নেতৃত্ব' : 'Leadership' }}</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('members.index') }}"><div>{{ __('site.members') }}</div></a></li>
              </ul>
            </div>
          </div>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="{{ __('site.packages') }}" href="{{ route('packages.index') }}" class="menu-parent-list-link">
            {{ __('site.packages') }} <icon class="menu-parent-list-link-icon ph ph-caret-double-down"></icon>
          </a>
          <div class="mega-menu-dropdown megaMenu">
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>{{ app()->getLocale() === 'bn' ? 'বুকিং প্যাকেজ' : 'Booking Packages' }}</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('packages.index') }}"><div>{{ app()->getLocale() === 'bn' ? 'সকল প্যাকেজ দেখুন' : 'View All Packages' }}</div></a></li>
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('booking.form') }}"><div>{{ app()->getLocale() === 'bn' ? 'হল বুক করুন' : 'Book the Hall' }}</div></a></li>
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('contact') }}"><div>{{ app()->getLocale() === 'bn' ? 'বুকিং অনুসন্ধান' : 'Booking Enquiry' }}</div></a></li>
              </ul>
            </div>
          </div>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="{{ __('site.notices') }}" href="{{ route('notices.index') }}" class="menu-parent-list-link">
            {{ __('site.notices') }} <icon class="menu-parent-list-link-icon ph ph-caret-double-down"></icon>
          </a>
          <div class="mega-menu-dropdown megaMenu">
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>{{ app()->getLocale() === 'bn' ? 'বিজ্ঞপ্তি' : 'Official Notices' }}</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('notices.index') }}?type=general"><div>{{ app()->getLocale() === 'bn' ? 'সাধারণ বিজ্ঞপ্তি' : 'General Notices' }}</div></a></li>
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('notices.index') }}?type=tender"><div>{{ app()->getLocale() === 'bn' ? 'দরপত্র' : 'Tenders' }}</div></a></li>
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('notices.index') }}?type=recruitment"><div>{{ app()->getLocale() === 'bn' ? 'নিয়োগ' : 'Recruitment' }}</div></a></li>
              </ul>
            </div>
          </div>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="{{ __('site.events') }}" href="{{ route('events.index') }}" class="menu-parent-list-link">
            {{ __('site.events') }} <icon class="menu-parent-list-link-icon ph ph-caret-double-down"></icon>
          </a>
          <div class="mega-menu-dropdown megaMenu">
            <div class="menu-child-box">
              <h6 class="menu-child-title"><a href="#"><div>{{ app()->getLocale() === 'bn' ? 'অনুষ্ঠান' : 'Club Events' }}</div></a></h6>
              <ul class="menu-sub-child-unordered-list">
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('events.index') }}?type=upcoming"><div>{{ app()->getLocale() === 'bn' ? 'আসন্ন অনুষ্ঠান' : 'Upcoming Events' }}</div></a></li>
                <li class="menu-sub-child-list"><a class="menu-sub-child-link" href="{{ route('events.index') }}?type=past"><div>{{ app()->getLocale() === 'bn' ? 'অতীত অনুষ্ঠান' : 'Past Events' }}</div></a></li>
              </ul>
            </div>
          </div>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="{{ __('site.gallery') }}" href="{{ route('gallery.index') }}" class="menu-parent-list-link">
            {{ __('site.gallery') }}
          </a>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="{{ __('site.news') }}" href="{{ route('news.index') }}" class="menu-parent-list-link">
            {{ __('site.news') }}
          </a>
        </li>

        <li class="megamenu-link menu-parent-list">
          <a title="{{ __('site.contact') }}" href="{{ route('contact') }}" class="menu-parent-list-link">
            {{ __('site.contact') }}
          </a>
        </li>

      </ul>
    </section>
  </div>
</section>

{{-- Mobile Sidebar Drawer --}}
<div class="cprc-mobile-drawer" id="mobile-drawer">
  <div class="cprc-drawer-header">
    <a href="{{ url('/') }}" class="cprc-drawer-brand">
      <img src="{{ asset('images/club/logo.jpeg') }}" alt="Logo" class="cprc-drawer-logo">
      <span class="cprc-drawer-title">{{ app()->getLocale() === 'bn' ? 'সিপিআরসি' : 'CPRC' }}</span>
    </a>
    <button class="cprc-drawer-close" id="drawer-close">
      <i class="ph ph-x"></i>
    </button>
  </div>
  <div class="cprc-drawer-body">
    <ul class="cprc-drawer-menu">
      <li><a href="{{ url('/') }}"><i class="ph ph-house"></i> {{ __('site.home') }}</a></li>
      <li>
        <div class="cprc-drawer-submenu-header">
          <span>{{ __('site.about') }}</span>
          <i class="ph ph-caret-down"></i>
        </div>
        <ul class="cprc-drawer-submenu">
          <li><a href="{{ route('about') }}">{{ app()->getLocale() === 'bn' ? 'ইতিহাস ও পটভূমি' : 'History & Background' }}</a></li>
          <li><a href="{{ route('about') }}#mission">{{ app()->getLocale() === 'bn' ? 'লক্ষ্য ও উদ্দেশ্য' : 'Mission & Vision' }}</a></li>
          <li><a href="{{ route('about') }}#facilities">{{ app()->getLocale() === 'bn' ? 'সুযোগ-সুবিধা' : 'Facilities' }}</a></li>
          <li><a href="{{ route('members.index') }}">{{ __('site.members') }}</a></li>
        </ul>
      </li>
      <li>
        <div class="cprc-drawer-submenu-header">
          <span>{{ __('site.packages') }}</span>
          <i class="ph ph-caret-down"></i>
        </div>
        <ul class="cprc-drawer-submenu">
          <li><a href="{{ route('packages.index') }}">{{ app()->getLocale() === 'bn' ? 'সকল প্যাকেজ' : 'View All Packages' }}</a></li>
          <li><a href="{{ route('booking.form') }}">{{ app()->getLocale() === 'bn' ? 'হল বুক করুন' : 'Book the Hall' }}</a></li>
          <li><a href="{{ route('contact') }}">{{ app()->getLocale() === 'bn' ? 'বুকিং অনুসন্ধান' : 'Booking Enquiry' }}</a></li>
        </ul>
      </li>
      <li>
        <div class="cprc-drawer-submenu-header">
          <span>{{ __('site.notices') }}</span>
          <i class="ph ph-caret-down"></i>
        </div>
        <ul class="cprc-drawer-submenu">
          <li><a href="{{ route('notices.index') }}?type=general">{{ app()->getLocale() === 'bn' ? 'সাধারণ বিজ্ঞপ্তি' : 'General Notices' }}</a></li>
          <li><a href="{{ route('notices.index') }}?type=tender">{{ app()->getLocale() === 'bn' ? 'দরপত্র' : 'Tenders' }}</a></li>
          <li><a href="{{ route('notices.index') }}?type=recruitment">{{ app()->getLocale() === 'bn' ? 'নিয়োগ' : 'Recruitment' }}</a></li>
        </ul>
      </li>
      <li>
        <div class="cprc-drawer-submenu-header">
          <span>{{ __('site.events') }}</span>
          <i class="ph ph-caret-down"></i>
        </div>
        <ul class="cprc-drawer-submenu">
          <li><a href="{{ route('events.index') }}?type=upcoming">{{ app()->getLocale() === 'bn' ? 'আসন্ন অনুষ্ঠান' : 'Upcoming Events' }}</a></li>
          <li><a href="{{ route('events.index') }}?type=past">{{ app()->getLocale() === 'bn' ? 'অতীত অনুষ্ঠান' : 'Past Events' }}</a></li>
        </ul>
      </li>
      <li><a href="{{ route('gallery.index') }}">{{ __('site.gallery') }}</a></li>
      <li><a href="{{ route('news.index') }}">{{ __('site.news') }}</a></li>
      <li><a href="{{ route('contact') }}">{{ __('site.contact') }}</a></li>
    </ul>
  </div>
</div>
<div class="cprc-drawer-overlay" id="drawer-overlay"></div>

<style>
/* Mobile Drawer CSS Styles */
.cprc-mobile-drawer {
  position: fixed;
  top: 0;
  right: -310px;
  width: 300px;
  height: 100%;
  background: #ffffff;
  box-shadow: -5px 0 25px rgba(0,0,0,0.15);
  z-index: 99999;
  transition: right 0.3s ease-in-out;
  display: flex;
  flex-direction: column;
}
.cprc-mobile-drawer.open {
  right: 0;
}
.cprc-drawer-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 99998;
  display: none;
  opacity: 0;
  transition: opacity 0.3s ease-in-out;
}
.cprc-drawer-overlay.open {
  display: block;
  opacity: 1;
}
.cprc-drawer-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
  border-bottom: 1px solid #f1f3f5;
  background: #0B2545;
}
.cprc-drawer-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  text-decoration: none;
}
.cprc-drawer-logo {
  height: 36px;
  width: auto;
  border-radius: 4px;
}
.cprc-drawer-title {
  color: #ffffff;
  font-weight: 700;
  font-size: 1.1rem;
}
.cprc-drawer-close {
  background: transparent;
  border: none;
  color: #ffffff;
  font-size: 24px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}
.cprc-drawer-body {
  flex: 1;
  overflow-y: auto;
  padding: 20px;
}
.cprc-drawer-menu {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.cprc-drawer-menu li {
  margin: 0;
  padding: 0;
}
.cprc-drawer-menu li a {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  color: #333333;
  text-decoration: none;
  font-weight: 500;
  border-radius: 8px;
  transition: background 0.2s;
}
.cprc-drawer-menu li a:hover {
  background: #f1f3f5;
}
.cprc-drawer-submenu-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 12px 16px;
  color: #333333;
  font-weight: 500;
  cursor: pointer;
  border-radius: 8px;
  transition: background 0.2s;
}
.cprc-drawer-submenu-header:hover {
  background: #f1f3f5;
}
.cprc-drawer-submenu {
  list-style: none;
  padding-left: 20px;
  margin-top: 4px;
  display: none;
  flex-direction: column;
  gap: 4px;
  border-left: 2px solid #e9ecef;
}
.cprc-drawer-submenu.open {
  display: flex;
}
.cprc-drawer-submenu li a {
  font-size: 0.9rem;
  padding: 8px 12px;
  color: #555555;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const toggleBtn = document.getElementById('menu-toggle');
  const closeBtn = document.getElementById('drawer-close');
  const drawer = document.getElementById('mobile-drawer');
  const overlay = document.getElementById('drawer-overlay');

  if (toggleBtn && drawer && overlay) {
    toggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      drawer.classList.add('open');
      overlay.classList.add('open');
      overlay.style.display = 'block';
    });

    const closeDrawer = function () {
      drawer.classList.remove('open');
      overlay.classList.remove('open');
      setTimeout(() => {
        if (!overlay.classList.contains('open')) {
          overlay.style.display = 'none';
        }
      }, 300);
    };

    closeBtn.addEventListener('click', closeDrawer);
    overlay.addEventListener('click', closeDrawer);
  }

  // Handle submenu toggles inside mobile drawer
  const submenuHeaders = document.querySelectorAll('.cprc-drawer-submenu-header');
  submenuHeaders.forEach(header => {
    header.addEventListener('click', function () {
      const submenu = this.nextElementSibling;
      const icon = this.querySelector('i');
      if (submenu) {
        submenu.classList.toggle('open');
        if (icon) {
          icon.classList.toggle('ph-caret-down');
          icon.classList.toggle('ph-caret-up');
        }
      }
    });
  });
});
</script>
