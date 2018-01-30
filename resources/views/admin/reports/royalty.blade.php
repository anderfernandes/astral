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

  <div class="ui segments">
    <div class="ui segment">
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
                  <div class="ui tiny label">{{ $ticket->name }} $ {{ number_format($ticket->price, 2)}}</div>
                @endforeach
              </td>
              <td>{{ App\Ticket::where('event_id', $event->id )->count() }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="ui segment">
      <canvas height="350" id="attendanceChart"></canvas>
    </div>
    <div class="ui segment">
      <canvas height="350" id="attendanceByTicketTypeChart"></canvas>
    </div>
    <div class="ui segment">
      <canvas height="350" id="revenueChart"></canvas>
    </div>
    <div class="ui segment">
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
    @foreach ($events as $event)
      @foreach ($event->type->allowedTickets as $ticket)
      {
        label: "{{ $ticket->name }}",
        stack: "{{ Date::parse($event->start)->format('m-d-Y g:i A') }}",
        backgroundColor: "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
        data: [
            {{ App\Ticket::where('event_id', $event->id)->where('ticket_type_id', $ticket->id)->count() }} // {{ $ticket->name }}
        ],
      },
      @endforeach
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
          legend: { display: false, position: "left" },
          title: { display: true, text: "{{ $show->name }}\'s Attendance by Event and Ticket Type" },
          maintainAspectRatio: false,
          //tooltips: { mode: "index", intersect: true},
          scales: {
            xAxes: [{
              stacked: true,
            }],
            yAxes: [{
              stacked: true
            }]
          }
        }
    })
  }

  </script>

@endsection
