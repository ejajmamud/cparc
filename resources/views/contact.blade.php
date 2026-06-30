@extends('layouts.app')

@if(app()->getLocale() === 'bn')
  @section('title', 'যোগাযোগ | চট্টগ্রাম বন্দর রিপাবলিক ক্লাব')
@else
  @section('title', 'Contact Us | Chittagong Port Republic Club')
@endif

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-phone-call"></i> 
    @if(app()->getLocale() === 'bn')
      যোগাযোগ
    @else
      Contact Us
    @endif
  </h1>

  <div class="container-row">
    {{-- Contact form --}}
    <div class="container-col-7">
      <section style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small);">
        <h2 style="margin-top:0; color:var(--color-dark-dark); font-size:var(--typography-h3-font-size);">
          @if(app()->getLocale() === 'bn')
            বার্তা পাঠান
          @else
            Send a Message
          @endif
        </h2>

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
              @if(app()->getLocale() === 'bn')
                পূর্ণ নাম <span style="color:var(--color-danger-bg);">*</span>
              @else
                Full Name <span style="color:var(--color-danger-bg);">*</span>
              @endif
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box;"
                   placeholder="{{ app()->getLocale() === 'bn' ? 'আপনার নাম লিখুন' : 'Enter your name' }}">
          </div>
          <div style="margin-bottom:var(--spacing-medium);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              @if(app()->getLocale() === 'bn')
                ইমেইল ঠিকানা <span style="color:var(--color-danger-bg);">*</span>
              @else
                Email Address <span style="color:var(--color-danger-bg);">*</span>
              @endif
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box;"
                   placeholder="{{ app()->getLocale() === 'bn' ? 'আপনার ইমেইল লিখুন' : 'Enter your email' }}">
          </div>
          <div style="margin-bottom:var(--spacing-medium);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              @if(app()->getLocale() === 'bn')
                ফোন নম্বর
              @else
                Phone Number
              @endif
            </label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                   style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box;"
                   placeholder="{{ app()->getLocale() === 'bn' ? 'আপনার ফোন নম্বর লিখুন' : 'Enter your phone number' }}">
          </div>
          <div style="margin-bottom:var(--spacing-medium);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              @if(app()->getLocale() === 'bn')
                বিষয় <span style="color:var(--color-danger-bg);">*</span>
              @else
                Subject <span style="color:var(--color-danger-bg);">*</span>
              @endif
            </label>
            <input type="text" name="subject" value="{{ old('subject') }}" required
                   style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box;"
                   placeholder="{{ app()->getLocale() === 'bn' ? 'বার্তার বিষয়' : 'Message subject' }}">
          </div>
          <div style="margin-bottom:var(--spacing-large);">
            <label style="display:block; font-size:var(--text-medium); margin-bottom:4px; font-weight:500;">
              @if(app()->getLocale() === 'bn')
                বার্তা <span style="color:var(--color-danger-bg);">*</span>
              @else
                Message <span style="color:var(--color-danger-bg);">*</span>
              @endif
            </label>
            <textarea name="message" rows="6" required
                      style="width:100%; padding:10px 12px; border:1px solid var(--color-border-normal); border-radius:var(--radius-small); font-size:var(--typography-body-font-size); box-sizing:border-box; resize:vertical;"
                      placeholder="{{ app()->getLocale() === 'bn' ? 'আপনার বার্তা এখানে লিখুন...' : 'Write your message here...' }}">{{ old('message') }}</textarea>
          </div>
          <button type="submit"
                  style="background:linear-gradient(to right, var(--color-primary-bg), var(--color-primary-dark)); color:#fff; border:none; padding:12px 32px; border-radius:var(--radius-small); cursor:pointer; font-size:var(--typography-body-font-size); display:inline-flex; align-items:center; gap:8px;">
            <i class="ph ph-paper-plane-tilt"></i> 
            @if(app()->getLocale() === 'bn')
              বার্তা পাঠান
            @else
              Send Message
            @endif
          </button>
        </form>
      </section>
    </div>

    {{-- Contact info sidebar --}}
    <div class="container-col-5">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title">
            <i class="ph ph-map-pin"></i> 
            @if(app()->getLocale() === 'bn')
              কার্যালয়ের ঠিকানা
            @else
              Office Address
            @endif
          </p>
          <ul class="notice-unordered-list">
            <li class="notice-content-list" style="flex-direction:column; align-items:flex-start; gap:4px;">
              <p style="margin:0; font-weight:600;">
                @if(app()->getLocale() === 'bn')
                  চট্টগ্রাম বন্দর রিপাবলিক ক্লাব
                @else
                  Chittagong Port Republic Club
                @endif
              </p>
              <p style="margin:0; color:#555;">
                @if(app()->getLocale() === 'bn')
                  বন্দর এলাকা, চট্টগ্রাম
                @else
                  Port Area, Chittagong
                @endif
              </p>
              <p style="margin:0; color:#555;">
                @if(app()->getLocale() === 'bn')
                  বাংলাদেশ
                @else
                  Bangladesh
                @endif
              </p>
            </li>
          </ul>
        </div>
      </section>

      <section class="widget notice-news-card-widget" style="margin-top:var(--spacing-medium);">
        <div class="notice-card">
          <p class="notice-title">
            <i class="ph ph-phone"></i> 
            @if(app()->getLocale() === 'bn')
              যোগাযোগের তথ্য
            @else
              Contact Information
            @endif
          </p>
          <ul class="notice-unordered-list">
            <li class="notice-content-list">
              <div class="notice-content-icon"><i class="ph ph-phone"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text">
                  @if(app()->getLocale() === 'bn')
                    <strong>ফোন:</strong> +880-31-XXXXXXX
                  @else
                    <strong>Phone:</strong> +880-31-XXXXXXX
                  @endif
                </p>
              </div>
            </li>
            <li class="notice-content-list">
              <div class="notice-content-icon"><i class="ph ph-envelope"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text">
                  @if(app()->getLocale() === 'bn')
                    <strong>ইমেইল:</strong> info@cprc.cpa.gov.bd
                  @else
                    <strong>Email:</strong> info@cprc.cpa.gov.bd
                  @endif
                </p>
              </div>
            </li>
            <li class="notice-content-list">
              <div class="notice-content-icon"><i class="ph ph-clock"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text">
                  <strong>
                    @if(app()->getLocale() === 'bn')
                      কার্যালয়ের সময়সূচী:
                    @else
                      Office Hours:
                    @endif
                  </strong>
                </p>
                <p class="notice-text" style="color:#555;">
                  @if(app()->getLocale() === 'bn')
                    রবি – বৃহস্পতি: সকাল ৯:০০ – বিকাল ৫:০০
                  @else
                    Sun – Thu: 9:00 AM – 5:00 PM
                  @endif
                </p>
              </div>
            </li>
          </ul>
        </div>
      </section>
    </div>
  </div>

</div>

{{-- Full-width map --}}
<div style="width:100%; margin-top:var(--spacing-large);">
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d468.6!2d91.8217!3d22.3397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2s8Q8V%2BFR5+Mosque+Market+Port+Colony+Rd%2C+Chattogram+4100%2C+Bangladesh!5e0!3m2!1sen!2sbd!4v1"
    width="100%"
    height="420"
    style="border:0; display:block;"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade"
    title="{{ app()->getLocale() === 'bn' ? 'চট্টগ্রাম বন্দর রিপাবলিক ক্লাবের অবস্থান' : 'Chittagong Port Republic Club Location' }}">
  </iframe>
</div>
@endsection
