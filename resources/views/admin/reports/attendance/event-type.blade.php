@extends('layout.report')

@section('title', "Attendance Report - {$event_type->name}")

@section('content')

  <?php

    $total_tickets = 0;
    $total_sales = 0;
    $total_revenue = 0;

  ?>

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
    <div class="content">Attendance Report - {{ $event_type->name  }}</div>
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
        {{ $sales->count() }}
      </div>
      <div class="label">
        Sales
      </div>
    </div>
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        {{ $events->count() }}
      </div>
      <div class="label">
        Events
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ \App\Ticket::whereIn('event_id', $events->pluck('id'))->count() }}
      </div>
      <div class="label">
        Tickets Purchased
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        <i class="dollar icon"></i> {{ number_format($sales->sum('total'), 2, '.', ',') }}
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
        <th>Sales</th>
        <th>Tickets Purchased</th>
        <th>Revenue</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($events as $event)
        @if ($event->sales->count() > 0)
        <tr>

        {{-- Name --}}
        <td>
          <h5 class="ui header">{{ $event->show->name }}</h5>
        </td>

        {{-- Sales --}}
        <td>
          <?php

            $total_sales += $event->sales->count();

            echo $event->sales->count()

          ?>
        </td>

        {{-- Tickets Purchased --}}
        <td>
          <?php
          $number_of_tickets = 0;
            foreach ($sales as $sale)
            {
              $number_of_tickets += $sale->tickets->where('event_id', $event->id)->count();
            }
            $total_tickets += $number_of_tickets;
            echo $number_of_tickets
          ?>
        </td>

        {{-- Revenue --}}
        <td>
          $
          <?php

              $total_revenue += $event->sales->sum('total');

              echo number_format($event->sales->sum('total'), 2, '.', ',')
          ?>
        </td>
      </tr>
        @endif
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th class="right aligned"><h5 class="ui header">Totals:</h5></th>
        <th><h5 class="ui header">{{ $total_sales }}</h5></th>
        <th><h5 class="ui header">{{ $total_tickets }}</h5></th>
        <th><h5 class="ui header">$ {{ number_format($total_revenue, 2, '.', ',') }}</h5></th>
      </tr>
    </tfoot>
  </table>

@endsection
