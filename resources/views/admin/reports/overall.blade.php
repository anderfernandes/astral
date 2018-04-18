@extends('layout.report')

@section('title', \App\Setting::find(1)->organization . '\'s Overall Report')

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

  <div class="ui icon right floated buttons">
    <div onclick="window.print()" class="ui primary button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui secondary button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <h2 class="ui center aligned icon header" style="margin-top:8px">
    <div class="content">Overall Report</div>
    <div class="sub header">{{ \App\Setting::find(1)->organization }}</div>
  </h2>

  <h4 class="ui header">
    {{ Date::now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  {{-- Payments and Sales --}}
  <div class="ui dividing header">Payments & Sales</div>
  <div class="ui statistics">
    <div class="statistic">
      <div class="value">
        <i class="dollar icon"></i>
        {{ number_format($payments->sum('tendered') - $payments->sum('change_due'), 2) }}
      </div>
      <div class="label">
        Total
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ number_format($payments->count(), 0) }}
      </div>
      <div class="label">
        Payments
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ number_format($sales->count(), 0) }}
      </div>
      <div class="label">
        Sales
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ number_format(($payments->where('payment_method_id', 1)->count() / $payments->count()) * 100, 1) }} %
      </div>
      <div class="label">
        Cash
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ number_format(($payments->where('payment_method_id', 2)->count() / $payments->count()) * 100, 1) }} %
      </div>
      <div class="label">
        Check
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ number_format(($payments->where('payment_method_id', '!=', 1)->where('payment_method_id', '!=', 2)->count() / $payments->count()) * 100, 1) }} %
      </div>
      <div class="label">
        Card
      </div>
    </div>
  </div>

  {{-- Users and Organizations --}}
  <div class="ui dividing header">Users & Organizations</div>
  <div class="ui statistics">
    <div class="statistic">
      <div class="value">
        {{ number_format($users->where('type', 'individual')->count(), 0) }}
      </div>
      <div class="label">
        Users
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ number_format($organizations->where('id','!=', 1)->count(), 0) }}
      </div>
      <div class="label">
        Organizations
      </div>
    </div>
  </div>

  {{-- Members --}}
  <div class="ui dividing header">Members</div>
  <div class="ui statistics">
    <div class="statistic">
      <div class="value">
        {{ number_format($members->where('id', '!=', 1)->count(), 0) }}
      </div>
      <div class="label">
        Members
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        <i class="dollar icon"></i>
        <?php
          $membershipRevenue = 0;
          $noRefundSales = $sales->where('refund', false);
          foreach ($noRefundSales as $sale) {
            if ($sale->tickets->count() == 0)
            $membershipRevenue += $sale->subtotal;
          }
          echo number_format($membershipRevenue, 2)
        ?>
      </div>
      <div class="label">
        Membership Revenue
      </div>
    </div>
  </div>

  {{-- Shows, Events and Visitors --}}
  <div class="ui dividing header">Shows, Events & Visitors</div>
  <div class="ui statistics">
    <div class="statistic">
      <div class="value">
        {{ number_format($shows->where('id', '!=', 1)->count(), 0) }}
      </div>
      <div class="label">
        Shows
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ number_format($events->where('id', '!=', 1)->count(), 0) }}
      </div>
      <div class="label">
        Events Scheduled
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        <?php
          $visitors = 0;
          $completeSales = $sales->where('status', 'complete');
          foreach ($completeSales as $sale) {
            $visitors += $sale->tickets->count();
          }
          echo number_format($visitors, 0);
        ?>
      </div>
      <div class="label">
        Visitors
      </div>
    </div>
    <div class="statistic"></div>
  </div>

@endsection
