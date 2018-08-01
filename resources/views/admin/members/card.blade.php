@extends('layout.report')

@section('title', $member->users[0]->firstname . ' ' . $member->users[0]->lastname.'\'s Membership Card')

@section('content')

  <style>
    .blue.card {
      background: linear-gradient(rgba(255,255,255,1), rgba(255,255,255,0.5)), url('{{ asset(App\Setting::find(1)->cover) }}') !important;
      background-size: cover !important;
      width: 320px !important;
      height: 202px !important;
    }

    @media print {
      .ui.icon.buttons {
        display: none !important;
      }
    }
  </style>

  <div class="ui icon right floated buttons" style="margin-bottom:2rem">
    <div onclick="window.print()" class="ui black button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui red button"><i class="close icon"></i></div>
  </div>

  <div class="ui blue card" style="margin:0 0 0 0">
      <div class="content">
        <img src="/{{ App\Setting::find(1)->logo }}" alt="" class="left floated mini ui image">
        <div class="right floated meta"># {{ $member->id }}</div>
        <div class="header">{{ $member->users[$request->index]->fullname }}</div>
        <div class="meta">
          <div class="ui basic black tiny label" style="background-color:transparent !important">
            <i class="address card icon"></i>
            {{ $member->type->name }}
            @if($request->index != 0)
              ( Secondary )
            @endif
          </div>
        </div>
        <div class="meta">
          Expires on {{ Date::parse($member->end)->format('l, F j, Y') }}
        </div>
      </div>
      <div class="extra content">
        &copy; {{ Date::now()->format('Y') }} {{ App\Setting::find(1)->organization }}
        <div class="right floated meta">
          <img src="/astral-logo-dark.png" style="width:20px; height: 20px">
        </div>
      </div>
    </div>


@endsection
