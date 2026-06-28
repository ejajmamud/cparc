@extends('layouts.app')

@section('title', __('site.booking_confirmed_title') . ' | ' . __('site.club_name'))

@section('content')
<div class="cprc-page-wrapper">
  <div class="booking-confirm-wrapper">

    {{-- Success Icon --}}
    <div class="confirm-icon-ring">
      <i class="ph ph-check-fat"></i>
    </div>

    <h1 class="confirm-title">{{ __('site.booking_confirmed_title') }}</h1>
    <p class="confirm-subtitle">
      {{ app()->getLocale() === 'bn'
        ? 'আপনার বুকিং অনুরোধ সফলভাবে গ্রহণ করা হয়েছে।'
        : 'Your booking request has been successfully received.' }}
    </p>

    {{-- Reference Number --}}
    <div class="confirm-ref-box">
      <span class="confirm-ref-label">{{ __('site.booking_ref') }}</span>
      <span class="confirm-ref-number">{{ $booking->reference_number }}</span>
      <span class="confirm-status-badge status-{{ $booking->status }}">
        {{ app()->getLocale() === 'bn' ? 'অপেক্ষমান' : 'Pending' }}
      </span>
    </div>

    {{-- Booking Details --}}
    <div class="confirm-details-card">
      <h2>
        <i class="ph ph-clipboard-text"></i>
        {{ app()->getLocale() === 'bn' ? 'বুকিং বিবরণ' : 'Booking Details' }}
      </h2>
      <table class="confirm-table">
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'নাম' : 'Name' }}</td>
          <td><strong>{{ $booking->booker_name }}</strong></td>
        </tr>
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'ফোন' : 'Phone' }}</td>
          <td><strong>{{ $booking->booker_phone }}</strong></td>
        </tr>
        @if($booking->booker_email)
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'ইমেইল' : 'Email' }}</td>
          <td><strong>{{ $booking->booker_email }}</strong></td>
        </tr>
        @endif
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'আবেদনকারীর ধরণ' : 'Booker Category' }}</td>
          <td><strong>
            @if($booking->booker_type === 'general')
              {{ app()->getLocale() === 'bn' ? 'সাধারণ (বহিরাগত)' : 'General Public (Outsider)' }}
            @elseif($booking->booker_type === 'staff')
              {{ app()->getLocale() === 'bn' ? 'চবক কর্মকর্তা-কর্মচারী' : 'CPA Staff' }}
            @elseif($booking->booker_type === 'member')
              {{ app()->getLocale() === 'bn' ? 'রিপাবলিক ক্লাব সদস্য' : 'Republic Club Member' }}
            @endif
          </strong></td>
        </tr>
        @if($booking->verification_document)
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'যাচাইকরণ ফাইল' : 'Verification Document' }}</td>
          <td><strong><a href="{{ asset('storage/' . $booking->verification_document) }}" target="_blank" style="color:var(--color-primary-bg); text-decoration: underline;"><i class="ph ph-file-arrow-down"></i> {{ app()->getLocale() === 'bn' ? 'ফাইল ডাউনলোড করুন' : 'Download File' }}</a></strong></td>
        </tr>
        @endif
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'শিফট' : 'Shift' }}</td>
          <td><strong>
            @if($booking->booking_shift === 'day')
              {{ app()->getLocale() === 'bn' ? 'দিন (দুপুর ১২:০০ - বিকাল ৫:০০)' : 'Day Shift (12:00 PM - 5:00 PM)' }}
            @else
              {{ app()->getLocale() === 'bn' ? 'রাত (সন্ধ্যা ৬:০০ - রাত ১১:০০)' : 'Night Shift (6:00 PM - 11:00 PM)' }}
            @endif
          </strong></td>
        </tr>
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'ভাড়ার ধরণ' : 'Rental Option' }}</td>
          <td><strong>
            @if($booking->rental_type === 'hall')
              {{ app()->getLocale() === 'bn' ? 'শুধু হল' : 'Only Hall' }}
            @else
              {{ app()->getLocale() === 'bn' ? 'হল + মাঠ' : 'Hall + Field' }}
            @endif
          </strong></td>
        </tr>
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'অনুষ্ঠানের ধরন' : 'Event Type' }}</td>
          <td><strong>{{ __('site.event_' . $booking->event_type) }}{{ $booking->event_type_other ? ' – ' . $booking->event_type_other : '' }}</strong></td>
        </tr>
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'তারিখ' : 'Event Date' }}</td>
          <td><strong>{{ $booking->event_date->format('d F Y') }}</strong></td>
        </tr>
        @if($booking->start_time)
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'সময়' : 'Time' }}</td>
          <td><strong>{{ $booking->start_time }}{{ $booking->end_time ? ' – ' . $booking->end_time : '' }}</strong></td>
        </tr>
        @endif
        @if($booking->guests_count)
        <tr>
          <td>{{ app()->getLocale() === 'bn' ? 'আনুমানিক অতিথি' : 'Est. Guests' }}</td>
          <td><strong>{{ number_format($booking->guests_count) }} {{ app()->getLocale() === 'bn' ? 'জন' : 'persons' }}</strong></td>
        </tr>
        @endif
        <tr class="confirm-table-total">
          <td>{{ app()->getLocale() === 'bn' ? 'মোট মূল্য' : 'Total Amount' }}</td>
          <td><strong>৳{{ number_format($booking->total_amount) }}</strong></td>
        </tr>
        <tr class="confirm-table-advance">
          <td>{{ app()->getLocale() === 'bn' ? 'অগ্রিম প্রয়োজন' : 'Advance Required' }}</td>
          <td><strong class="text-red">৳{{ number_format($booking->total_amount / 2) }}</strong></td>
        </tr>
      </table>
    </div>

    {{-- What Happens Next --}}
    <div class="confirm-steps-card">
      <h2><i class="ph ph-list-numbers"></i> {{ __('site.booking_what_next') }}</h2>
      <div class="confirm-steps">
        <div class="confirm-step">
          <div class="step-num">১</div>
          <div class="step-text">{{ __('site.booking_step1') }}</div>
        </div>
        <div class="confirm-step">
          <div class="step-num">২</div>
          <div class="step-text">{{ __('site.booking_step2') }}</div>
        </div>
        <div class="confirm-step">
          <div class="step-num">৩</div>
          <div class="step-text">{{ __('site.booking_step3') }}</div>
        </div>
        <div class="confirm-step">
          <div class="step-num">৪</div>
          <div class="step-text">{{ __('site.booking_step4') }}</div>
        </div>
      </div>
    </div>

    <p class="confirm-note">
      <i class="ph ph-info"></i>
      {{ __('site.booking_pending_note') }}
    </p>

    <div class="confirm-actions">
      <button onclick="window.print()" class="btn-confirm-print">
        <i class="ph ph-printer"></i> {{ __('site.print_receipt') }}
      </button>
      <a href="{{ route('home') }}" class="btn-confirm-home">
        <i class="ph ph-house"></i> {{ __('site.go_home') }}
      </a>
    </div>

  </div>
</div>
@endsection
