@extends('layout.report')

@section('title', "Attendance Report")

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
    }
  </style>

  <div class="ui icon right floated buttons" style="margin-bottom:4rem">
    <div onclick="window.print()" class="ui primary button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui secondary button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <div class="ui center aligned icon header" style="margin-top:8px">
    <div class="content">Attendance Report - Ticket Type</div>
    <div class="sub header">
      {{ Date::parse($start)->format('l, F j, Y') }} | {{ Date::parse($end)->format('l, F j, Y') }}
    </div>
  </div>

  <h4 class="ui header">
    {{ now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  {{-- Overview --}}
  <div class="ui horizontal divider header">
    <i class="file alternate outline icon"></i>
    Overview
  </div>
  <div class="ui three mini statistics">
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        <?php
          $ticket_types = \App\TicketType::all();
          $totalTicketsSold = 0;
          $totalRevenue = 0;
          echo $ticket_types->count();
        ?>
      </div>
      <div class="label">
        Ticket Options
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
        <i class="dollar icon"></i>
        {{ number_format($sales->sum('subtotal'), 2) }}
      </div>
      <div class="label">
        Revenue
      </div>
    </div>
  </div>

  <table class="ui celled table">
    <thead>
      <tr>
        <th>Ticket Information</th>
        <th>Tickets Sold</th>
        <th>Revenue</th>
      </tr>
    </thead>
      @foreach ($ticket_types as $ticket_type)
      <tr>
        <td>
          <div class="ui black label">
            <i class="ticket icon"></i>
            {{ $ticket_type->name }}
            <div class="detail">
              $ {{ number_format($ticket_type->price, 2, ".", ".") }}
            </div>
          </div>
        </td>
        <td>
          <?php
            $ticketsSold = 0;
            foreach ($sales as $sale)
            {
              $ticketsSold += $sale->tickets->where('ticket_type_id', $ticket_type->id)->count();
            }
            $totalTicketsSold += $ticketsSold;
            echo $ticketsSold;
          ?>
        </td>
        <td>
          $
          <?php
             $revenue = number_format($ticketsSold * $ticket_type->price, 2, ".", ",");
             $totalRevenue += $revenue;
             echo $revenue;
          ?>
        </td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th class="right aligned"><h5 class="ui header">Totals:</h5></th>
        <th><h5 class="ui header">{{ $totalTicketsSold }}</h5></th>
        <th><h5 class="ui header">$ {{ number_format($totalRevenue, 2, ".", ",") }}</h5></th>
      </tr>
    </tfoot>
  </table>

@endsection
