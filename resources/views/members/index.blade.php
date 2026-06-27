@extends('layouts.app')

@section('title', 'Executive Committee | Chittagong Port Republic Club')

@section('content')
<div style="max-width:var(--container-large); margin:0 auto; padding:var(--spacing-large) var(--spacing-medium);">

  <h1 style="color:var(--color-primary-bg); border-bottom:2px solid var(--color-primary-bg); padding-bottom:8px; margin-bottom:var(--spacing-large);">
    <i class="ph ph-users"></i> Executive Committee
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
                     src="{{ $member->photo ? asset('storage/'.$member->photo) : asset('template/site-assets/images/logo.png') }}"
                     alt="{{ $member->name }}"
                     style="width:100%; height:180px; object-fit:cover;"
                     onerror="this.src='{{ asset('template/site-assets/images/logo.png') }}'">
              </div>
              <div class="person-card-info" style="padding:var(--spacing-medium);">
                <p class="person-card-name" style="font-weight:600; font-size:var(--text-large); margin:0 0 4px;">{{ $member->name }}</p>
                <p class="person-card-designation" style="color:var(--color-primary-bg); font-size:var(--text-medium); margin:0 0 8px;">{{ $member->designation }}</p>
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
    <p style="color:#666;">Executive committee information will be updated soon.</p>
  @endif

</div>
@endsection
