@extends('layout.report')

@section('title', "{$organization->name}'s Attendance Report'")

@section('content')

  <?php

    $visitors = 0;
    $beforeTax = 0;
    $afterTax = 0;
    $events = 0;
    foreach ($organization->sales->where('status', 'complete') as $sale)
    {
      $visitors += $sale->tickets->count();
      $beforeTax += $sale->subtotal;
      $afterTax += $sale->total;
      $events += $sale->events->count();
    }

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
    }
  </style>

  <div class="ui icon right floated buttons">
    <div onclick="window.print()" class="ui primary button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui secondary button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <h2 class="ui center aligned icon header" style="margin-top:8px">
    <div class="content">Attendance Report</div>
    <div class="sub header">{{ $organization->name }}</div>
    <div class="sub header">
      {{ Date::parse($start)->format('l, F j, Y') }} - {{ Date::parse($end)->format('l, F j, Y') }}
    </div>
  </h2>

  <h4 class="ui header">
    {{ Date::now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  {{-- Overview --}}
  <div class="ui dividing header">Overview</div>
  <div class="ui statistics">
    <div class="statistic">
      <div class="value">
        {{ $organization->sales->count() }}
      </div>
      <div class="label">
        {{ $organization->sales->count() > 1 ? 'Visits' : 'Visit' }}
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ $visitors }}
      </div>
      <div class="label">
        Attendance
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ $events }}
      </div>
      <div class="label">
        {{ $events > 1 ? 'Events' : 'Event' }}
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ $events }}
      </div>
      <div class="label">
        {{ $events > 1 ? 'Shows' : 'Show' }}
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        <i class="dollar icon"></i>
        {{ number_format($beforeTax, 2, '.', ',') }}
      </div>
      <div class="label">
        Revenue Before Tax
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        <i class="dollar icon"></i>
        {{ number_format($afterTax, 2, '.', ',') }}
      </div>
      <div class="label">
        Revenue After Tax
      </div>
    </div>
  </div>

  {{-- Users and Organizations --}}
  <div class="ui dividing header">Visits and Attendance</div>
  <div class="ui grid">
    <div class="sixteen wide column">
      <canvas height="350" id="visitsAttendance"></canvas>
    </div>
  </div>



  {{-- Members --}}
  <div class="ui dividing header">Revenue</div>
  <div class="ui grid">
    <div class="sixteen wide column">
      <canvas height="350" id="revenue"></canvas>
    </div>
  </div>

  {{-- Ticket Type --}}
  <div class="ui dividing header">Demographics and Attendance</div>
  <div class="ui grid">
    <div class="sixteen wide column">
      <canvas height="350" id="demographicsAndAttendance"></canvas>
    </div>
  </div>

  {{-- Ticket Type --}}
  <div class="ui dividing header">Demographics and Attendance</div>
  <div class="ui grid">
    <div class="sixteen wide column">
      <canvas height="350" id="test"></canvas>
    </div>
  </div>

  <script>

    window.onload = function() {

      new Chart(document.querySelector('#demographicsAndAttendance').getContext('2d'), {
        type: 'bar',
        options: {
          maintainAspectRatio: false,
          scales: {
            xAxes: [{
              stacked: true
            }],
            yAxes: [{
              stacked: true
            }]
          },
          title: { display: true },
        },
        data: {
          labels: [
            @foreach ($organization->sales as $sale)
              @foreach ($sale->events as $event)
              @endforeach
            @endforeach
          ],
        }
      })

      new Chart(document.getElementById('test').getContext('2d'), {
        type: 'bar',
        options: {
          maintainAspectRatio: false,
          scales: {
            xAxes: [{
              stacked: true
            }],
            yAxes: [{
              stacked: true
            }]
          },
          title: { display: true },
        },
        data: {
          labels: [  ], // Events
          datasets: [
            { label: 'Teacher', data: [ 10, 20, 30 ], backgroundColor: 'red'   }, // Amount of tickets sold in each day
            { label: 'Student', data: [ 15, 25, 35 ], backgroundColor: 'blue'  },
            { label: 'Parent',  data: [ 8, 16, 32  ], backgroundColor: 'green' },
          ],
        }
      })

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
              stacked: true
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
                return 'Revenue: $ ' + tooltipItem.yLabel.toFixed(2)
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
          datasets: [{
            label: 'Revenue',
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
          }],

        },
      })

    }



  </script>

@endsection
