@extends('layout.report')

@section('title', $show->name . '\'s Royalty Report')

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
    <div class="content">Royalty Report</div>
    <div class="sub header">{{ $show->name }}</div>
    <div class="sub header">From {{ Date::parse($start)->format('l, F j, Y \a\t g:i A') }} to {{ Date::parse($end)->format('l, F j, Y \a\t g:i A') }}</div>
  </h2>

  <h4 class="ui right floated header">
    {{ Date::now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  <div class="ui items">
    <div class="item">
      <div class="image"><img src="{{ $show->cover }}"></div>
      <div class="content">
        <div class="header">{{ $show->name }}</div>
        <div class="meta">
          <div class="ui blue label">{{ $show->type }}</div>
          <div class="ui blue label">{{ $show->duration }} minutes</div>
        </div>
        <div class="description">
          <div class="ui divider"></div>
          <!--- Overview --->
            <div class="ui mini statistics">
              <div class="statistic">
                <div class="label">Screenings</div>
                <div class="value">{{ $show->screenings }}</div>
              </div>
              <div class="statistic">
                <div class="label">Total Attendance</div>
                <div class="value">{{ $show->totalAttendance }}</div>
              </div>
              <div class="statistic">
                <div class="label">Total Revenue Before Tax</div>
                <div class="value">$ {{ number_format($show->subtotalRevenue, 2) }}</div>
              </div>
              <div class="statistic">
                <div class="label">Total Revenue After Tax</div>
                <div class="value">$ {{ number_format($show->totalRevenue, 2) }}</div>
              </div>
            </div>
            <div class="ui divider"></div>
        </div>
      </div>
    </div>
  </div>



      <!--- Screening Details --->
      <table class="ui very basic collapsing celled table">
        <thead>
          <tr>
            <th>Date and Time</th>
            <th>Event Type</th>
            <th>Attendance Breakdown</th>
            <th>Total Attendance</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($events as $event)
            <tr>
              <td>{{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}</td>
              <td><div class="ui tiny black label">{{ $event->type->name }}</div></td>
              <td>
                @foreach ($event->type->allowedTickets as $ticket)
                  <div class="ui tiny label">
                    {{ App\Ticket::where('ticket_type_id', $ticket->id)->where('event_id', $event->id)->count() }}
                    {{ $ticket->name }}
                    <span class="detail">
                      $ {{ number_format($ticket->price, 2)}}</span>
                    </div>
                @endforeach
              </td>
              @if (count($nonFreeTicketsIds) > 0)
                <td>{{ App\Ticket::where('event_id', $event->id )->whereIn('ticket_type_id', $nonFreeTicketsIds)->count() }}</td>
              @else
                <td>{{ App\Ticket::where('event_id', $event->id )->count() }}</td>
              @endif

            </tr>
          @endforeach
        </tbody>
      </table>

    <div class="ui grid">
      <div class="eight wide column">
        <canvas height="350" id="attendanceChart"></canvas>
      </div>
      <div class="eight wide column">
        <canvas height="350" id="attendanceByTicketTypeChart"></canvas>
      </div>
    </div>
    <div class="ui grid">
      <div class="eight wide column">
        <canvas height="350" id="revenueChart"></canvas>
      </div>
      <div class="eight wide column">
        <canvas height="350" id="revenueTaxChart"></canvas>
      </div>
    </div>

  <script>

  var attendanceBarChartData = {
    labels: [
      @foreach ($events as $event)
        "{{ Date::parse($event->start)->format('m-d-Y g:i A') }}",
      @endforeach
    ],
    datasets: [
      @foreach ($allTicketTypes as $ticket)
      {
        label: "{{ $ticket->name }}",
        backgroundColor: "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
        data: [
        @foreach ($events as $event)
           { x: "{{ Date::parse($event->start)->format('m-d-Y g:i A') }}", y: {{ App\Ticket::where('ticket_type_id', $ticket->id)->where('event_id', $event->id)->count() }} },
        @endforeach
        ],
      },
      @endforeach
    ]
  }



  window.onload = function() {
    var attendanceCanvas = document.getElementById("attendanceChart").getContext("2d")
    var attendanceChart = new Chart(attendanceCanvas, {
      type: "bar",
      data: attendanceBarChartData,
      options: {

          animation: { animateScale: true, animateRotate: true },
          responsive: true,
          legend: { display: true, position: "right" },
          title: { display: true, text: "{{ $show->name }}\'s Attendance by Event and Ticket Type" },
          maintainAspectRatio: false,
          //tooltips: { mode: "index", intersect: true},
          scales: {
            xAxes: [{
              stacked: true
            }],
            yAxes: [{
              stacked: true
            }]
          }
        }
    })
  }

  var attendanceByTicketTypeCanvas = document.getElementById("attendanceByTicketTypeChart").getContext("2d")
    var attendanceByTicketTypeChart = new Chart(attendanceByTicketTypeCanvas, {
      type: "doughnut",
      data: {
        labels: [
          @foreach ($allTicketTypes as $ticket)
            "{{ $ticket->name }}",
          @endforeach
        ],
        datasets: [{
          label: "{{ $show->name }} Attendance by Ticket Type",
          data: [
            @foreach ($allTicketTypes as $ticket)
              "{{ App\Ticket::whereIn('event_id', $show->eventsIds)->where('ticket_type_id', $ticket->id)->count() }}",
            @endforeach
          ],
          backgroundColor: [
            @foreach ($allTicketTypes as $ticket)
              "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
            @endforeach
          ]
        }]
      },
      options: {
          animation: { animateScale: true, animateRotate: true },
          responsive: true,
          legend: { display: true, position: "right" },
          title: { display: true, text: "{{ $show->name }}\'s Attendance by Ticket Type" },
          maintainAspectRatio: false
        }
    })

    var revenueCanvas = document.getElementById("revenueChart").getContext("2d")
    var revenueChart = new Chart(revenueCanvas, {
      type: "bar",
      data: {
        labels: [
          @foreach ($events as $event)
            "{{ Date::parse($event->start)->format('m-d-Y g:i A') }}",
          @endforeach
        ],
        datasets: [
            {
              backgroundColor: [
                @foreach ($events as $event)
                "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
                @endforeach
              ],
              data: [
                @foreach ($events as $event)
                  {{ number_format($event->sales->sum('subtotal'), 2) }},
                @endforeach
              ],
            },
        ]
    },
    options: {
        animation: { animateScale: true, animateRotate: true },
        responsive: true,
        legend: { display: false, position: "right" },
        title: { display: true, text: "{{ $show->name }}\'s Revenue Before Tax" },
        maintainAspectRatio: false,
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              return '$ ' + tooltipItem.yLabel.toFixed(2)
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
        }
      }
    })

    var revenueTaxCanvas = document.getElementById("revenueTaxChart").getContext("2d")
    var revenueTaxChart = new Chart(revenueTaxCanvas, {
      type: "bar",
      data: {
        labels: [
          @foreach ($events as $event)
            "{{ Date::parse($event->start)->format('m-d-Y g:i A') }}",
          @endforeach
        ],
        datasets: [
          {
            backgroundColor: [
              @foreach ($events as $event)
              "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
              @endforeach
            ],
            data: [
              @foreach ($events as $event)
                {{ number_format(App\Event::find($event->id)->sales->sum('total'), 2) }},
              @endforeach
            ],
          },
        ]
      },
      options: {
          animation: { animateScale: true, animateRotate: true },
          responsive: true,
          legend: { display: false, position: "right" },
          title: { display: true, text: "{{ $show->name }}\'s Revenue After Tax" },
          maintainAspectRatio: false,
          tooltips: {
            callbacks: {
              label: function(tooltipItem, data) {
                return '$ ' + tooltipItem.yLabel.toFixed(2)
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
          }
        }
    })

  </script>

@endsection
