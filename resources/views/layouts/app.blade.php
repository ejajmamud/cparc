<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Chittagong Port Republic Club')</title>
  <meta name="description" content="@yield('description', 'Official website of Chittagong Port Republic Club')">

  {{-- CPRC theme variable overrides --}}
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
      --color-normal-light: #f0f0f0;
      --color-normal-dark: #e0e0e0;
      --color-normal-text: #000000;
      --color-dark-bg: #000000;
      --color-dark-light: #202020;
      --color-dark-dark: #404040;
      --color-dark-text: #ffffff;
      --color-success-bg: #28a745;
      --color-success-text: #ffffff;
      --color-danger-bg: #dc3545;
      --color-danger-text: #dc3545;
      --color-warning-bg: #FF6600;
      --color-warning-text: #FF6600;
      --color-info-bg: #17a2b8;
      --color-info-text: #ffffff;
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
      --shadow-small: 0px 2px 4px rgba(0, 0, 0, 0.1);
      --shadow-medium: 0px 4px 8px rgba(0, 0, 0, 0.1);
      --shadow-large: 0px 8px 16px rgba(0, 0, 0, 0.1);
      --text-small: 0.75rem;
      --text-medium: 0.9rem;
      --text-large: 1.25rem;
      --font-heading: 'Noto Sans Bengali', sans-serif;
      --font-primary: 'Noto Sans Bengali', sans-serif;
      --font-secondary: 'Noto Sans Bengali', sans-serif;
      --typography-h1-font-family: var(--font-heading);
      --typography-h1-font-weight: 700;
      --typography-h1-font-size: 32px;
      --typography-h1-line-height: 1.2;
      --typography-h2-font-family: var(--font-heading);
      --typography-h2-font-weight: 700;
      --typography-h2-font-size: 28px;
      --typography-h2-line-height: 1.2;
      --typography-h3-font-family: var(--font-heading);
      --typography-h3-font-weight: 600;
      --typography-h3-font-size: 24px;
      --typography-h3-line-height: 1.5;
      --typography-body-font-family: var(--font-primary);
      --typography-body-font-weight: 400;
      --typography-body-font-size: 14px;
      --typography-body-line-height: 1.2;
      --typography-p-font-family: var(--font-primary);
      --typography-p-font-weight: 400;
      --typography-p-font-size: 14px;
      --typography-p-line-height: 1.2;
      --typography-a-font-size: 14px;
      --typography-a-line-height: 1.2;
    }

    body { overflow-x: hidden; font-family: var(--font-primary); }
    .col { flex: 0 0 auto; }
    .container-row, .widget-container-row {
      --col-gutter-x: var(--spacing-medium);
      --col-gutter-y: 0;
      display: flex;
      flex-wrap: wrap;
      margin-top: calc(-1 * var(--col-gutter-y));
      margin-right: calc(-.5 * var(--col-gutter-x));
      margin-left: calc(-.5 * var(--col-gutter-x));
    }
    .container-row > *, .widget-container-row > * {
      box-sizing: border-box;
      flex-shrink: 0;
      width: 100%;
      max-width: 100%;
      padding-right: calc(var(--col-gutter-x) * .5);
      padding-left: calc(var(--col-gutter-x) * .5);
      margin-top: var(--col-gutter-y);
    }
    @media (min-width: 600px) {
      .container-col-1  { width: 8.3333%; }
      .container-col-2  { width: 16.666%; }
      .container-col-3  { width: 25%; }
      .container-col-4  { width: 33.333%; }
      .container-col-5  { width: 41.666%; }
      .container-col-6  { width: 50%; }
      .container-col-7  { width: 58.333%; }
      .container-col-8  { width: 66.666%; }
      .container-col-9  { width: 75%; }
      .container-col-10 { width: 83.333%; }
      .container-col-11 { width: 91.666%; }
      .container-col-12 { width: 100%; }
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
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/SocialLinkMediaWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/FooterWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/PhotoGalleryWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/EventCalendarWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/EmergencyHotlineListCardWidget.css') }}">
  <link rel="stylesheet" href="{{ asset('template/widget-assets/css/BlockWidget.css') }}">

  {{-- CPRC custom overrides --}}
  <link rel="stylesheet" href="{{ asset('css/cparc.css') }}">

  @stack('styles')

  <link rel="icon" type="image/png" href="{{ asset('images/club/favicon.png') }}">
</head>
<body>

<div class="container">

  {{-- Top header bar --}}
  @include('partials.header')

  {{-- Hero banner + logo overlay --}}
  @yield('banner')

  {{-- Mega-menu navigation --}}
  @include('partials.nav')

  {{-- Main content --}}
  <main>
    @yield('content')
  </main>

  {{-- Footer --}}
  @include('partials.footer')

</div>

{{-- Accessibility / go-to-top widgets --}}
<section class="widget accessibility-widget">
  <div class="accessibility-btn">
    <i class="ph ph-universal-access"></i>
  </div>
</section>

<div class="go-to-top-btn" onclick="window.scrollTo({top:0,behavior:'smooth'})">
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
