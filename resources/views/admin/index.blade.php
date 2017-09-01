@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->firstname.' '. Auth::user()->lastname)

@section('icon', 'dashboard')

@section('content')

<style>
.ui.inverted.raised.center.aligned.segment {display: none}
</style>

<?php

function getSalesTotals($day)
{
  $dailySales = \App\Sale::whereDate('created_at','=', $day->format('Y-m-d'))
  ->where('refund', false)
  ->sum('total');

  return number_format($dailySales, 2);
}

function getSalesTotalsRange($start, $end)
{
  $rangeTotal = 0;
  $rangeSales = \App\Sale::where([['created_at','>=', $start], ['created_at','<=', $end], ['refund', false]])
  ->sum('total');

  return number_format($rangeSales, 2);
}

?>

<div class="ui icon message" style="margin-top:0">
  <i class="sun icon"></i>
  <div class="content">
    <div class="header">
      Welcome, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}!
    </div>
    <p>Why don't you start by clicking the menu button at the top left of the screen?</p>
  </div>
</div>

<div class="ui grid">
  <div class="column">
    <div class="ui segment">
      <h3 class="ui header"><i class="bar chart icon"></i>Earnings This Week</h3>
      <div class="ct-chart"></div>
    </div>
  </div>
</div>
<div class="ui grid">
  <div class="four wide computer eight wide mobile column">
    <div class="ui inverted raised center aligned segment">
      <div class="ui inverted large centered statistic">
        <div class="value"><i class="film icon"></i></div>
      </div>
      <div class="ui inverted large centered statistic">
        <div class="value">{{ \App\Show::all()->count() }}</div>
        <div class="label">Shows</div>
      </div>
      <div class="ui two column grid">
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">{{ \App\Show::where('type', 'Planetarium')->count() }}</div>
            <div class="label">Planetarium</div>
          </div>
        </div>
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">{{ \App\Show::where('type', 'Laser Light')->count() }}</div>
            <div class="label">Laser Light</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="four wide computer eight wide mobile column">
    <div class="ui inverted raised center aligned segment">
      <div class="ui inverted large centered statistic">
        <div class="value"><i class="users icon"></i></div>
      </div>
      <div class="ui inverted large centered statistic">
        <div class="value">{{ \App\User::all()->count() - 1 }}</div>
        <div class="label">Users</div>
      </div>
      <div class="ui three column grid">
        <div class="column" style="padding-left: 0 !important; padding-right: 0 !important">
          <div class="ui mini inverted statistic">
            <div class="value">0</div>
            <div class="label">Org.</div>
          </div>
        </div>
        <div class="column" style="padding-left: 0 !important; padding-right: 0 !important">
          <div class="ui mini inverted statistic">
            <div class="value">0</div>
            <div class="label">Visitors</div>
          </div>
        </div>
        <div class="column" style="padding-left: 0 !important; padding-right: 0 !important">
          <div class="ui mini inverted statistic">
            <div class="value">0</div>
            <div class="label">Members</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="four wide computer eight wide mobile column">
    <div class="ui inverted raised center aligned segment">
      <div class="ui inverted large centered statistic">
        <div class="value"><i class="calendar icon"></i></div>
      </div>
      <div class="ui inverted large centered statistic">
        <div class="value">
          {{ \App\Event::where('start','>=', Date::now('America/Chicago')->toDateTimeString())->where('start','<=', Date::now('America/Chicago')->endOfDay())->count()}}
        </div>
        <div class="label">Events Today</div>
      </div>
      <div class="ui two column grid">
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">
              {{ \App\Event::where('start','>=', Date::yesterday('America/Chicago')->toDateTimeString())->where('start','<=', Date::yesterday('America/Chicago')->endOfDay())->count()}}
            </div>
            <div class="label">Yesterday</div>
          </div>
        </div>
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">{{ \App\Event::where('start','>=', Date::tomorrow('America/Chicago')->toDateTimeString())->where('start','<=', Date::tomorrow('America/Chicago')->endOfDay())->count()}}</div>
            <div class="label">Tomorrow</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="four wide computer eight wide mobile column">
    <div class="ui inverted raised center aligned segment">
      <div class="ui inverted large centered statistic">
        <div class="value"><i class="child icon"></i></div>
      </div>
      <div class="ui inverted large centered statistic">
        <div class="value">{{ \App\Ticket::where('created_at','>=', Date::now('America/Chicago')->startOfDay()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfDay())->count()}}</div>
        <div class="label">Attendance Today</div>
      </div>
      <div class="ui three column grid">
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">
              {{ \App\Ticket::where('created_at','>=', Date::yesterday('America/Chicago')->startOfDay()->toDateTimeString())->where('created_at','<=', Date::yesterday('America/Chicago')->endOfDay())->count()}}
            </div>
            <div class="label">Yesterday</div>
          </div>
        </div>
        <div class="column" style="padding-left: 0 !important; padding-right: 0 !important">
          <div class="ui mini inverted statistic">
            <div class="value">
              {{ \App\Ticket::where('created_at','>=', Date::now('America/Chicago')->startOfWeek()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfWeek())->count()}}
            </div>
            <div class="label">This Week</div>
          </div>
        </div>
        <div class="column" style="padding-left: 0 !important; padding-right: 0 !important">
          <div class="ui mini inverted statistic">
            <div class="value">{{ \App\Ticket::where('created_at','>=', Date::now('America/Chicago')->startOfMonth()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfMonth())->count()}}</div>
            <div class="label">This Month</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="ui grid">
  <div class="four wide computer eight wide mobile column">
    <div class="ui inverted raised center aligned segment">
      <div class="ui inverted large centered statistic">
        <div class="value"><i class="dollar icon"></i></div>
      </div>
      <div class="ui inverted large centered statistic">
        <!-- Pending sale paid for true or false field -->
        <div class="value">
          {{ getSalesTotals(Date::now()) }}
        </div>
        <div class="label">Earned Today</div>
      </div>
      <div class="ui two column grid">
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">$
              {{ getSalesTotals(Date::yesterday()) }}
            </div>
            <div class="label">Yesterday</div>
          </div>
        </div>
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">$
              {{ getSalesTotalsRange(Date::now()->startOfWeek(), Date::now()->endOfWeek()) }}
            </div>
            <div class="label">This Week</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="four wide computer eight wide mobile column">
    <div class="ui inverted raised center aligned segment">
      <div class="ui inverted large centered statistic">
        <div class="value"><i class="ticket icon"></i></div>
      </div>
      <div class="ui inverted large centered statistic">
        <div class="value">{{ \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfDay())->count() }}</div>
        <div class="label">Sales Today</div>
      </div>
      <div class="ui three column grid">
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">
              <?php

              $totalSalesToday = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfDay())->count();

              $cardSales = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay())
              ->where('created_at','<=', Date::now('America/Chicago')->endOfDay())
              ->where('payment_method', '!=', 'cash')
              ->where('payment_method', '!=', 'check')
              ->count();

              if ($cardSales <= 0)
              echo $cardSales;
              else
              echo (($cardSales / $totalSalesToday) * 100);
              ?> %

            </div>
            <div class="label">Card</div>
          </div>
        </div>
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">
              <?php

              $cashSales = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay())
              ->where('created_at','<=', Date::now('America/Chicago')->endOfDay())
              ->where('payment_method', '=', 'cash')
              ->count();

              if ($cashSales <= 0)
              echo $cashSales;
              else
              echo (($cashSales / $totalSalesToday) * 100);

              ?> %
            </div>
            <div class="label">Cash</div>
          </div>
        </div>
        <div class="column">
          <div class="ui mini inverted statistic">
            <div class="value">
              <?php

              $checkSales = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay())
              ->where('created_at','<=', Date::now('America/Chicago')->endOfDay())
              ->where('payment_method', '=', 'check')
              ->count();

              if ($checkSales <= 0)
              echo $checkSales;
              else
              echo (($checkSales / $totalSalesToday)* 100);

              ?> %
            </div>
            <div class="label">Check</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="eight wide computer sixteen wide mobile column">
    <div class="ui inverted raised center aligned segment">
      <h3 class="ui dividing inverted left aligned header">
        <div class="content">
          <i class="user outline icon"></i> {{ Auth::user()->firstname.' '.Auth::user()->lastname }}'s Sales
        </div>
      </h3>
      <div class="ui four column grid">
        <div class="column">
          <div class="ui mini inverted header">Week</div>
          <div class="ui inverted mini statistic">
            <div class="value">$
              {{ App\Sale::select('total')->where('cashier_id', Auth::user()->id)->whereBetween('created_at', [Date::now()->startOfWeek(), Date::now()->endOfWeek()])->sum('total') }}
            </div>
            <div class="label">This</div>
          </div>
          <div class="ui inverted mini statistic">
            <div class="value">$
              {{ App\Sale::select('total')->where('cashier_id', Auth::user()->id)->whereBetween('created_at', [Date::now()->subMonth()->startOfMonth(), Date::now()->subMonth()->endOfMonth()])->sum('total') }}
            </div>
            <div class="label">Last</div>
          </div>
        </div>
        <div class="column">
          <div class="ui mini inverted header">Month</div>
          <div class="ui inverted mini statistic">
            <div class="value">$
              {{ App\Sale::select('total')->where('cashier_id', Auth::user()->id)->whereBetween('created_at', [Date::now()->startOfMonth(), Date::now()->endOfMonth()])->sum('total') }}
            </div>
            <div class="label">This</div>
          </div>
          <div class="ui inverted mini statistic">
            <div class="value">$
              {{ App\Sale::select('total')->where('cashier_id', Auth::user()->id)->whereBetween('created_at', [Date::now()->subMonth()->startOfMonth(), Date::now()->subMonth()->endOfMonth()])->sum('total') }}
            </div>
            <div class="label">Last</div>
          </div>
        </div>
        <div class="column">
          <div class="ui mini inverted header">Year</div>
          <div class="ui inverted mini statistic">
            <div class="value">$
              {{ App\Sale::select('total')->where('cashier_id', Auth::user()->id)->whereBetween('created_at', [Date::now()->startOfYear(), Date::now()->endOfYear()])->sum('total') }}
            </div>
            <div class="label">This</div>
          </div>
          <div class="ui inverted mini statistic">
            <div class="value">$
              {{ App\Sale::select('total')->where('cashier_id', Auth::user()->id)->whereBetween('created_at', [Date::now()->subYear()->startOfYear(), Date::now()->subYear()->endOfYear()])->sum('total') }}
            </div>
            <div class="label">Last</div>
          </div>
        </div>
        <div class="column">
          <div class="ui mini inverted header">Fiscal Year</div>
          <div class="ui inverted mini statistic">
            <div class="value">$
              {{
                App\Sale::select('total')->where('cashier_id', Auth::user()->id)
                ->whereBetween('created_at', [Date::now()->format('Y').' 09-01 00:00:00', Date::now()->format('Y').'08-31 23:59:59'])
                ->sum('total')
              }}
            </div>
            <div class="label">This</div>
          </div>
          <div class="ui inverted mini statistic">
            <div class="value">$
              {{ App\Sale::select('total')->where('cashier_id', Auth::user()->id)->whereBetween('created_at', [Date::now()->subYear()->format('Y').' 09-01 00:00:00', Date::now()->subYear()->format('Y').'08-31 23:59:59'])->sum('total') }}
            </div>
            <div class="label">Last</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<script>

var data = {
  labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
  series: [
    [
      {{ getSalesTotals(Date::now()->startOfWeek()) }},
      {{ getSalesTotals(Date::now()->startOfWeek()->addDay()) }},
      {{ getSalesTotals(Date::now()->startOfWeek()->addDays(2)) }},
      {{ getSalesTotals(Date::now()->startOfWeek()->addDays(3)) }},
      {{ getSalesTotals(Date::now()->startOfWeek()->addDays(4)) }},
      {{ getSalesTotals(Date::now()->startOfWeek()->addDays(5)) }},
    ]
  ]
};

var options = {
  height: 200,
  showArea: true,
  low: 0,
  axisY: {
    labelInterpolationFnc: function(value) {
      return '$ ' + value
    }
  }
};

new Chartist.Line('.ct-chart', data, options);

$('.ui.inverted.raised.center.aligned.segment')
.transition({animation:'vertical flip', duration: 2000, interval: 1000 })



</script>

@endsection
