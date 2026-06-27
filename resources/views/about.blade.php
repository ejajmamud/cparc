@extends('layouts.app')

@if(app()->getLocale() === 'bn')
  @section('title', 'আমাদের সম্পর্কে | চট্টগ্রাম বন্দর রিপাবলিক ক্লাব')
  @section('description', 'চট্টগ্রাম বন্দর রিপাবলিক ক্লাবের ইতিহাস, লক্ষ্য ও উদ্দেশ্য সম্পর্কে জানুন')
@else
  @section('title', 'About Us | Chittagong Port Republic Club')
  @section('description', 'Learn about the history, mission and vision of Chittagong Port Republic Club')
@endif

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <div class="container-row">
    {{-- Main content --}}
    <div class="container-col-8">

      <section class="widget block-widget" style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small); margin-bottom:var(--spacing-large);">
        @if(app()->getLocale() === 'bn')
          <h2 id="history" style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
            <i class="ph ph-buildings"></i> ইতিহাস ও পটভূমি
          </h2>
          <p><strong>চট্টগ্রাম বন্দর রিপাবলিক ক্লাব</strong> (সিপিআরসি) চট্টগ্রাম বন্দর কর্তৃপক্ষ এলাকার অভ্যন্তরে কর্মকর্তা, কর্মচারী এবং তাদের পরিবারের সদস্যদের সেবা প্রদানের লক্ষ্যে প্রতিষ্ঠিত একটি অন্যতম সামাজিক ও বিনোদনমূলক ক্লাব। সময়ের সাথে সাথে এটি পারস্পরিক সৌহার্দ্য, সংস্কৃতি এবং ক্রীড়াচর্চায় মুখরিত একটি চমৎকার সামাজিক কেন্দ্র হিসেবে গড়ে উঠেছে।</p>
          <p style="margin-top:var(--spacing-medium);">কয়েক দশকেরও বেশি সময় ধরে ক্লাবটি বন্দর সংশ্লিষ্ট জনগোষ্ঠীর সামাজিক জীবনের কেন্দ্রবিন্দু হিসেবে কাজ করছে এবং সামুদ্রিক ঐতিহ্য ও বাংলাদেশী সংস্কৃতির উদযাপনে নানাবিধ অনুষ্ঠান আয়োজন করে আসছে।</p>
        @else
          <h2 id="history" style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
            <i class="ph ph-buildings"></i> History &amp; Background
          </h2>
          <p>The <strong>Chittagong Port Republic Club</strong> (CPRC) is a premier social and recreational club established within the Chittagong Port Authority complex. Founded to serve the officers, employees and families of Chittagong Port, the club has grown into a vibrant community hub fostering camaraderie, culture and sports.</p>
          <p style="margin-top:var(--spacing-medium);">With decades of service, the club has been central to the social life of the port community, organizing events that celebrate maritime heritage and Bangladeshi culture.</p>
        @endif
      </section>

      <section class="widget block-widget" id="mission" style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small); margin-bottom:var(--spacing-large);">
        @if(app()->getLocale() === 'bn')
          <h2 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
            <i class="ph ph-target"></i> লক্ষ্য ও রূপকল্প
          </h2>
          <div class="container-row">
            <div class="container-col-6">
              <h3 style="color:var(--color-secondary-bg); margin-bottom:var(--spacing-small);">আমাদের লক্ষ্য</h3>
              <p>চট্টগ্রাম বন্দর এলাকার কর্মকর্তা, কর্মচারী ও তাদের পরিবারের সদস্যদের জন্য বিশ্বমানের বিনোদনমূলক, সাংস্কৃতিক ও সামাজিক পরিবেশ নিশ্চিত করা এবং সেই সাথে বাংলাদেশের গৌরবময় সামুদ্রিক ঐতিহ্য ধরে রাখা ও তার প্রচার করা।</p>
            </div>
            <div class="container-col-6">
              <h3 style="color:var(--color-secondary-bg); margin-bottom:var(--spacing-small);">আমাদের রূপকল্প</h3>
              <p>পোর্ট সেক্টরে ক্রীড়া, সংস্কৃতি ও সমাজসেবায় অবদান রাখার মাধ্যমে সবচেয়ে মুখরিত ও অন্তর্ভুক্তিমূলক ক্লাব হিসেবে পরিচিতি লাভ করা এবং সদস্যদের মাঝে সুদৃঢ় একতার বন্ধন গড়ে তোলা।</p>
            </div>
          </div>
        @else
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
        @endif
      </section>

      <section class="widget block-widget" id="organogram" style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small);">
        @if(app()->getLocale() === 'bn')
          <h2 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
            <i class="ph ph-tree-structure"></i> সাংগঠনিক কাঠামো
          </h2>
          <p>ক্লাবটি সাধারণ সদস্যদের দ্বারা নির্বাচিত একটি কার্যনির্বাহী কমিটি দ্বারা পরিচালিত হয়। এই কমিটি ক্লাবের সকল কার্যক্রম এবং সম্পদ তদারকি করে থাকে।</p>
          <a href="{{ route('members.index') }}" class="all-btn" style="display:inline-flex; align-items:center; margin-top:var(--spacing-medium); text-decoration:none; background:var(--color-primary-bg); color:#fff; padding:8px 16px; border-radius:var(--radius-small);">
            কার্যনির্বাহী কমিটি দেখুন <i class="ph ph-arrow-right" style="margin-left:8px;"></i>
          </a>
        @else
          <h2 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
            <i class="ph ph-tree-structure"></i> Organizational Structure
          </h2>
          <p>The club is governed by an Executive Committee elected by general members. The committee oversees all activities and manages club resources.</p>
          <a href="{{ route('members.index') }}" class="all-btn" style="display:inline-flex; align-items:center; margin-top:var(--spacing-medium); text-decoration:none; background:var(--color-primary-bg); color:#fff; padding:8px 16px; border-radius:var(--radius-small);">
            View Executive Committee <i class="ph ph-arrow-right" style="margin-left:8px;"></i>
          </a>
        @endif
      </section>

    </div>

    {{-- Sidebar --}}
    <div class="container-col-4">
      <section class="widget notice-news-card-widget">
        <div class="notice-card">
          <p class="notice-title">
            <i class="ph ph-info"></i> 
            @if(app()->getLocale() === 'bn')
              এক নজরে তথ্য
            @else
              Quick Facts
            @endif
          </p>
          <ul class="notice-unordered-list">
            <li class="notice-content-list" style="padding:8px 0;">
              <div class="notice-content-icon"><i class="ph ph-map-pin"></i></div>
              <div class="notice-text-wrap">
                <p class="notice-text">
                  @if(app()->getLocale() === 'bn')
                    বন্দর এলাকা, চট্টগ্রাম, বাংলাদেশ
                  @else
                    Port Area, Chittagong, Bangladesh
                  @endif
                </p>
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
          <a href="{{ route('contact') }}">
            @if(app()->getLocale() === 'bn')
              যোগাযোগ করুন <i class="ph ph-arrow-right"></i>
            @else
              Contact Us <i class="ph ph-arrow-right"></i>
            @endif
          </a>
        </div>
      </section>
    </div>
  </div>

</div>
@endsection
