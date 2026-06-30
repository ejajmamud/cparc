@extends('layouts.app')

@section('title', __('site.booking_title') . ' | ' . __('site.club_name'))

@section('content')
<div class="cprc-page-wrapper">

  {{-- Page Header --}}
  <div class="booking-page-hero">
    <div class="booking-hero-inner">
      <h1 class="booking-hero-title">
        <i class="ph ph-calendar-check"></i>
        {{ __('site.booking_title') }}
        <span class="lang-divider">|</span>
        <span class="bn-text">হল বুকিং</span>
      </h1>
      <p class="booking-hero-sub">{{ __('site.booking_subtitle') }}</p>
      <div class="booking-breadcrumb">
        <a href="{{ route('home') }}">{{ __('site.home') }}</a>
        <i class="ph ph-caret-right"></i>
        <a href="{{ route('packages.index') }}">{{ __('site.packages') }}</a>
        <i class="ph ph-caret-right"></i>
        <span>{{ __('site.booking_title') }}</span>
      </div>
    </div>
  </div>

  <div class="booking-layout">

    {{-- ── BOOKING FORM ── --}}
    <div class="booking-form-col">

      {{-- Validation errors --}}
      @if($errors->any())
        <div class="booking-alert booking-alert-error">
          <i class="ph ph-warning-circle"></i>
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('booking.store') }}" method="POST" id="bookingForm" novalidate enctype="multipart/form-data">
        @csrf

        {{-- ── SECTION 1: Booker Info ── --}}
        <div class="booking-section">
          <div class="booking-section-head">
            <span class="booking-section-num">১ / 1</span>
            <div>
              <h2>{{ __('site.booker_info') }}</h2>
              <p class="bn-text">আবেদনকারীর তথ্য</p>
            </div>
          </div>
          <div class="booking-grid-2">
            <div class="bk-field">
              <label for="booker_name">
                {{ __('site.full_name') }} <span class="bn-text">/ পূর্ণ নাম</span>
                <span class="bk-required">*</span>
              </label>
              <input type="text" id="booker_name" name="booker_name"
                     value="{{ old('booker_name') }}"
                     placeholder="যেমন: Mohammad Rahman"
                     class="bk-input @error('booker_name') bk-input-error @enderror"
                     required>
              @error('booker_name')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="bk-field">
              <label for="booker_phone">
                {{ __('site.phone_number') }} <span class="bn-text">/ ফোন নম্বর</span>
                <span class="bk-required">*</span>
              </label>
              <input type="tel" id="booker_phone" name="booker_phone"
                     value="{{ old('booker_phone') }}"
                     placeholder="01XXXXXXXXX"
                     class="bk-input @error('booker_phone') bk-input-error @enderror"
                     required>
              @error('booker_phone')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="bk-field">
              <label for="booker_email">
                {{ __('site.email_address') }} <span class="bn-text">/ ইমেইল</span>
                <span class="bk-optional">({{ __('site.optional') }})</span>
              </label>
              <input type="email" id="booker_email" name="booker_email"
                     value="{{ old('booker_email') }}"
                     placeholder="example@email.com"
                     class="bk-input @error('booker_email') bk-input-error @enderror">
              @error('booker_email')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="bk-field">
              <label for="booker_nid">
                {{ __('site.nid_number') }}
                <span class="bk-optional">({{ __('site.optional') }})</span>
              </label>
              <input type="text" id="booker_nid" name="booker_nid"
                     value="{{ old('booker_nid') }}"
                     placeholder="NID / জাতীয় পরিচয়পত্র নম্বর"
                     class="bk-input">
            </div>

            <div class="bk-field bk-col-span-2">
              <label for="verification_document">
                <span id="upload_label_general">{{ app()->getLocale() === 'bn' ? 'জাতীয় পরিচয়পত্র (NID) আপলোড করুন' : 'Upload National ID (NID)' }}</span>
                <span id="upload_label_staff" style="display:none;">{{ app()->getLocale() === 'bn' ? 'চবক আইডি কার্ড আপলোড করুন' : 'Upload CPA ID Card' }}</span>
                <span id="upload_label_member" style="display:none;">{{ app()->getLocale() === 'bn' ? 'সদস্য যাচাইকরণ কাগজপত্র / আইডি আপলোড করুন' : 'Upload Member Verification Paper / ID' }}</span>
                <span class="bk-required">*</span>
              </label>
              <input type="file" id="verification_document" name="verification_document"
                     class="bk-input @error('verification_document') bk-input-error @enderror"
                     required>
              <div style="font-size: 0.75rem; color: #666; margin-top: 4px;">
                {{ app()->getLocale() === 'bn' ? 'অনুমোদিত ফরম্যাট: JPG, PNG, PDF (সর্বোচ্চ ৫ মেগাবাইট)' : 'Allowed formats: JPG, PNG, PDF (Max 5MB)' }}
              </div>
              @error('verification_document')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            <div class="bk-field bk-col-span-2">
              <label for="booker_address">
                {{ __('site.address') }} <span class="bn-text">/ ঠিকানা</span>
                <span class="bk-optional">({{ __('site.optional') }})</span>
              </label>
              <textarea id="booker_address" name="booker_address"
                        rows="2" class="bk-input bk-textarea"
                        placeholder="আপনার সম্পূর্ণ ঠিকানা">{{ old('booker_address') }}</textarea>
            </div>
          </div>
        </div>

        {{-- ── SECTION 2: Event Details ── --}}
        <div class="booking-section">
          <div class="booking-section-head">
            <span class="booking-section-num">২ / 2</span>
            <div>
              <h2>{{ __('site.event_info') }}</h2>
              <p class="bn-text">অনুষ্ঠানের বিবরণ</p>
            </div>
          </div>
          <div class="booking-grid-2">

            {{-- Booker Category --}}
            <div class="bk-field bk-col-span-2">
              <label>
                {{ __('site.booker_type') ?? 'Booker Category' }} <span class="bn-text">/ আবেদনকারীর ধরণ</span>
                <span class="bk-required">*</span>
              </label>
              <div class="package-radio-grid">
                <label class="pkg-radio-card @if(old('booker_type', 'general') === 'general') selected @endif" id="lbl_bt_general">
                  <input type="radio" name="booker_type" value="general" 
                         {{ old('booker_type', 'general') === 'general' ? 'checked' : '' }} 
                         class="pkg-radio-input" style="display:none;">
                  <div class="pkg-radio-name">{{ app()->getLocale() === 'bn' ? 'সাধারণ (বহিরাগত)' : 'General Public (Outsider)' }}</div>
                  <div class="pkg-radio-price">{{ bn_taka(18000) }} ({{ app()->getLocale() === 'bn' ? 'ভিত্তি' : 'Base' }})</div>
                </label>
                <label class="pkg-radio-card @if(old('booker_type') === 'staff') selected @endif" id="lbl_bt_staff">
                  <input type="radio" name="booker_type" value="staff" 
                         {{ old('booker_type') === 'staff' ? 'checked' : '' }} 
                         class="pkg-radio-input" style="display:none;">
                  <div class="pkg-radio-name">{{ app()->getLocale() === 'bn' ? 'চবক কর্মকর্তা-কর্মচারী' : 'CPA Staff' }}</div>
                  <div class="pkg-radio-price">{{ bn_taka(5000) }} ({{ app()->getLocale() === 'bn' ? 'ভিত্তি' : 'Base' }})</div>
                </label>
                <label class="pkg-radio-card @if(old('booker_type') === 'member') selected @endif" id="lbl_bt_member">
                  <input type="radio" name="booker_type" value="member" 
                         {{ old('booker_type') === 'member' ? 'checked' : '' }} 
                         class="pkg-radio-input" style="display:none;">
                  <div class="pkg-radio-name">{{ app()->getLocale() === 'bn' ? 'রিপাবলিক ক্লাব সদস্য' : 'Republic Club Member' }}</div>
                  <div class="pkg-radio-price">{{ bn_taka(3000) }} ({{ app()->getLocale() === 'bn' ? 'ভিত্তি' : 'Base' }})</div>
                </label>
              </div>
              @error('booker_type')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            {{-- Booking Shift --}}
            <div class="bk-field">
              <label>
                {{ __('site.booking_shift') ?? 'Shift' }} <span class="bn-text">/ শিফট</span>
                <span class="bk-required">*</span>
              </label>
              <div class="package-radio-grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                <label class="pkg-radio-card @if(old('booking_shift', 'day') === 'day') selected @endif" id="lbl_shift_day" style="padding: 12px 14px;">
                  <input type="radio" name="booking_shift" value="day" 
                         {{ old('booking_shift', 'day') === 'day' ? 'checked' : '' }} 
                         class="pkg-radio-input" style="display:none;">
                  <div class="pkg-radio-name" style="font-size: 0.95rem;">{{ app()->getLocale() === 'bn' ? 'দিন' : 'Day Shift' }}</div>
                  <div style="font-size: 0.72rem; color: #666; margin-top: 4px;">12:00 PM - 5:00 PM</div>
                </label>
                <label class="pkg-radio-card @if(old('booking_shift') === 'night') selected @endif" id="lbl_shift_night" style="padding: 12px 14px;">
                  <input type="radio" name="booking_shift" value="night" 
                         {{ old('booking_shift') === 'night' ? 'checked' : '' }} 
                         class="pkg-radio-input" style="display:none;">
                  <div class="pkg-radio-name" style="font-size: 0.95rem;">{{ app()->getLocale() === 'bn' ? 'রাত' : 'Night Shift' }}</div>
                  <div style="font-size: 0.72rem; color: #666; margin-top: 4px;">6:00 PM - 11:00 PM</div>
                </label>
              </div>
              @error('booking_shift')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            {{-- Rental Type --}}
            <div class="bk-field">
              <label>
                {{ __('site.rental_type') ?? 'Rental Type' }} <span class="bn-text">/ ভাড়ার ধরণ</span>
                <span class="bk-required">*</span>
              </label>
              <div class="package-radio-grid" style="grid-template-columns: 1fr 1fr; gap: 10px;">
                <label class="pkg-radio-card @if(old('rental_type', 'hall') === 'hall') selected @endif" id="lbl_rt_hall" style="padding: 12px 14px;">
                  <input type="radio" name="rental_type" value="hall" 
                         {{ old('rental_type', 'hall') === 'hall' ? 'checked' : '' }} 
                         class="pkg-radio-input" style="display:none;">
                  <div class="pkg-radio-name" style="font-size: 0.95rem;">{{ app()->getLocale() === 'bn' ? 'শুধু হল' : 'Only Hall' }}</div>
                </label>
                <label class="pkg-radio-card @if(old('rental_type') === 'hall_field') selected @endif" id="lbl_rt_field" style="padding: 12px 14px;">
                  <input type="radio" name="rental_type" value="hall_field" 
                         {{ old('rental_type') === 'hall_field' ? 'checked' : '' }} 
                         class="pkg-radio-input" style="display:none;">
                  <div class="pkg-radio-name" style="font-size: 0.95rem;">{{ app()->getLocale() === 'bn' ? 'হল + মাঠ' : 'Hall + Field' }}</div>
                  <div style="font-size: 0.72rem; color: #666; margin-top: 4px;">+{{ bn_taka(10000) }}</div>
                </label>
              </div>
              @error('rental_type')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            {{-- Event Type --}}
            <div class="bk-field">
              <label for="event_type">
                {{ __('site.event_type') }} <span class="bn-text">/ অনুষ্ঠানের ধরন</span>
                <span class="bk-required">*</span>
              </label>
              <select id="event_type" name="event_type"
                      class="bk-input bk-select @error('event_type') bk-input-error @enderror"
                      required>
                <option value="">-- {{ app()->getLocale() === 'bn' ? 'ধরন বেছে নিন' : 'Select type' }} --</option>
                <option value="wedding"   {{ old('event_type') === 'wedding'   ? 'selected' : '' }}>{{ __('site.event_wedding') }}</option>
                <option value="reception" {{ old('event_type') === 'reception' ? 'selected' : '' }}>{{ __('site.event_reception') }}</option>
                <option value="birthday"  {{ old('event_type') === 'birthday'  ? 'selected' : '' }}>{{ __('site.event_birthday') }}</option>
                <option value="corporate" {{ old('event_type') === 'corporate' ? 'selected' : '' }}>{{ __('site.event_corporate') }}</option>
                <option value="cultural"  {{ old('event_type') === 'cultural'  ? 'selected' : '' }}>{{ __('site.event_cultural') }}</option>
                <option value="seminar"   {{ old('event_type') === 'seminar'   ? 'selected' : '' }}>{{ __('site.event_seminar') }}</option>
                <option value="other"     {{ old('event_type') === 'other'     ? 'selected' : '' }}>{{ __('site.event_other') }}</option>
              </select>
              @error('event_type')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            {{-- Other event type --}}
            <div class="bk-field" id="other_type_wrap" style="display:none;">
              <label for="event_type_other">
                {{ app()->getLocale() === 'bn' ? 'অনুষ্ঠানের নাম লিখুন' : 'Specify Event Type' }}
                <span class="bk-required">*</span>
              </label>
              <input type="text" id="event_type_other" name="event_type_other"
                     value="{{ old('event_type_other') }}"
                     class="bk-input" placeholder="{{ app()->getLocale() === 'bn' ? 'অনুষ্ঠানের ধরন' : 'Event type' }}">
            </div>

            {{-- Event Date --}}
            <div class="bk-field">
              <label for="event_date">
                {{ app()->getLocale() === 'bn' ? 'শুরুর তারিখ' : 'Start Date' }}
                <span class="bk-required">*</span>
              </label>
              <input type="date" id="event_date" name="event_date"
                     value="{{ old('event_date') }}"
                     min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                     class="bk-input @error('event_date') bk-input-error @enderror"
                     required>
              @error('event_date')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            {{-- Event End Date --}}
            <div class="bk-field">
              <label for="event_end_date">
                {{ app()->getLocale() === 'bn' ? 'শেষের তারিখ (বহুদিনের জন্য)' : 'End Date (for multi-day)' }}
                <span class="bk-optional">({{ __('site.optional') }})</span>
              </label>
              <input type="date" id="event_end_date" name="event_end_date"
                     value="{{ old('event_end_date') }}"
                     min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                     class="bk-input @error('event_end_date') bk-input-error @enderror">
              @error('event_end_date')<span class="bk-error-msg">{{ $message }}</span>@enderror
            </div>

            {{-- Days summary badge --}}
            <div class="bk-field bk-col-span-2" id="days-summary-wrap" style="display:none;">
              <div id="days-summary" style="background:var(--color-primary-bg);color:#fff;border-radius:8px;padding:10px 16px;display:flex;align-items:center;gap:10px;font-size:.9rem;">
                <i class="ph ph-calendar-blank"></i>
                <span id="days-summary-text"></span>
              </div>
              <div id="availability-status" class="availability-badge" style="display:none;margin-top:6px;"></div>
            </div>
            <div id="availability-status-single" class="availability-badge" style="display:none;"></div>

            {{-- Guests --}}
            <div class="bk-field">
              <label for="guests_count">
                {{ __('site.guests_count') }} <span class="bn-text">/ অতিথি সংখ্যা</span>
              </label>
              <input type="number" id="guests_count" name="guests_count"
                     value="{{ old('guests_count') }}"
                     min="1" max="5000" placeholder="500"
                     class="bk-input">
            </div>

            {{-- Start Time --}}
            <div class="bk-field">
              <label for="start_time">
                {{ __('site.start_time') }} <span class="bn-text">/ শুরুর সময়</span>
                <span class="bk-optional">({{ __('site.optional') }})</span>
              </label>
              <input type="time" id="start_time" name="start_time"
                     value="{{ old('start_time') }}" class="bk-input">
            </div>

            {{-- End Time --}}
            <div class="bk-field">
              <label for="end_time">
                {{ __('site.end_time') }} <span class="bn-text">/ শেষের সময়</span>
                <span class="bk-optional">({{ __('site.optional') }})</span>
              </label>
              <input type="time" id="end_time" name="end_time"
                     value="{{ old('end_time') }}" class="bk-input">
            </div>

            {{-- Special Requests --}}
            <div class="bk-field bk-col-span-2">
              <label for="special_requests">
                {{ __('site.special_requests') }} <span class="bn-text">/ বিশেষ অনুরোধ</span>
                <span class="bk-optional">({{ __('site.optional') }})</span>
              </label>
              <textarea id="special_requests" name="special_requests"
                        rows="3" class="bk-input bk-textarea"
                        placeholder="{{ app()->getLocale() === 'bn' ? 'ডেকোরেশন, ক্যাটারিং, মঞ্চ সজ্জা বা অন্য কোনো বিশেষ প্রয়োজন জানান...' : 'Decoration, catering, stage setup or any special requirements...' }}">{{ old('special_requests') }}</textarea>
            </div>

          </div>
        </div>

        {{-- Submit --}}
        <div class="booking-submit-bar">
          <div class="booking-submit-note">
            <i class="ph ph-info"></i>
            {{ app()->getLocale() === 'bn'
              ? 'বুকিং নিশ্চিত হলে আমাদের টিম ২৪ ঘণ্টার মধ্যে আপনাকে ফোন করবে।'
              : 'Upon submission, our team will call you within 24 hours to confirm.' }}
          </div>
          <button type="submit" class="bk-submit-btn" id="submitBtn">
            <i class="ph ph-paper-plane-tilt"></i>
            {{ __('site.submit_booking') }}
          </button>
        </div>

      </form>
    </div>

    {{-- ── SIDEBAR ── --}}
    <aside class="booking-sidebar">

      {{-- Contact card --}}
      <div class="bk-sidebar-card">
        <h3><i class="ph ph-phone"></i> {{ app()->getLocale() === 'bn' ? 'তথ্যের জন্য যোগাযোগ' : 'Need Help?' }}</h3>
        <p class="bk-sidebar-sub">{{ app()->getLocale() === 'bn' ? 'সরাসরি কথা বলুন' : 'Speak to us directly' }}</p>
        <div class="bk-contact-row">
          <i class="ph ph-phone-call"></i>
          <div>
            <strong>+880 31-XXXXXXX</strong><br>
            <small>{{ app()->getLocale() === 'bn' ? 'অফিস লাইন' : 'Office Line' }}</small>
          </div>
        </div>
        <div class="bk-contact-row">
          <i class="ph ph-whatsapp-logo"></i>
          <div>
            <strong>+880 1XXXXXXXXX</strong><br>
            <small>WhatsApp</small>
          </div>
        </div>
        <div class="bk-contact-row">
          <i class="ph ph-clock"></i>
          <div>
            <strong>{{ app()->getLocale() === 'bn' ? 'রবি – বৃহস্পতি' : 'Sun – Thu' }}</strong><br>
            <small>9:00 AM – 5:00 PM</small>
          </div>
        </div>
      </div>

      {{-- Pricing summary --}}
      <div class="bk-sidebar-card">
        <h3><i class="ph ph-receipt"></i> {{ app()->getLocale() === 'bn' ? 'ভাড়ার হিসাব বিবরণী' : 'Pricing Summary' }}</h3>
        <div class="pkg-summary-data" style="display:block;">
          <div class="pkg-summary-name" id="sum-booker-title">
            {{ app()->getLocale() === 'bn' ? 'সাধারণ (বহিরাগত)' : 'General Public (Outsider)' }}
          </div>
          
                    <div class="pkg-summary-row" id="sum-days-row" style="display:none;">
            <span>{{ app()->getLocale() === 'bn' ? 'মোট দিন' : 'Total Days' }}</span>
            <strong id="sum-days">1</strong>
          </div>
          <div class="pkg-summary-row" id="sum-discount-row" style="display:none;">
            <span>{{ app()->getLocale() === 'bn' ? 'বহুদিনের ছাড়' : 'Multi-day Discount' }}</span>
            <strong id="sum-discount" style="color:#27ae60;"></strong>
          </div>
          <div class="pkg-summary-row">
            <span>{{ app()->getLocale() === 'bn' ? 'প্রতিদিনের ভাড়া' : 'Per Day Rate' }}</span>
            <strong id="sum-base-rent">{{ bn_taka(18000) }}</strong>
          </div>
          
          <div class="pkg-summary-row" id="sum-field-row" style="display:none;">
            <span>{{ app()->getLocale() === 'bn' ? 'মাঠ ভাড়া' : 'Field Rent' }}</span>
            <strong id="sum-field-rent">{{ bn_taka(10000) }}</strong>
          </div>
          
          <div class="pkg-summary-row" id="sum-electricity-row" style="display:none;">
            <span>{{ app()->getLocale() === 'bn' ? 'বিদ্যুৎ বিল' : 'Electricity Bill' }}</span>
            <strong id="sum-electricity-rent">{{ bn_taka(0) }}</strong>
          </div>
          
          <div class="pkg-summary-price" id="sum-total-price" style="margin-top:14px; padding-top:14px; border-top: 1px dashed rgba(0,0,0,0.12); font-size:1.6rem;">
          {{ bn_taka(18000) }}
          </div>
          <div class="pkg-summary-row pkg-advance-row">
            <span>{{ __('site.advance_required') }} ({{ app()->getLocale() === 'bn' ? '৫০%' : '50%' }})</span>
            <strong class="pkg-advance-amt" id="sum-advance-amt">{{ bn_taka(9000) }}</strong>
          </div>
        </div>
      </div>

      {{-- Policy card --}}
      <div class="bk-sidebar-card bk-policy-card">
        <h3><i class="ph ph-shield-check"></i> {{ app()->getLocale() === 'bn' ? 'বুকিং নীতিমালা' : 'Booking Policy' }}</h3>
        <ul class="bk-policy-list">
          <li><i class="ph ph-dot-outline"></i> {{ app()->getLocale() === 'bn' ? '৫০% অগ্রিম পেমেন্ট বাধ্যতামূলক' : '50% advance payment required to confirm' }}</li>
          <li><i class="ph ph-dot-outline"></i> {{ app()->getLocale() === 'bn' ? 'বাকি পেমেন্ট অনুষ্ঠানের আগের দিন' : 'Remaining balance due the day before the event' }}</li>
          <li><i class="ph ph-dot-outline"></i> {{ app()->getLocale() === 'bn' ? '১৪ দিন আগে বাতিল করলে সম্পূর্ণ ফেরত' : 'Full refund if cancelled 14+ days in advance' }}</li>
          <li><i class="ph ph-dot-outline"></i> {{ app()->getLocale() === 'bn' ? 'পরিচয়পত্র দিয়ে চুক্তিপত্র সই করতে হবে' : 'Contract must be signed with valid ID' }}</li>
          <li><i class="ph ph-dot-outline"></i> {{ app()->getLocale() === 'bn' ? 'সর্বোচ্চ ধারণক্ষমতা ১০০০ জন' : 'Maximum capacity: 1,000 guests' }}</li>
        </ul>
      </div>

    </aside>
  </div>
