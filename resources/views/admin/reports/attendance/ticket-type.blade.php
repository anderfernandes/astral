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
    <div class="content">Attendance Report - {{ $ticket_type->name }} Tickets</div>
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
        {{ $tickets->count() }}
      </div>
      <div class="label">
        Tickets Sold
      </div>
    </div>
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        <i class="dollar icon"></i> {{ number_format($ticket_type->price, 2, '.', ',') }}
      </div>
      <div class="label">
        Ticket Price
      </div>
    </div>
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        <?php
          $count = 0;
          foreach ($event_types as $event_type)
          {
            if ($event_type->allowedTickets->contains('id', $ticket_type->id))
              $count += 1;
          }
          echo $count;
        ?>
      </div>
      <div class="label">
        Events
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        <i class="dollar icon"></i> {{ number_format(($ticket_type->price * $tickets->count()), 2, '.', ',') }}
      </div>
      <div class="label">
        Revenue
      </div>
    </div>
  </div>

  <table class="ui celled table">
    <thead>
      <tr>
        <th>Show</th>
        <th>{{ $ticket_type->name }} Tickets Sold</th>
        <th>Revenue</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($events as $event)
        @if ($events->count() > 0)
        <tr>

        {{-- Show --}}
        <td>
          <h5 class="ui header">
            {{ $event->show->name }}
            <div class="ui tiny black label" style="margin-left:0">{{ $event->type->name }}</div>
            <div class="sub header">{{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}</div>
          </h5>
        </td>

        {{-- Tickets Sold --}}
        <td>
          {{ $event->tickets->where('ticket_type_id', $ticket_type->id)->count() }}
        </td>

        {{-- Revenue --}}
        <td>
          $ {{ number_format(($event->tickets->where('ticket_type_id', $ticket_type->id)->count() * $ticket_type->price), 2, '.', ',') }}
        </td>
      </tr>
        @endif
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th class="right aligned"><h5 class="ui header">Totals:</h5></th>
        <th><h5 class="ui header">{{ $tickets->count() }}</h5></th>
        <th><h5 class="ui header">$ {{ number_format(($ticket_type->price * $tickets->count()), 2, '.', ',') }}</h5></th>
      </tr>
    </tfoot>
  </table>

@endsection
