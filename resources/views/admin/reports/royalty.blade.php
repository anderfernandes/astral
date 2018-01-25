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
          <!--- Overview --->
          <h5 class="ui top attached segment">Overview</h5>
          <div class="ui attached segment">
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
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--- Screening Details --->
  <h5 class="ui top attached segment">Screenings Breakdown</h5>
  <div class="ui attached segment">
    <table class="ui very basic collapsing celled table">
      <thead>
        <tr>
          <th>Date and Time</th>
          <th>Event Type</th>
          <th>Tickets and Prices</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($events as $event)
          <tr>
            <td>{{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}</td>
            <td><div class="ui black label">{{ $event->type->name }}</div></td>
            <td>
              @foreach ($event->type->allowedTickets as $ticket)
                <div class="ui label">{{ $ticket->name }} $ {{ number_format($ticket->price, 2)}}</div>
              @endforeach
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!--- Attendance Details --->
  <h5 class="ui top attached segment">Attendance Breakdown</h5>
  <div class="ui attached segment">
    <canvas height="500" id="attendanceChart"></canvas>
  </div>

  <!--- Attendance Details --->
  <h5 class="ui top attached segment">Revenue Breakdown</h5>
  <div class="ui attached segment">
    <canvas height="500" id="revenueChart"></canvas>
  </div>

  <script>

  var chartSettings = {
      animation: { animateScale: true, animateRotate: true },
      responsive: true,
      legend: { display: true, position: "right" },
      title: { display: true, text: "{{ $show->name }}\'s Attendance" },
      maintainAspectRatio: false
    }

    var attendanceCanvas = document.getElementById("attendanceChart").getContext("2d")
    var attendanceChart = new Chart(attendanceCanvas, {
      type: "doughnut",
      data: {
        labels: [
          @foreach ($events as $event)
            @foreach ($event->type->allowedTickets as $ticket)
              "{{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A')  }} {{ $ticket->name }}",
            @endforeach
          @endforeach
        ],
        datasets: [{
          label: "{{ $show->name }} Attendance",
          data: [
            @foreach ($events as $event)
              @foreach ($event->type->allowedTickets as $ticket)
                "{{ App\Ticket::where('event_id', $event->id)->where('ticket_type_id', $ticket->id)->count() }}",
              @endforeach
            @endforeach
          ],
          backgroundColor: [
            @foreach ($events as $event)
              @foreach ($event->type->allowedTickets as $ticket)
              "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
              @endforeach
            @endforeach
          ]
        }]
      },
      options: chartSettings
    })

    var revenueCanvas = document.getElementById("revenueChart").getContext("2d")
    var revenueChart = new Chart(revenueCanvas, {
      type: "bar",
      data: {
        labels: [
          @foreach ($events as $event)
            "{{ Date::parse($event->start)->format('m-d-Y g:i A')  }}",
          @endforeach
        ],
        datasets: [{
          label: "{{ $show->name }} Attendance",
          data: [
            @foreach ($events as $event)
              "{{ number_format($event->sales->sum('total'), 2) }}",
            @endforeach
          ],
          backgroundColor: [
            @foreach ($events as $event)
              "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
            @endforeach
          ]
        }]
      },
      options: {
          animation: { animateScale: true, animateRotate: true },
          responsive: true,
          legend: { display: false, position: "bottom" },
          title: { display: false, text: "{{ $show->name }}\'s Revenue" },
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
