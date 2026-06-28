@extends('layouts.app')

@section('title', __('site.hall_booking') . ' | ' . __('site.club_name'))
@section('description', __('site.hall_booking_subtitle'))

@section('content')
<div style="max-width:var(--container-large);margin:0 auto;padding:var(--spacing-large) var(--spacing-medium);">

  {{-- Page Hero --}}
  <div class="cprc-page-hero">
    <i class="ph ph-buildings cprc-page-hero-icon"></i>
    <div>
      <h1 class="cprc-page-title">{{ __('site.hall_booking') }}</h1>
      <p class="cprc-page-subtitle">{{ __('site.hall_booking_subtitle') }}</p>
    </div>
  </div>

  {{-- About the Venue --}}
  <div class="cprc-venue-info">
    <div class="cprc-venue-text">
      <h2 class="section-heading"><i class="ph ph-map-pin"></i>
        {{ app()->getLocale() === 'bn' ? 'আমাদের ভেন্যু সম্পর্কে' : 'About Our Venue' }}
      </h2>
      @if(app()->getLocale() === 'bn')
        <p>চট্টগ্রাম বন্দর রিপাবলিক ক্লাব (সিপিআরসি) চট্টগ্রামের বন্দর এলাকায় অবস্থিত একটি বিশাল ও ঐতিহ্যবাহী কমিউনিটি ক্লাব। আমাদের রয়েছে একাধিক হল, বিশাল খোলা মাঠ, সবুজ বাগান এবং আধুনিক সুযোগ-সুবিধা।</p>
        <p>আমাদের ভেন্যু বিবাহ অনুষ্ঠান, আকদ ও হলুদ অনুষ্ঠান, জন্মদিন পার্টি, কর্পোরেট কনফারেন্স, সাংস্কৃতিক উৎসব এবং যেকোনো সামাজিক অনুষ্ঠানের জন্য আদর্শ।</p>
        <ul class="cprc-venue-features">
          <li><i class="ph ph-check-circle"></i> সর্বোচ্চ ৮০০+ অতিথি ধারণ ক্ষমতা</li>
          <li><i class="ph ph-check-circle"></i> বিশাল পার্কিং সুবিধা</li>
          <li><i class="ph ph-check-circle"></i> ২৪ ঘণ্টা জেনারেটর ব্যাকআপ</li>
          <li><i class="ph ph-check-circle"></i> আধুনিক সাউন্ড সিস্টেম</li>
          <li><i class="ph ph-check-circle"></i> ড্রেসিং রুম ও ব্রাইডাল স্যুট</li>
          <li><i class="ph ph-check-circle"></i> ক্যাটারিং রান্নাঘর</li>
          <li><i class="ph ph-check-circle"></i> সবুজ আঙিনা ও আউটডোর স্থান</li>
          <li><i class="ph ph-check-circle"></i> নিরাপত্তা ও সিসিটিভি ব্যবস্থা</li>
        </ul>
      @else
        <p>Chittagong Port Republic Club (CPRC) is a sprawling traditional community club located in the Port Area of Chittagong. We offer multiple halls, vast open grounds, green gardens, and modern amenities.</p>
        <p>Our venue is ideal for wedding ceremonies, holud & akad, birthday parties, corporate conferences, cultural festivals, and any social gathering.</p>
        <ul class="cprc-venue-features">
          <li><i class="ph ph-check-circle"></i> Capacity for 800+ guests</li>
          <li><i class="ph ph-check-circle"></i> Spacious parking facility</li>
          <li><i class="ph ph-check-circle"></i> 24-hour generator backup</li>
          <li><i class="ph ph-check-circle"></i> Modern sound system</li>
          <li><i class="ph ph-check-circle"></i> Dressing rooms & bridal suite</li>
          <li><i class="ph ph-check-circle"></i> Catering kitchen</li>
          <li><i class="ph ph-check-circle"></i> Green courtyard & outdoor spaces</li>
          <li><i class="ph ph-check-circle"></i> Security & CCTV surveillance</li>
        </ul>
      @endif
    </div>
    <div class="cprc-venue-gallery">
      <img src="{{ asset('images/club/venue_1.jpeg') }}" alt="CPRC Venue" onerror="this.style.display='none'">
      <img src="{{ asset('images/club/venue_7.jpeg') }}" alt="CPRC Venue" onerror="this.style.display='none'">
    </div>
  </div>

  {{-- Packages --}}
  <h2 class="section-heading" style="margin-bottom:var(--spacing-large);"><i class="ph ph-tag"></i>
    {{ app()->getLocale() === 'bn' ? 'বুকিং প্যাকেজসমূহ' : 'Booking Packages' }}
  </h2>

  <div class="cprc-pkg-grid cprc-pkg-grid-full">
    {{-- General / Outsider --}}
    <div class="cprc-pkg-card cprc-pkg-featured">
      <div class="cprc-pkg-badge">{{ app()->getLocale() === 'bn' ? 'সাধারণ বুকিং' : 'General Booking' }}</div>
      <div class="cprc-pkg-duration">
        <i class="ph ph-users"></i>
        {{ app()->getLocale() === 'bn' ? 'সাধারণ জনগণের জন্য' : 'For General Public' }}
      </div>
      <h3 class="cprc-pkg-name">{{ app()->getLocale() === 'bn' ? 'সাধারণ / বহিরাগত প্যাকেজ' : 'General / Outsider Package' }}</h3>
      <div class="cprc-pkg-price">
        <span class="cprc-pkg-note">৳</span>
        <span class="cprc-pkg-amount">{{ app()->getLocale() === 'bn' ? '১৮,০০০' : '18,000' }}</span>
        <span class="cprc-pkg-per">/ {{ app()->getLocale() === 'bn' ? 'সেশন (দিন)' : 'Session (Day)' }}</span>
      </div>
      <p class="cprc-pkg-desc">
        {{ app()->getLocale() === 'bn' 
          ? 'বিবাহ অনুষ্ঠান, বড় রিসেপশন, কর্পোরেট কনফারেন্স এবং জাতীয় পর্যায়ের সাংস্কৃতিক উৎসবের জন্য সেরা ভেন্যু।' 
          : 'Ideal venue for weddings, grand receptions, corporate conferences, and large cultural festivals.' }}
      </p>
      <ul class="cprc-pkg-features">
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'মূল হল ব্যবহার (৮০০+ ধারণক্ষমতা)' : 'Main Hall Access (800+ Capacity)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'মাঠ সহ বুকিংয়ের সুবিধা (+৳১০,০০০ BDT)' : 'Optional Field Rental (+৳10,000 BDT)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'রাত শিফটে বুকিংয়ের ব্যবস্থা (+৳২,০০০ বিদ্যুৎ বিল)' : 'Night Shift Booking Surcharge (+৳2,000)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? '২টি সজ্জিত ড্রেসিং রুম ও ওয়াশরুম' : '2 Decorated Dressing Rooms & Washrooms' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'জেনারেটর ব্যাকআপ ও ২৪ ঘণ্টা নিরাপত্তা' : 'Generator Backup & 24/7 Security' }}</li>
      </ul>
      <a href="{{ route('booking.form') }}" class="cprc-pkg-btn cprc-pkg-btn-featured">
        <i class="ph ph-calendar-check"></i> {{ __('site.book_now') }}
      </a>
    </div>

    {{-- CPA Staff --}}
    <div class="cprc-pkg-card">
      <div class="cprc-pkg-badge" style="background:#16a249;">{{ app()->getLocale() === 'bn' ? 'বিশেষ ছাড়' : 'Special Discount' }}</div>
      <div class="cprc-pkg-duration">
        <i class="ph ph-anchor"></i>
        {{ app()->getLocale() === 'bn' ? 'চবক কর্মকর্তা-কর্মচারীদের জন্য' : 'For CPA Officials & Staff' }}
      </div>
      <h3 class="cprc-pkg-name">{{ app()->getLocale() === 'bn' ? 'চবক কর্মকর্তা-কর্মচারী প্যাকেজ' : 'CPA Staff Package' }}</h3>
      <div class="cprc-pkg-price">
        <span class="cprc-pkg-note">৳</span>
        <span class="cprc-pkg-amount">{{ app()->getLocale() === 'bn' ? '৫,০০০' : '5,000' }}</span>
        <span class="cprc-pkg-per">/ {{ app()->getLocale() === 'bn' ? 'সেশন (দিন)' : 'Session (Day)' }}</span>
      </div>
      <p class="cprc-pkg-desc">
        {{ app()->getLocale() === 'bn' 
          ? 'চট্টগ্রাম বন্দর কর্তৃপক্ষের কর্মকর্তা ও কর্মচারীদের পারিবারিক অনুষ্ঠানের জন্য বিশেষ সুবিধাজনক বুকিং প্যাকেজ।' 
          : 'Highly discounted rates for the officers and staff of the Chittagong Port Authority.' }}
      </p>
      <ul class="cprc-pkg-features">
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'মূল হলের সম্পূর্ণ সুবিধা ব্যবহার' : 'Full Main Hall Access' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'মাঠ সহ বুকিংয়ের সুবিধা (+৳১০,০০০ BDT)' : 'Optional Field Rental (+৳10,000 BDT)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'রাত শিফটে বুকিংয়ের ব্যবস্থা (+৳১,৫০০ বিদ্যুৎ বিল)' : 'Night Shift Booking Surcharge (+৳1,500)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'চবক পরিচয়পত্র (CPA ID Card) আপলোড বাধ্যতামূলক' : 'Verification Required (CPA ID Card Upload)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'সকল সুযোগ-সুবিধা ও ব্যাকআপ অন্তর্ভুক্ত' : 'All standard facilities & backup included' }}</li>
      </ul>
      <a href="{{ route('booking.form') }}" class="cprc-pkg-btn">
        <i class="ph ph-calendar-check"></i> {{ __('site.book_now') }}
      </a>
    </div>

    {{-- Club Member --}}
    <div class="cprc-pkg-card">
      <div class="cprc-pkg-badge" style="background:#6b21a8;">{{ app()->getLocale() === 'bn' ? 'ক্লাব প্রিভিলেজ' : 'Club Privilege' }}</div>
      <div class="cprc-pkg-duration">
        <i class="ph ph-identification-card"></i>
        {{ app()->getLocale() === 'bn' ? 'রিপাবলিক ক্লাব সদস্যদের জন্য' : 'For Republic Club Members' }}
      </div>
      <h3 class="cprc-pkg-name">{{ app()->getLocale() === 'bn' ? 'রিপাবলিক ক্লাব সদস্য প্যাকেজ' : 'Republic Club Member Package' }}</h3>
      <div class="cprc-pkg-price">
        <span class="cprc-pkg-note">৳</span>
        <span class="cprc-pkg-amount">{{ app()->getLocale() === 'bn' ? '৩,০০০' : '3,000' }}</span>
        <span class="cprc-pkg-per">/ {{ app()->getLocale() === 'bn' ? 'সেশন (দিন)' : 'Session (Day)' }}</span>
      </div>
      <p class="cprc-pkg-desc">
        {{ app()->getLocale() === 'bn' 
          ? 'চট্টগ্রাম বন্দর রিপাবলিক ক্লাবের সম্মানিত সদস্যদের জন্য প্রিভিলেজ বুকিং রেট এবং বিশেষ অগ্রাধিকার।' 
          : 'Exclusive privilege pricing and booking priority for members of the Chittagong Port Republic Club.' }}
      </p>
      <ul class="cprc-pkg-features">
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'হল ও ভিআইপি লাউঞ্জ ব্যবহারের অগ্রাধিকার' : 'Priority Access to Hall & VIP Lounge' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'মাঠ সহ বুকিংয়ের সুবিধা (+৳১০,০০০ BDT)' : 'Optional Field Rental (+৳10,000 BDT)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'রাত শিফটে বুকিংয়ের ব্যবস্থা (+৳১,৫০০ বিদ্যুৎ বিল)' : 'Night Shift Booking Surcharge (+৳1,500)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'সদস্য কার্ড বা যাচাইকরণ পত্র আপলোড বাধ্যতামূলক' : 'Verification Required (Member ID Card/Paper)' }}</li>
        <li><i class="ph ph-check-circle"></i> {{ app()->getLocale() === 'bn' ? 'বিশেষ ডেকোরেশন ও সাজসজ্জা সেশন' : 'Special Decoration & stage setup assistance' }}</li>
      </ul>
      <a href="{{ route('booking.form') }}" class="cprc-pkg-btn">
        <i class="ph ph-calendar-check"></i> {{ __('site.book_now') }}
      </a>
    </div>
  </div>

  {{-- CTA --}}
  <div class="cprc-booking-cta" style="margin-top:var(--spacing-large);">
    <i class="ph ph-phone-call cprc-cta-icon"></i>
    <div>
      <strong>{{ app()->getLocale() === 'bn' ? 'কাস্টম প্যাকেজ প্রয়োজন?' : 'Need a Custom Package?' }}</strong>
      <p>{{ app()->getLocale() === 'bn' ? 'আমাদের সাথে সরাসরি যোগাযোগ করুন। আমরা আপনার বাজেট ও প্রয়োজন অনুযায়ী বিশেষ ব্যবস্থা করব।' : 'Contact us directly. We can arrange special packages based on your budget and requirements.' }}</p>
    </div>
    <div class="cprc-cta-btns">
      <a href="tel:+8803125000000" class="cprc-cta-phone"><i class="ph ph-phone"></i> +880-31-2500000</a>
      <a href="https://wa.me/8801XXXXXXXXX" class="cprc-cta-whatsapp" target="_blank">
        <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        WhatsApp
      </a>
      <a href="{{ route('contact') }}" class="cprc-cta-phone"><i class="ph ph-envelope"></i> {{ __('site.contact') }}</a>
    </div>
  </div>

