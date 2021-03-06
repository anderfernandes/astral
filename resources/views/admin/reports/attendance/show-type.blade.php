@extends('layout.report')

@section('title', "Attendance Report - {$showType} Shows")

@section('content')

  <style>
    @media print {
      .ui.icon.buttons {
        display: none !important;
      }
      p, h4.ui.header, table, thead, tbody, ul, li, h4.ui.header .sub.header {
        font-size: 0.78rem !important;
      }
      canvas {
        min-height: 100%;
        max-height: 100%;
        max-width: 100%;
        height: auto !important;
        width: auto !important;
      }
      img.ui.centered.mini.image { margin-top: 0 }
    }
  </style>

  <div class="ui icon right floated buttons" style="margin-bottom:5rem">
    <div onclick="window.print()" class="ui primary button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui secondary button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <div class="ui center aligned icon header" style="margin-top:8px">
    <div class="content">Attendance Report - {{ $showType  }} Shows</div>
    <div class="sub header">
      {{ Date::parse($start)->format('l, F j, Y') }} | {{ Date::parse($end)->format('l, F j, Y') }}
    </div>
  </div>

  <h4 class="ui header">
    {{ Date::now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  {{-- Overview --}}
  <div class="ui horizontal divider header">
    <i class="file alternate outline icon"></i>
    Overview
  </div>
  <div class="ui four mini statistics">
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        {{ $events->unique('id')->count() }}
      </div>
      <div class="label">
        Events
      </div>
    </div>
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        {{ $shows->count() }}
      </div>
      <div class="label">
          {{ $shows->count() == 1 ? "Show" : "Shows" }}
      </div>
    </div>
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        <?php
          $tickets = 0;
          foreach ($events as $event)
            $tickets += $event->tickets->count();
          echo $tickets;
        ?>
      </div>
      <div class="label">
          Tickets Sold
      </div>
    </div>
    <div class="statistic" style="margin-right: 0">
        <div class="value">
          $ {{ number_format($sales->sum('subtotal'), 2, '.', ',') }}
        </div>
        <div class="label">
          Revenue
        </div>
      </div>
  </div>

  <table class="ui celled table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Tickets Sold</th>
        <th>Revenue</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($events as $event)  
        @if ($event->tickets->count() > 0)
        <tr>
          {{-- Name --}}
          <td>
            <div class="ui tiny header">
              {{ $event->show->name }} (#{{ $event->id }})
              <div class="sub header">
                {{ $event->start->format('l, F j, Y \a\t g:i A') }}
              </div>
            </div>
          </td>

          {{-- Tickets Purchased --}}
          <td class="right aligned">
            {{ $event->tickets->count() }}
          </td>

          {{-- Revenue --}}
          <td class="right aligned">
            $ {{ number_format($event->sales->sum('subtotal'), 2, '.', ',') }}
          </td>
        </tr>
        @endif
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th class="right aligned">
          <h5 class="ui header">Totals:</h5>
        </th>
        <th class="right aligned">
          <h5 class="ui header">
            {{ $tickets }}
          </h5>
        </th>
        <th class="right aligned">
          <h5 class="ui header">
            $ {{ number_format($sales->sum('subtotal'), 2, '.', ',') }}
          </h5>
        </th>
      </tr>
    </tfoot>
  </table>

@endsection
