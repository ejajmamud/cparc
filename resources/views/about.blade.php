@extends('layouts.app')

@section('title', 'About Us | Chittagong Port Republic Club')
@section('description', 'Learn about the history, mission and vision of Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <div class="container-row">
    {{-- Main content --}}
    <div class="container-col-8">

      <section class="widget block-widget" style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small); margin-bottom:var(--spacing-large);">
        <h2 id="history" style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
          <i class="ph ph-buildings"></i> History &amp; Background
        </h2>
        <p>The <strong>Chittagong Port Republic Club</strong> (CPRC) is a premier social and recreational club established within the Chittagong Port Authority complex. Founded to serve the officers, employees and families of Chittagong Port, the club has grown into a vibrant community hub fostering camaraderie, culture and sports.</p>
        <p style="margin-top:var(--spacing-medium);">With decades of service, the club has been central to the social life of the port community, organizing events that celebrate maritime heritage and Bangladeshi culture.</p>
      </section>

      <section class="widget block-widget" id="mission" style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small); margin-bottom:var(--spacing-large);">
        <h2 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
          <i class="ph ph-target"></i> Mission &amp; Vision
        </h2>
        <div class="container-row">
          <div class="container-col-6">
            <h3 style="color:var(--color-secondary-bg); margin-bottom:var(--spacing-small);">Our Mission</h3>
            <p>To provide a world-class recreational, cultural and social environment for Chittagong Port community members and their families, while preserving and promoting the maritime heritage of Bangladesh.</p>
          </div>
          <div class="container-col-6">
            <h3 style="color:var(--color-secondary-bg); margin-bottom:var(--spacing-small);">Our Vision</h3>
            <p>To be the most vibrant and inclusive club in the port sector, promoting excellence in sports, culture and community service while fostering a strong sense of belonging.</p>
          </div>
        </div>
      </section>

      <section class="widget block-widget" id="organogram" style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small);">
        <h2 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
          <i class="ph ph-tree-structure"></i> Organizational Structure
        </h2>
        <p>The club is governed by an Executive Committee elected by general members. The committee oversees all activities and manages club resources.</p>
        <a href="{{ route('members.index') }}" class="all-btn" style="display:inline-flex; align-items:center; margin-top:var(--spacing-medium); text-decoration:none; background:var(--color-primary-bg); color:#fff; padding:8px 16px; border-radius:var(--radius-small);">
          View Executive Committee <i class="ph ph-arrow-right" style="margin-left:8px;"></i>
        </a>
      </section>

    </div>

    {{-- Sidebar --}}
    <div class="container-col-4">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-info"></i> Quick Facts</p>
          <ul class="notice-unordered-list">
            <li class="notice-content-list" style="padding:8px 0;">
              <div class="notice-content-icon"><i class="ph ph-map-pin"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text">Port Area, Chittagong, Bangladesh</p>
              </div>
            </li>
            <li class="notice-content-list" style="padding:8px 0;">
              <div class="notice-content-icon"><i class="ph ph-phone"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text">+880-31-XXXXXXX</p>
              </div>
            </li>
            <li class="notice-content-list" style="padding:8px 0;">
              <div class="notice-content-icon"><i class="ph ph-envelope"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text">info@cprc.cpa.gov.bd</p>
              </div>
            </li>
          </ul>
        </div>
        <div class="all-btn">
          <a href="{{ route('contact') }}">Contact Us <i class="ph ph-arrow-right"></i></a>
        </div>
      </section>
    </div>
  </div>

</div>
@endsection
