@extends('layout.report')

@section('title', 'New Membership Report')

@section('content')

  <style>
    @media print {
      .ui.icon.buttons {
        display: none !important;
      }
      p, h4.ui.header, table, thead, tbody, ul, li, h4.ui.header .sub.header {
        font-size: 0.78rem !important;
      }
    }
  </style>

  <div class="ui icon right floated buttons">
    <div onclick="window.print()" class="ui primary button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui secondary button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <h2 class="ui center aligned header" style="margin-top:8px">
    <div class="content">New Members Report</div>
    <div class="sub header">Ran by {{ Auth::user()->fullname }} <br> on {{ Date::now()->format('l, F j, Y \a\t g:i A') }}</div>
  </h2>

  <p>
    These are the members who signed up <strong>between {{ Date::parse($start)->format('l, F j, Y \a\t g:i A') }}</strong> and <strong>{{ Date::parse($end)->format('l, F j, Y \a\t g:i A') }}</strong>.
  </p>

  @foreach ($memberships as $membership)
  <div class="ui items">
      @foreach ($membership->users as $member)
      <div class="item">
        <div class="content">
          <div class="header">{{ $member->fullname }}</div>
          <div class="meta">
            Membership # {{ $membership->id }}
            <div class="ui label"><i class="address card icon"></i> {{ $membership->type->name }}</div>
            @if ($loop->first)
              <div class="ui primary label">Primary</div>
            @else
              <div class="ui secondary label">2nd Card</div>
            @endif
          </div>
          <div class="description">
            <p><i class="map marker icon"></i> {{ $member->address . ' - ' . $member->city . ', ' . $member->state . ' ' . $member->zip . ' - ' . $member->country}}</p>
            <p><i class="at icon"></i> {{ $member->email }}</p>
            <p><i class="phone icon"></i> {{ $member->phone }}</p>
          </div>
          <div class="extra">
            <p><i class="calendar icon"></i>Start Date: {{ Date::parse($membership->start)->format('l, F j, Y') }} | <i class="calendar icon"></i>End Date: {{ Date::parse($membership->end)->format('l, F j, Y') }}</p>
          </div>
        </div>
      </div>
    @endforeach
    <div class="ui divider"></div>
  </div>
  @endforeach
@endsection
