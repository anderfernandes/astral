@extends('layout.report')

@section('title', $member->users[0]->firstname . ' ' . $member->users[0]->lastname.'\'s Membership Card')

@section('content')

  <style>
    .blue.card {
      background: linear-gradient(rgba(255,255,255,1), rgba(255,255,255,0.5)), url('{{ asset(App\Setting::find(1)->cover) }}') !important;
      background-size: contain !important;
    }
  </style>

  <div class="ui two doubling raised stackable cards">
    <div class="blue card">
      <div class="content">
        <img src="/{{ App\Setting::find(1)->logo }}" alt="" class="left floated tiny ui image">
        <div class="right floated meta"># {{ $member->id }}</div>
        <div class="header">{{ $member->users[0]->firstname }} {{ $member->users[0]->lastname }}</div>
        <div class="meta">
          <div class="ui blue label">
            <i class="address card icon"></i>
            {{ $member->type->name }}
          </div>
        </div>
        <div class="meta">
          Expires {{ Date::parse($member->end)->format('l, F j, Y') }}
        </div>
      </div>
      <div class="extra content">
        &copy; {{ Date::now()->format('Y') }} {{ App\Setting::find(1)->organization }}
        <div class="right floated meta"><i class="sun icon"></i></div>
      </div>
    </div>
  </div>

@endsection
