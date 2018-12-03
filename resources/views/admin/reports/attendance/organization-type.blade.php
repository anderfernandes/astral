@extends('layout.report')

@section('title', "Attendance Report - {$organization_type->name}")

@section('content')
  <?php

    $total_tickets = 0;
    $total_sales = 0;
    $total_events = 0;
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
    <div class="content">Attendance Report - {{ $organization_type->name }}</div>
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
        {{ $organization_type->organizations->count() }}
      </div>
      <div class="label">
        Organizations
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
        {{ $tickets_purchased }}
      </div>
      <div class="label">
        Tickets Purchased
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        <i class="dollar icon"></i>
        {{ number_format($sales->sum('total'), '2', '.', ',') }}
      </div>
      <div class="label">
        Revenue
      </div>
    </div>
  </div>

  {{-- Organizations --}}
  <div class="ui horizontal divider header">
    <i class="file alternate icon"></i>
    Details
  </div>

  <table class="ui celled table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Tickets Purchased</th>
        <th>Sales</th>
        <th>Events</th>
        <th>Revenue</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($organization_type->organizations as $organization)
      <tr>
        <td>{{ $organization->name }}</td>
        <td class="right aligned">
          <?php
          $number_of_tickets = 0;
          foreach ($sales->where('organization_id', $organization->id) as $sale)
          {
            $number_of_tickets += $sale->tickets->count();
          }
          echo $number_of_tickets;
          ?>
        </td>
        <td class="right aligned">
          {{ $sales->where('organization_id', $organization->id)->count() }}
        </td>
        <td class="right aligned">
          {{ $organization->events->where('start', '>=', $start)->where('end', '<=', $end)->count() }}
        </td>
        <td class="right aligned">
          ${{ number_format($sales->where('organization_id', $organization->id)->sum('total'), 2, '.', ',') }}
        </td>
      </tr>
    @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th class="right aligned">
          <h5 class="ui header">Totals:</h5>
        </th>
        <th class="right aligned">
          <h5 class="ui header">
            {{ $tickets_purchased }}
          </h5>
        </th>
        <th class="right aligned">
          <h5 class="ui header">
            {{ $sales->count() }}
          </h5>
        </th>
        <th class="right aligned">
          <h5 class="ui header">
            {{ $events->count() }}
          </h5>
        </th>
        <th class="right aligned">
          <h5 class="ui header">
            $ {{ number_format($sales->sum('total'), '2', '.', ',') }}
          </h5>
        </th>
      </tr>
    </tfoot>
  </table>



@endsection
