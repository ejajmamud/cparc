<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', __('site.club_name'))</title>
  <meta name="description" content="@yield('description', __('site.tagline'))">

  {{-- Preconnect fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  {{-- CPRC theme variables --}}
  <style>
    html {
      --color-primary-bg: #003087;
      --color-primary-light: #1a4fa0;
      --color-primary-dark: #001e5e;
      --color-primary-text: #ffffff;
      --color-secondary-bg: #C8102E;
      --color-secondary-light: #FEF2F2;
      --color-secondary-dark: #a50d25;
      --color-secondary-text: #ffffff;
      --color-normal-bg: #ffffff;
      --color-normal-light: #f4f6f8;
      --color-normal-dark: #e0e0e0;
      --color-normal-text: #000000;
      --color-dark-bg: #1a1a2e;
      --color-dark-light: #202030;
      --color-dark-dark: #333344;
      --color-dark-text: #ffffff;
      --color-success-bg: #28a745;
      --color-danger-bg: #dc3545;
      --color-danger-text: #dc3545;
      --color-warning-bg: #FF6600;
      --color-link-normal: #1568b2;
      --color-link-dark: #1b81dd;
      --color-border-normal: #d0d0d0;
      --color-border-dark: #909090;
      --background-primary-image: url('{{ asset('template/site-assets/images/bg.png') }}');
      --background-primary-repeat: repeat;
      --background-primary-position: center center;
      --background-primary-color: #ffffff;
      --background-secondary-image: url('{{ asset('template/site-assets/images/bg.png') }}');
      --background-secondary-repeat: repeat;
      --background-secondary-position: center center;
      --background-secondary-color: #ffffff;
      --container-small: 600px;
      --container-medium: 900px;
      --container-large: 1200px;
      --spacing-small: 8px;
      --spacing-medium: 16px;
      --spacing-large: 24px;
      --radius-small: 4px;
      --radius-medium: 8px;
      --radius-large: 16px;
      --shadow-small: 0 2px 6px rgba(0,0,0,0.08);
      --shadow-medium: 0 4px 12px rgba(0,0,0,0.12);
      --shadow-large: 0 8px 24px rgba(0,0,0,0.15);
      --text-small: 0.78rem;
      --text-medium: 0.9rem;
      --text-large: 1.1rem;
      --font-primary: 'Noto Sans Bengali', 'Noto Sans', sans-serif;
      --font-heading: 'Noto Sans Bengali', 'Noto Sans', sans-serif;
      --typography-h1-font-size: 30px;
      --typography-h2-font-size: 24px;
      --typography-h3-font-size: 20px;
      --typography-body-font-size: 14px;
    }

    *, *::before, *::after { box-sizing: border-box; }
    body { overflow-x: hidden; font-family: var(--font-primary); font-size: 14px; line-height: 1.5; background: #f4f6f8; }
    a {
      color: inherit;
      text-decoration: none;
      transition: color 0.2s ease, opacity 0.2s ease;
    }
    a:hover {
      text-decoration: none;
      opacity: 0.8;
    }
    
    /* Modern Nav menu hovers without underline */
    .menu-widget a, 
    .menu-widget a:hover, 
    .menu-widget a div,
    .menu-widget a div:hover,
    .menus-expandable-widget a, 
    .menus-expandable-widget a:hover,
    .menus-expandable-widget a div:hover,
    .menu-parent-list-link,
    .menu-parent-list-link:hover,
    .menu-sub-child-link,
    .menu-sub-child-link:hover,
    .menu-sub-child-link div,
    .menu-sub-child-link div:hover {
      text-decoration: none !important;
    }

    .container-row, .widget-container-row {
      --col-gutter-x: var(--spacing-medium);
      --col-gutter-y: 0;
      display: flex; flex-wrap: wrap;
      margin-right: calc(-.5 * var(--col-gutter-x));
      margin-left: calc(-.5 * var(--col-gutter-x));
    }
    .container-row > *, .widget-container-row > * {
      box-sizing: border-box; flex-shrink: 0; width: 100%; max-width: 100%;
      padding-right: calc(var(--col-gutter-x) * .5);
      padding-left: calc(var(--col-gutter-x) * .5);
    }
    @media (min-width: 600px) {
      .container-col-1  { width:  8.333%; } .container-col-2  { width: 16.666%; }
      .container-col-3  { width: 25%; }     .container-col-4  { width: 33.333%; }
      .container-col-5  { width: 41.666%; } .container-col-6  { width: 50%; }
      .container-col-7  { width: 58.333%; } .container-col-8  { width: 66.666%; }
      .container-col-9  { width: 75%; }     .container-col-10 { width: 83.333%; }
      .container-col-11 { width: 91.666%; } .container-col-12 { width: 100%; }
    }
  </style>

  {{-- Template widget CSS --}}
  <link rel="stylesheet" href="{{ asset('template/site-assets/css/phosphor.css') }}">
  <link rel="stylesheet" href="{{ asset('template/site-assets/css/phosphor-fill.css') }}">
  <link rel="stylesheet" href="{{ asset('template/site-assets/css/index.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/HeaderWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/BannerSliderImageWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/MenusExpandableWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/MenusWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/NoticeNewsCardWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/TopNewsCardWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/HomePhotoSliderWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/ServiceBoxWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/ServiceBoxStackWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/AccessibilityWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/GoToTopWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/PersonCardWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/PersonCardStackWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/ImportantLinkCardWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/SocialMediaCardWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/FooterWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/PhotoGalleryWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/BlockWidget.css') }}">

  {{-- CPRC custom --}}
  <link rel="stylesheet" href="{{ asset('css/cparc.css') }}">
  <link rel="stylesheet" href="{{ asset('css/cparc-mobile.css') }}">

  @stack('styles')

  {{-- Favicon --}}
  <link rel="icon" type="image/jpeg" href="{{ asset('images/club/logo.jpeg') }}">
  <link rel="apple-touch-icon" href="{{ asset('images/club/logo.jpeg') }}">
</head>
<body>

<div class="container">

  {{-- Top header bar --}}
  @include('partials.header')

  {{-- Hero banner --}}
  @yield('banner')

  {{-- Navigation --}}
  @include('partials.nav')

  {{-- Main content --}}
  <main>
    @yield('content')
  </main>

  {{-- Footer --}}
  @include('partials.footer')

</div>

{{-- WhatsApp Floating Button --}}
<a href="https://wa.me/8801XXXXXXXXX?text={{ urlencode('আমি হল বুকিং সম্পর্কে জানতে চাই / I want to enquire about hall booking at CPRC') }}"
   class="cprc-whatsapp-btn" target="_blank" rel="noopener" aria-label="WhatsApp">
  <svg viewBox="0 0 24 24" fill="currentColor" width="26" height="26">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
  </svg>
  <span class="cprc-whatsapp-label">WhatsApp</span>
</a>

{{-- Go to top --}}
<div class="go-to-top-btn" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Go to top">
  <i class="ph ph-arrow-up"></i>
</div>

{{-- Widget JS --}}
<script src="{{ asset('template/widget-assets/js/BannerSliderImageWidget') }}"></script>
<script src="{{ asset('template/widget-assets/js/MenusExpandableWidget') }}"></script>
<script src="{{ asset('template/widget-assets/js/AccessibilityWidget') }}"></script>
<script src="{{ asset('template/widget-assets/js/GoToTopWidget') }}"></script>
<script src="{{ asset('template/widget-assets/js/NoticeNewsCardWidget') }}"></script>
<script src="{{ asset('template/widget-assets/js/HomePhotoSliderWidget') }}"></script>

@stack('scripts')

</body>
</html>
