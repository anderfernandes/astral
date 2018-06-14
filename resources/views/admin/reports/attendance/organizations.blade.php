@extends('layout.report')

@section('title', "Organizations Attendance Report'")

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
    <div class="content">Organizations Attendance Report</div>
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
        {{ number_format($organizations->count(), 0, null, ',') }}
      </div>
      <div class="label">
        Organizations
      </div>
    </div>
    <div class="statistic" style="margin-right: 0">
      <div class="value">
        {{ number_format($organizations->events, 0, null, ',') }}
      </div>
      <div class="label">
        Visits
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        {{ number_format($organizations->tickets, 0, null, ',') }}
      </div>
      <div class="label">
        Tickets Purchased
      </div>
    </div>
    <div class="statistic">
      <div class="value">
        <i class="dollar icon"></i> {{ number_format($organizations->total, 2, '.', ',') }}
      </div>
      <div class="label">
        Revenue
      </div>
    </div>
  </div>

  {{-- Organizations --}}
  <div class="ui horizontal divider header">
    <i class="university icon"></i>
    Organizations
  </div>
  <div class="ui grid">
    <div class="ui sixteen wide column">
      <canvas height="350" id="organizations"></canvas>
    </div>
  </div>

  {{-- Visits --}}
  <div class="ui horizontal divider header">
    <i class="bus icon"></i>
    Visits
  </div>
  <div class="ui grid">
    <div class="ui sixteen wide column">
      <canvas height="350" id="visits"></canvas>
    </div>
  </div>

  <script>

    window.onload = function() {

      {{-- Organizations Chart --}}
      new Chart(document.querySelector('#organizations'), {
        type: 'bar',
        options: {
          animation: { animateScale: true, animateRotate: true },
          responsive: true,
          maintainAspectRatio: false,
          legend: { display: false },
          scales: {
            xAxes: [{
              stacked: false
            }],
            yAxes: [{
              stacked: false
            }]
          },
        },
        data: {
          labels: [
            @foreach ($organization_types as $organization_type)

              '{{ $organization_type->name }}',

            @endforeach
          ],
          datasets: [

            {

              data: [
                @foreach ($organization_types as $organization_type)
                  {{ $organizations->where('type_id', $organization_type->id)->count() }},
                @endforeach
              ],
              backgroundColor: [
                @foreach ($organization_types as $organization_type)
                  "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
                @endforeach
              ],
              borderColor: "rgba(21, 28, 29, 1)",
              borderWidth: 2,
            },
          ],
        },
      })

      {{-- Organizations Visits --}}
      new Chart(document.querySelector('#visits'), {
        type: 'bar',
        options: {
          animation: { animateScale: true, animateRotate: true },
          responsive: true,
          maintainAspectRatio: false,
          legend: { display: false },
          scales: {
            xAxes: [{
              stacked: false
            }],
            yAxes: [{
              stacked: false
            }]
          },
        },
        data: {
          labels: [

            @if (Date::parse($start)->diffInDays($end) < 31)

              @for ($i = 0; $i <= Date::parse($start)->diffInDays($end); $i++)

                @if (\App\Event::whereDate('start', Date::parse($start)->addDays($i)->format('Y-m-d'))->count() > 0)
                  '{{ Date::parse($start)->addDay($i)->format('l, F j, Y') }}',
                @endif

              @endfor

            @endif

          ],
          datasets: [

            {

              data: [
                @for ($i = 0; $i <= Date::parse($start)->diffInDays($end); $i++)
                  @if (\App\Event::whereDate('start', Date::parse($start)->addDays($i)->format('Y-m-d'))->count() > 0)
                  {{ \App\Event::whereDate('start', Date::parse($start)->addDays($i)->format('Y-m-d'))->count() }},
                  @endif
                @endfor
              ],
              backgroundColor: [
                @for ($i = 0; $i <= Date::parse($start)->diffInDays($end); $i++)
                  @if (\App\Event::whereDate('start', Date::parse($start)->addDays($i)->format('Y-m-d'))->count() > 0)
                  "rgba({{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(0, 255) }}, {{ rand(2, 6) / 10 }})",
                  @endif
                @endfor
              ],
              borderColor: "rgba(21, 28, 29, 1)",
              borderWidth: 2,
            },
          ],
        },
      })
    }

  </script>


@endsection
