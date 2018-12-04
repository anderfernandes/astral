@extends('layout.report')

@section('title', "{$organization->name}'s Attendance Report'")

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
    <div class="content">Attendance Report</div>
    <div class="sub header">{{ $organization->name }}</div>
    <div class="sub header">
      {{ Date::parse($start)->format('l, F j, Y') }} | {{ Date::parse($end)->format('l, F j, Y') }}
    </div>
  </div>

  <h4 class="ui header">
    {{ Date::now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  {{-- Overview --}}
  <div class="ui horizontal divider header">
    <i class="file alternate icon"></i>
    Overview
  </div>
  <div class="ui four mini statistics">
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        {{ $events->count() }}
      </div>
      <div class="label">
        {{ $sales->count() > 1 ? 'Visits' : 'Visit' }}
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ $events->count() }}
      </div>
      <div class="label">
        {{ $events->count() > 1 ? 'Events' : 'Event' }}
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
        {{ number_format($sales->sum('total'), 2, '.', ',') }}
      </div>
      <div class="label">
        Revenue
      </div>
    </div>
  </div>

  {{-- Users and Organizations --}}
  <div class="ui horizontal divider header">
    <i class="bus icon"></i>
    Visits and Attendance
  </div>
  <table class="ui celled table">
    <thead>
      <tr>
        <th>Event</th>
        <th>Tickets Purchased</th>
        <th>Revenue</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($events as $event)
      <tr>
        <td>
          <div class="ui small header">
            {{ $event->show->name }} (#{{ $event->id }})
            <div class="sub header">{{ $event->start->format('l, F j, Y \a\t g:i A') }}</div>
          </div>
        </td>
        <td class="right aligned">
          <div class="ui small basic label" style="margin-left: 0">
            <i class="ticket icon"></i> {{ $event->tickets->where('organization_id', $organization->id)->where('event_id', $event->id)->count() }}
            <div class="detail">Tickets</div>
          </div>
          @foreach ($event->tickets->unique('ticket_type_id') as $ticket)
            <div class="ui small black label" style="margin-left:0">
              <i class="ticket icon"></i> {{ $event->tickets->where('organization_id', $organization->id)->where('ticket_type_id', $ticket->ticket_type_id)->where('event_id', $event->id)->count() }}
              <div class="detail">{!! $ticket->type->name !!}</div>
            </div>
          @endforeach
        </td>
        <td class="right aligned">
          $ {{ number_format($event->sales->where('organization_id', $organization->id)->sum('total'), 2, '.', ',') }}
        </td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th class="right aligned">
          <div class="ui tiny header">
            Total: {{ $events->count() }}
          </div>
        </th>
        <th class="right aligned">
          <div class="ui tiny header">
            {{ $tickets_purchased }}
          </div>
        </th>
        <th class="right aligned">
          <div class="ui tiny header">
            $ {{ number_format($sales->sum('total'), 2, '.', ',') }}
          </div>
        </th>
      </tr>
    </tfoot>
  </table>
  <div class="ui grid">
    @if ($with_charts)
    <div class="sixteen wide column">
      <canvas height="350" id="visitsAttendance"></canvas>
    </div>
    @endif
  </div>



  {{-- Revenue
  <div class="ui dividing header">Revenue</div>
  <div class="ui grid">
    <div class="sixteen wide column">
      <canvas height="350" id="revenue"></canvas>
    </div>
  </div>
  --}}

  <script>

    window.onload = function() {

      new Chart(document.getElementById('visitsAttendance').getContext("2d"), {
        type: 'bar',
        options: {
          animation: { animateScale: true, animateRotate: true },
          responsive: true,
          maintainAspectRatio: false,
          legend: { display: false },
          scales: {
            xAxes: [{
              stacked: true
            }],
            yAxes: [{
              stacked: true,
              ticks: { beginAtZero: true, callback: function(value) { if (value % 1 === 0) return value } },
            }]
          },
        },
        data: {
          labels: [
            @foreach ($organization->sales as $sales)

              @foreach ($sales->events as $event)

                '{{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}',

              @endforeach

            @endforeach
          ],
          datasets: [{
            label: 'Attendance',
            data: [
              @foreach ($organization->sales as $sale)
                  {{ $sale->tickets->count() }},
              @endforeach
            ],
            backgroundColor: [
              @foreach ($organization->sales as $sale)
                "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
              @endforeach
            ],
            borderColor: "rgba(21, 28, 29, 1)",
            borderWidth: 2,
          }],
        },
      })

      /**

      new Chart(document.getElementById('revenue').getContext("2d"), {
        type: 'bar',
        options: {
          animation: { animateScale: true, animateRotate: true },
          responsive: true,
          maintainAspectRatio: false,
          legend: { display: false },
          tooltips: {
            callbacks: {
              label: function(tooltipItem, data) {
                console.log(tooltipItem)
                console.log(data)
                return `${tooltipItem.xLabel} $ ${tooltipItem.yLabel.toFixed(2)}`
              }
            }
          },
          scales: {
              yAxes: [{
                  display: true,
                  ticks: {
                      beginAtZero: true,
                      callback: function(value, index, values) {
                        return '$ ' + value
                      }
                  }
              }],
              xAxes: [{
                display: true,
                ticks: {
                  autoSkip: false,
                }
              }]
          },
        },
        data: {
          labels: [
            @foreach ($organization->sales as $sales)

              @foreach ($sales->events as $event)

                '{{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}',

              @endforeach

            @endforeach
          ],
          datasets: [
            {
            label: 'Revenue Before Tax',
            data: [
              @foreach ($organization->sales as $sale)
                  {{ number_format($sale->subtotal, 2, '.', ',') }},
              @endforeach
            ],
            backgroundColor: [
              @foreach ($organization->sales as $sale)
                "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
              @endforeach
            ],
            borderColor: "rgba(21, 28, 29, 1)",
            borderWidth: 2,
          },
          {
            label: 'Revenue After Tax',
            data: [
              @foreach ($organization->sales as $sale)
                  {{ number_format($sale->total, 2, '.', ',') }},
              @endforeach
            ],
            backgroundColor: [
              @foreach ($organization->sales as $sale)
                "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
              @endforeach
            ],
            borderColor: "rgba(21, 28, 29, 1)",
            borderWidth: 2,
          }
        ],

        },
      })

      **/

    }



  </script>

@endsection
