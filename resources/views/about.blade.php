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

      {{-- Facilities --}}
      <section class="widget block-widget" id="facilities" style="background:#fff; border-radius:var(--radius-medium); padding:var(--spacing-large); box-shadow:var(--shadow-small); margin-bottom:var(--spacing-large);">
        @if(app()->getLocale() === 'bn')
          <h2 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
            <i class="ph ph-buildings"></i> সুযোগ-সুবিধা ও অবকাঠামো
          </h2>
          <p style="margin-bottom:var(--spacing-medium);">চট্টগ্রাম বন্দর রিপাবলিক ক্লাব তার সদস্য ও অতিথিদের জন্য আধুনিক ও পূর্ণাঙ্গ সুযোগ-সুবিধা নিশ্চিত করে। নিচে ক্লাবের প্রধান অবকাঠামো ও সেবাসমূহ তুলে ধরা হলো:</p>
          <div class="container-row" style="gap:var(--spacing-medium);">
            @foreach([
              ['ph-building','বিশাল অনুষ্ঠান হল','১,০০০ আসনবিশিষ্ট শীতাতপ নিয়ন্ত্রিত মিলনায়তন, বিবাহ অনুষ্ঠান, সেমিনার ও কর্পোরেট ইভেন্টের জন্য উপযুক্ত।'],
              ['ph-grass','উন্মুক্ত মাঠ ও লন','প্রায় ২ একর উন্মুক্ত খেলার মাঠ, বহিরাঙ্গন অনুষ্ঠান ও ক্রীড়া আয়োজনের জন্য ব্যবহারযোগ্য।'],
              ['ph-fork-knife','রেস্তোরাঁ ও ক্যাটারিং','প্রশিক্ষিত শেফ দ্বারা পরিচালিত ইন-হাউস রেস্তোরাঁ, বিভিন্ন অনুষ্ঠানে ক্যাটারিং সেবা প্রদান করে।'],
              ['ph-monitor-play','অডিও-ভিজ্যুয়াল সরঞ্জাম','আধুনিক প্রজেক্টর, এলইডি স্ক্রিন, সাউন্ড সিস্টেম ও স্টেজ আলোকসজ্জার সম্পূর্ণ ব্যবস্থা।'],
              ['ph-car','পার্কিং সুবিধা','প্রায় ২০০টি যানবাহনের জন্য নিরাপদ পার্কিং এরিয়া, ২৪ ঘণ্টা নিরাপত্তা প্রহরায়।'],
              ['ph-first-aid','জেনারেটর ও বিদ্যুৎ ব্যবস্থা','নিরবচ্ছিন্ন বিদ্যুৎ সরবরাহের জন্য উচ্চক্ষমতাসম্পন্ন জেনারেটর সুবিধা।'],
              ['ph-wifi','ওয়াই-ফাই ইন্টারনেট','সম্পূর্ণ ক্লাব প্রাঙ্গণে হাই-স্পিড ওয়্যারলেস ইন্টারনেট সংযোগ।'],
              ['ph-toilet','পরিচ্ছন্ন ওয়াশরুম','পুরুষ ও মহিলাদের জন্য পৃথক পরিষ্কার-পরিচ্ছন্ন ওয়াশরুম সুবিধা।'],
              ['ph-baby','শিশু বিনোদন কর্নার','শিশুদের জন্য বিশেষ খেলার জায়গা ও বিনোদন কর্নার।'],
              ['ph-lock','নিরাপত্তা ব্যবস্থা','সিসিটিভি ক্যামেরা ও প্রশিক্ষিত নিরাপত্তাকর্মী দ্বারা পুরো প্রাঙ্গণ সুরক্ষিত।'],
            ] as [$icon, $title, $desc])
            <div class="container-col-6" style="margin-bottom:var(--spacing-medium);">
              <div style="display:flex;gap:12px;align-items:flex-start;background:#f8f9fa;border-radius:var(--radius-small);padding:16px;">
                <i class="ph {{ $icon }}" style="font-size:1.8rem;color:var(--color-primary-bg);flex-shrink:0;margin-top:2px;"></i>
                <div>
                  <strong style="display:block;margin-bottom:4px;color:var(--color-dark-dark);">{{ $title }}</strong>
                  <span style="font-size:var(--text-small);color:#555;line-height:1.5;">{{ $desc }}</span>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        @else
          <h2 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-medium);">
            <i class="ph ph-buildings"></i> Facilities &amp; Infrastructure
          </h2>
          <p style="margin-bottom:var(--spacing-medium);">Chittagong Port Republic Club offers a comprehensive range of modern facilities for its members and guests. Below are the key amenities available at the club premises:</p>
          <div class="container-row" style="gap:var(--spacing-medium);">
            @foreach([
              ['ph-building','Grand Event Hall','Air-conditioned banquet hall with a capacity of 1,000 guests — ideal for weddings, seminars, corporate events and cultural programmes.'],
              ['ph-grass','Open Field &amp; Lawn','Approximately 2 acres of open grounds available for outdoor functions, sports tournaments and recreational activities.'],
              ['ph-fork-knife','Restaurant &amp; Catering','In-house restaurant managed by trained chefs, offering on-site catering packages for all types of events.'],
              ['ph-monitor-play','Audio-Visual Equipment','Full AV setup including HD projectors, LED screens, professional sound systems and stage lighting.'],
              ['ph-car','Ample Parking','Secure parking area accommodating approximately 200 vehicles with 24-hour security surveillance.'],
              ['ph-first-aid','Backup Power','High-capacity generator ensuring uninterrupted electricity supply throughout all events.'],
              ['ph-wifi','High-Speed Wi-Fi','Wireless internet connectivity across the entire club premises for guests and event organisers.'],
              ['ph-toilet','Modern Washrooms','Separate, well-maintained washrooms for male and female guests throughout the venue.'],
              ['ph-baby','Kids Play Corner','Dedicated play area and entertainment corner designed for younger guests.'],
              ['ph-lock','Security System','24-hour CCTV surveillance and trained security personnel to ensure a safe environment.'],
            ] as [$icon, $title, $desc])
            <div class="container-col-6" style="margin-bottom:var(--spacing-medium);">
              <div style="display:flex;gap:12px;align-items:flex-start;background:#f8f9fa;border-radius:var(--radius-small);padding:16px;">
                <i class="ph {{ $icon }}" style="font-size:1.8rem;color:var(--color-primary-bg);flex-shrink:0;margin-top:2px;"></i>
                <div>
                  <strong style="display:block;margin-bottom:4px;color:var(--color-dark-dark);">{!! $title !!}</strong>
                  <span style="font-size:var(--text-small);color:#555;line-height:1.5;">{!! $desc !!}</span>
                </div>
              </div>
            </div>
            @endforeach
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
