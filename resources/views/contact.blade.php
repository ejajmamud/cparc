@extends('layouts.app')

@section('title', 'Contact Us | Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-phone-call"></i> Contact Us
  </h1>

  <div class="container-row">
    {{-- Contact form --}}
    <div class="container-col-7">
      <section style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small);">
        <h2 style="margin-top:0; color:var(--color-dark-dark); font-size:var(--typography-h3-font-size);">Send a Message</h2>

        @if(session('success'))
          <div style="background:#d4edda; color:#155724; border:1px solid #c3e6cb; border-radius:var(--radius-small); padding:var(--spacing-medium); margin-bottom:var(--spacing-medium);">
            {{ session('success') }}
          </div>
        @endif

        @if($errors->any())
          <div style="background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; border-radius:var(--radius-small); padding:var(--spacing-medium); margin-bottom:var(--spacing-medium);">
            <ul style="margin:0; padding-left:16px;">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}">
          @csrf
          <div style="margin-bottom:var(--spacing-medium);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              Full Name <span style="color:var(--color-danger-bg);">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box;"
                   placeholder="Enter your name">
          </div>
          <div style="margin-bottom:var(--spacing-medium);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              Email Address <span style="color:var(--color-danger-bg);">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box;"
                   placeholder="Enter your email">
          </div>
          <div style="margin-bottom:var(--spacing-medium);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              Phone Number
            </label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                   style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box;"
                   placeholder="Enter your phone number">
          </div>
          <div style="margin-bottom:var(--spacing-medium);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              Subject <span style="color:var(--color-danger-bg);">*</span>
            </label>
            <input type="text" name="subject" value="{{ old('subject') }}" required
                   style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box;"
                   placeholder="Message subject">
          </div>
          <div style="margin-bottom:var(--spacing-large);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              Message <span style="color:var(--color-danger-bg);">*</span>
            </label>
            <textarea name="message" rows="6" required
                      style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box; resize:vertical;"
                      placeholder="Write your message here...">{{ old('message') }}</textarea>
          </div>
          <button type="submit"
                  style="background:linear-gradient(to right, var(--color-primary-bg), var(--color-primary-dark)); color:#fff; border:none; padding:12px 32px; border-radius:var(--radius-small); cursor:pointer; font-size:var(--typography-body-font-size); display:inline-flex; align-items:center; gap:8px;">
            <i class="ph ph-paper-plane-tilt"></i> Send Message
          </button>
        </form>
      </section>
    </div>

    {{-- Contact info sidebar --}}
    <div class="container-col-5">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-map-pin"></i> Office Address</p>
          <ul class="notice-unordered-list">
            <li class="notice-content-list" style="flex-direction:column; align-items:flex-start; gap:4px;">
              <p style="margin:0; font-weight:600;">Chittagong Port Republic Club</p>
              <p style="margin:0; color:#555;">Port Area, Chittagong</p>
              <p style="margin:0; color:#555;">Bangladesh</p>
            </li>
          </ul>
        </div>
      </section>

      <section class="widget notice-news-card-widget" style="margin-top:var(--spacing-medium);">
        <div class="notice-card">
          <p class="notice-title"><i class="ph ph-phone"></i> Contact Information</p>
          <ul class="notice-unordered-list">
            <li class="notice-content-list">
              <div class="notice-content-icon"><i class="ph ph-phone"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text"><strong>Phone:</strong> +880-31-XXXXXXX</p>
              </div>
            </li>
            <li class="notice-content-list">
              <div class="notice-content-icon"><i class="ph ph-envelope"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text"><strong>Email:</strong> info@cprc.cpa.gov.bd</p>
              </div>
            </li>
            <li class="notice-content-list">
              <div class="notice-content-icon"><i class="ph ph-clock"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text"><strong>Office Hours:</strong></p>
                <p class="notice-text" style="color:#555;">Sun – Thu: 9:00 AM – 5:00 PM</p>
              </div>
            </li>
          </ul>
        </div>
      </section>
    </div>
  </div>

</div>
@endsection
