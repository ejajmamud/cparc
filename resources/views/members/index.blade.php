@extends('layouts.app')

@section('title', app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটি | চট্টগ্রাম বন্দর রিপাবলিক ক্লাব' : 'Executive Committee | Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-users"></i> {{ app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটি' : 'Executive Committee' }}
  </h1>

  @if($members->count())
    <section class="widget person-card-stack-widget">
      <div class="person-card-stack-list container-row">
        @foreach($members as $member)
          <div class="container-col-3" style="margin-bottom:var(--spacing-large);">
            <div class="person-card-widget"
                 style="background:#fff; border-radius:var(--radius-medium); overflow:hidden; box-shadow:var(--shadow-small); text-align:center; padding-bottom:var(--spacing-medium);">
              <div class="person-card-image-wrapper" style="background:var(--color-normal-light); height:180px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                <img class="person-card-image"
                     src="{{ $member->photo ? asset('storage/' . $member->photo) : asset('images/club/logo.jpeg') }}"
                     alt="{{ app()->getLocale() === 'bn' && $member->name_bn ? $member->name_bn : $member->name }}"
                     style="width:100%; height:180px; object-fit:cover; object-position:center center; background:var(--color-normal-light);"
                     onerror="this.src='{{ asset('images/club/logo.jpeg') }}'">
              </div>
              <div class="person-card-info" style="padding:var(--spacing-medium);">
                <p class="person-card-name" style="font-weight:600; font-size:var(--text-large); margin:0 0 4px;">
                  {{ app()->getLocale() === 'bn' && $member->name_bn ? $member->name_bn : $member->name }}
                </p>
                <p class="person-card-designation" style="color:var(--color-primary-bg); font-size:var(--text-medium); margin:0 0 8px;">
                  {{ app()->getLocale() === 'bn' && $member->designation_bn ? $member->designation_bn : $member->designation }}
                </p>
                @if($member->phone)
                  <p style="font-size:var(--text-small); color:#555; margin:0;">
                    <i class="ph ph-phone"></i> {{ $member->phone }}
                  </p>
                @endif
                @if($member->email)
                  <p style="font-size:var(--text-small); color:#555; margin:4px 0 0;">
                    <i class="ph ph-envelope"></i> {{ $member->email }}
                  </p>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </section>
  @else
    <p style="color:#666;">{{ app()->getLocale() === 'bn' ? 'কার্যনির্বাহী কমিটির তথ্য শীঘ্রই আপডেট করা হবে।' : 'Executive committee information will be updated soon.' }}</p>
  @endif

</div>
@endsection