</div>

@push('styles')
<style>
.cprc-page-hero {
  display: flex; align-items: center; gap: 20px;
  background: linear-gradient(135deg, var(--color-primary-bg) 0%, var(--color-primary-light) 100%);
  color: #fff; padding: 24px 28px; border-radius: var(--radius-large);
  margin-bottom: var(--spacing-large);
}
.cprc-page-hero-icon { font-size: 44px; flex-shrink: 0; opacity: 0.85; }
.cprc-page-title { font-size: 1.5rem; font-weight: 800; margin: 0 0 4px; }
.cprc-page-subtitle { font-size: 0.9rem; opacity: 0.85; margin: 0; }

.cprc-venue-info {
  display: grid; grid-template-columns: 1.3fr 1fr;
  gap: var(--spacing-large); margin-bottom: var(--spacing-large);
  background: #fff; border-radius: var(--radius-medium);
  box-shadow: var(--shadow-small); padding: var(--spacing-large);
}
.cprc-venue-text p { font-size: 0.88rem; color: #444; line-height: 1.7; margin: 0 0 12px; }
.cprc-venue-features { list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.cprc-venue-features li { display: flex; align-items: center; gap: 7px; font-size: 0.82rem; color: #333; }
.cprc-venue-features li .ph-check-circle { color: #28a745; flex-shrink: 0; }
.cprc-venue-gallery { display: grid; grid-template-rows: 1fr 1fr; gap: 8px; }
.cprc-venue-gallery img { width: 100%; height: 100%; object-fit: cover; object-position: center; border-radius: var(--radius-small); }

.cprc-pkg-grid-full { grid-template-columns: repeat(3, 1fr); margin-bottom: 0; }

@media (max-width: 900px) {
  .cprc-venue-info { grid-template-columns: 1fr; }
  .cprc-venue-gallery { grid-template-rows: auto; grid-template-columns: 1fr 1fr; }
  .cprc-venue-gallery img { height: 160px; }
  .cprc-pkg-grid-full { grid-template-columns: 1fr; }
  .cprc-venue-features { grid-template-columns: 1fr; }
}
</style>
@endpush
@endsection
