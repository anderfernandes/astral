@extends('layout.report')

@if ($request->has('index'))
  @section('title', " {$member->secondaries[$request->index]->fullname}'s Membership Card")
@else
  @section('title', " {$member->primary->fullname}'s Membership Card")
@endif

@section('content')

  <style>
    .blue.card {
      background: linear-gradient(rgba(255,255,255,1), rgba(255,255,255,0.5)), url('{{ \App\Setting::find(1)->cover == '/cover.jpg' ? \App\Setting::find(1)->cover : Storage::url(\App\Setting::find(1)->cover) }}') !important;
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
        <img src="{{ \App\Setting::find(1)->logo == '/logo.png' ? App\Setting::find(1)->logo : Storage::url(\App\Setting::find(1)->logo) }}" alt="" class="left floated mini ui image">
        <div class="right floated meta"># {{ $member->id }}</div>
        <div class="header">
          {{ $request->has('index') ? $member->secondaries[$request->index]->fullname : $member->primary->fullname }}
        </div>
        <div class="meta">
          <div class="ui basic black tiny label" style="background-color:transparent !important">
            <i class="address card icon"></i>
            {{ $member->type->name }}
            @if ($request->has('index'))
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
        <br />
        <?php
          $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
          echo '<img class="ui small image" src="data:image/png;base64,' . base64_encode($generator->getBarcode($member->id, $generator::TYPE_UPC_A)) . '" />'
        ?>


      </div>
    </div>


@endsection
