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