</div>

@push('scripts')
<script>
(function() {
  const isBn = {{ app()->getLocale() === 'bn' ? 'true' : 'false' }};
  function toBn(str) {
    if (!isBn) return String(str);
    return String(str).replace(/[0-9]/g, d => '০১২৩৪৫৬৭৮৯'[d]);
  }
  function fmtTaka(amount) { return '৳' + toBn(Math.round(amount).toLocaleString('en-US')); }

  const dateInput    = document.getElementById('event_date');
  const endDateInput = document.getElementById('event_end_date');
  const eventTypeEl  = document.getElementById('event_type');
  const otherWrap    = document.getElementById('other_type_wrap');
  const statusDiv    = document.getElementById('availability-status');
  const daysSumWrap  = document.getElementById('days-summary-wrap');
  const daysSumText  = document.getElementById('days-summary-text');

  // Pricing elements
  const sumBookerTitle     = document.getElementById('sum-booker-title');
  const sumBaseRent        = document.getElementById('sum-base-rent');
  const sumFieldRow        = document.getElementById('sum-field-row');
  const sumFieldRent       = document.getElementById('sum-field-rent');
  const sumElectricityRow  = document.getElementById('sum-electricity-row');
  const sumElectricityRent = document.getElementById('sum-electricity-rent');
  const sumDaysRow         = document.getElementById('sum-days-row');
  const sumDays            = document.getElementById('sum-days');
  const sumDiscountRow     = document.getElementById('sum-discount-row');
  const sumDiscount        = document.getElementById('sum-discount');
  const sumTotalPrice      = document.getElementById('sum-total-price');
  const sumAdvanceAmt      = document.getElementById('sum-advance-amt');

  if (eventTypeEl && otherWrap) {
    eventTypeEl.addEventListener('change', function() {
      otherWrap.style.display = this.value === 'other' ? 'block' : 'none';
    });
  }

  function setupRadioCards(name) {
    const radios = document.querySelectorAll('input[name="' + name + '"]');
    radios.forEach(function(radio) {
      radio.addEventListener('change', function() {
        radios.forEach(r => r.closest('.pkg-radio-card').classList.remove('selected'));
        this.closest('.pkg-radio-card').classList.add('selected');
        calculatePrice();
        if (name === 'booking_shift') checkAvailability();
      });
      radio.closest('.pkg-radio-card').addEventListener('click', function(e) {
        if (e.target !== radio) { radio.checked = true; radio.dispatchEvent(new Event('change')); }
      });
    });
  }

  setupRadioCards('booker_type');
  setupRadioCards('booking_shift');
  setupRadioCards('rental_type');

  function getDays() {
    if (!dateInput.value) return 1;
    if (!endDateInput.value || endDateInput.value <= dateInput.value) return 1;
    const ms = new Date(endDateInput.value) - new Date(dateInput.value);
    return Math.round(ms / 86400000) + 1;
  }

  function calculatePrice() {
    const bookerRadio = document.querySelector('input[name="booker_type"]:checked');
    const shiftRadio  = document.querySelector('input[name="booking_shift"]:checked');
    const rentalRadio = document.querySelector('input[name="rental_type"]:checked');
    if (!bookerRadio || !shiftRadio || !rentalRadio) return;

    const bookerType = bookerRadio.value;
    const shift      = shiftRadio.value;
    const rentalType = rentalRadio.value;
    const days       = getDays();

    document.getElementById('upload_label_general').style.display = bookerType === 'general' ? 'inline' : 'none';
    document.getElementById('upload_label_staff').style.display   = bookerType === 'staff'   ? 'inline' : 'none';
    document.getElementById('upload_label_member').style.display  = bookerType === 'member'  ? 'inline' : 'none';

    let perDay = { general:18000, staff:5000, member:3000 }[bookerType] || 18000;
    const names = {
      general: isBn ? 'সাধারণ (বহিরাগত)' : 'General Public (Outsider)',
      staff:   isBn ? 'চবক কর্মকর্তা-কর্মচারী' : 'CPA Staff',
      member:  isBn ? 'রিপাবলিক ক্লাব সদস্য' : 'Republic Club Member',
    };
    sumBookerTitle.textContent = names[bookerType];

    let fieldRent = 0;
    if (rentalType === 'hall_field') {
      fieldRent = 10000;
      sumFieldRow.style.display = 'flex';
      sumFieldRent.textContent = fmtTaka(10000);
    } else { sumFieldRow.style.display = 'none'; }

    let elecRent = 0;
    if (shift === 'night') {
      elecRent = bookerType === 'general' ? 2000 : 1500;
      sumElectricityRow.style.display = 'flex';
      sumElectricityRent.textContent = fmtTaka(elecRent);
    } else { sumElectricityRow.style.display = 'none'; }

    const perDayTotal = perDay + fieldRent + elecRent;
    sumBaseRent.textContent = fmtTaka(perDayTotal);

    // Multi-day: 10% off per extra day, max 30%
    const discountRate = Math.min((days - 1) * 0.10, 0.30);
    const total  = Math.round(perDayTotal * days * (1 - discountRate));
    const advance = Math.round(total / 2);

    if (days > 1) {
      sumDaysRow.style.display    = 'flex';
      sumDays.textContent         = toBn(days) + (isBn ? ' দিন' : ' day' + (days > 1 ? 's' : ''));
      if (discountRate > 0) {
        sumDiscountRow.style.display = 'flex';
        sumDiscount.textContent = '-' + toBn(Math.round(discountRate * 100)) + '%';
      }
    } else {
      sumDaysRow.style.display    = 'none';
      sumDiscountRow.style.display = 'none';
    }

    sumTotalPrice.textContent = fmtTaka(total);
    sumAdvanceAmt.textContent = fmtTaka(advance);
  }

  calculatePrice();

  // Sync end date min to start date
  dateInput.addEventListener('change', function() {
    endDateInput.min = this.value;
    if (endDateInput.value && endDateInput.value < this.value) endDateInput.value = '';
    updateDaysBadge();
    calculatePrice();
    checkAvailability();
  });

  endDateInput.addEventListener('change', function() {
    updateDaysBadge();
    calculatePrice();
    checkAvailability();
  });

  function updateDaysBadge() {
    const days = getDays();
    if (days > 1 && dateInput.value && endDateInput.value) {
      daysSumWrap.style.display = 'block';
      daysSumText.textContent = isBn
        ? toBn(dateInput.value) + ' থেকে ' + toBn(endDateInput.value) + ' — মোট ' + toBn(days) + ' দিন'
        : dateInput.value + ' to ' + endDateInput.value + ' — ' + days + ' days total';
    } else {
      daysSumWrap.style.display = 'none';
    }
  }

  let availTimer = null;
  function checkAvailability() {
    const date    = dateInput.value;
    const endDate = endDateInput.value;
    const shiftRadio = document.querySelector('input[name="booking_shift"]:checked');
    if (!date || !shiftRadio) return;

    const sd = statusDiv;
    sd.className = 'availability-badge checking';
    sd.textContent = '{{ __("site.checking_availability") }}';
    sd.style.display = 'block';
    if (daysSumWrap.style.display !== 'none') {
      // show inside the badge wrap
    }

    clearTimeout(availTimer);
    availTimer = setTimeout(() => {
      let url = '{{ route("booking.availability") }}?date=' + encodeURIComponent(date) + '&shift=' + shiftRadio.value;
      if (endDate && endDate > date) url += '&end_date=' + encodeURIComponent(endDate);

      fetch(url).then(r => r.json()).then(data => {
        sd.className = 'availability-badge ' + (data.available ? 'available' : 'unavailable');
        sd.textContent = (data.available ? '✓ ' : '✗ ') + data.message;
      }).catch(() => { sd.style.display = 'none'; });
    }, 400);
  }
})();
</script>
@endpush
@endsection
