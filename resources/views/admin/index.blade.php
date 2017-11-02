@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->firstname.' '. Auth::user()->lastname)

@section('icon', 'dashboard')

@section('content')

<style>
/*.ui..raised.center.aligned.segment {display: none}*/
</style>

<?php

function getSalesTotals($day)
{
  $dailySales = \App\Payment::whereDate('created_at','=', $day->format('Y-m-d'))
  ->sum('total');

  return round($dailySales, 2);
}

function getSalesTotalsRange($start, $end)
{
  $rangeTotal = 0;
  $rangeSales = \App\Payment::where([['created_at','>=', $start], ['created_at','<=', $end]])
  ->sum('total');

  return number_format($rangeSales, 2);
}

function getAttendance($date) {
  $events = App\Event::whereDate('start', $date->format('Y-m-d'))->pluck('id');
  $tickets = App\Ticket::whereIn('event_id', $events)->count();
  return $tickets;
}

function getAttendanceByType($ticketTypeID) {
  $today = Date::today();
  $tickets = App\Ticket::where('created_at', '>=', $today->subDays(6)->toDateTimeString())
                        ->where('ticket_type_id', $ticketTypeID)
                        ->count();

  return $tickets;
}

?>

<div class="ui grid">
  <!-- Overall Earnings -->
  <div class="eight wide computer sixteen wide mobile column">
    <div class="ui dividing header">
      <i class="money icon"></i>
      <div class="content">
        Overall Earnings
        <div class="sub header">
          Last 7 Days
        </div>
      </div>
    </div>
    <div>
      <canvas height="200" id="earningsChart"></canvas>
    </div>
  </div>

  <!-- Attendance -->
  <div class="eight wide computer sixteen wide mobile column">
    <div class="ui dividing header">
      <i class="money icon"></i>
      <div class="content">
        Attendance
        <div class="sub header">
          Last 7 Days
        </div>
      </div>
    </div>
    <div class="ui two column grid">
      <div class="column">
        <canvas height="200" id="attendanceChart"></canvas>
      </div>
      <div class="column">
        <canvas height="200" id="secondAttendanceChart"></canvas>
      </div>

    </div>
  </div>

  <!-- Events and Calendar -->
  <div class="eight wide computer sixteen wide mobile column">
    <div class="ui grid">
      <div class="eight wide computer sixteen wide mobile column">
        <div class="ui dividing header">
          <i class="calendar check icon"></i>
          <div class="content">
            Events
            <div class="sub header">
              Past and Upcoming
            </div>
          </div>
        </div>
        <div id="events"></div>
      </div>
      <div class="eight wide computer sixteen wide mobile column">
        <div class="ui dividing header">
          <i class="calendar icon"></i>
          <div class="content">
            Calendar
            <div class="sub header">
            {{ App\Setting::find(1)->organization }}
            </div>
          </div>
        </div>
        <div id="calendar"></div>
      </div>
    </div>
  </div>
  <!-- Calendar -->
  <div class="eight wide computer sixteen wide mobile column">
    <!-- Shows -->
    <div class="ui statistics">
      <div class="statistic">
        <div class="value">
          <i class="film icon"></i>
          {{ App\Show::all()->count() - 1 }}
        </div>
        <div class="label">
          Shows
        </div>
      </div>
      <div class="statistic">
        <div class="value">
          <i class="users icon"></i>
          {{ App\User::all()->count() - 1 }}
        </div>
        <div class="label">
          Users
        </div>
      </div>
      <div class="statistic">
        <div class="value">
          <i class="university icon"></i>
          {{ App\Organization::all()->count() - 1 }}
        </div>
        <div class="label">
          Organizations
        </div>
      </div>
    </div>
    <div class="ui dividing header">
      <i class="calendar check icon"></i>
      <div class="content">
        Feed
        <div class="sub header">
          Latest Sales
        </div>
      </div>
    </div>
    <div class="ui feed">
      <?php $lastSales = App\Sale::latest()->take(5)->get() ?>
      @foreach ($lastSales as $lastSale)
        <div class="event">
          <div class="label">
            <i class="user circle outline icon"></i>
          </div>
          <div class="content">
            <div class="summary">
              <a href="#" class="user">
                {{ $lastSale->creator->firstname }} {{ $lastSale->creator->lastname }}</a>
                sold {{ $lastSale->tickets->count() }} tickets
            </div>
            <div class="date">
              {{ Date::parse($lastSale->created_at)->ago() }}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>

<script>

function loadCalendars() {
  $('#events').fullCalendar({
    header: {
      left: 'prev,next today',
      right: ''
    },
    defaultView: 'listDay',
    defaultDate: moment().format('YYYY-MM-DD'),
    contentHeight: 200,
    hiddenDays: [0],
    navLinks: true,
    editable: false,
    eventLimit: true,
    minTime: '07:00:00',
    eventColor: '#1b1c1d',
    events: '/api/events'
  })
  $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      right: ''
    },
    defaultView: 'basicDay',
    defaultDate: moment().format('YYYY-MM-DD'),
    contentHeight: 200,
    hiddenDays: [0],
    navLinks: true,
    editable: false,
    eventLimit: true,
    minTime: '09:00:00',
    eventColor: '#1b1c1d',
    events: '/api/calendar'
  })
}

function refetchEvents() {
  $('#events').fullCalendar('refetchEvents')
  $('#calendar').fullCalendar('refetchEvents')
}

$(document).ready(loadCalendars)

setInterval(refetchEvents, 5000)

var earningsCanvas = document.getElementById("earningsChart").getContext("2d");
var earningsChart = new Chart(earningsCanvas, {
  type: 'line',
  data: {
    labels: [
             '{{ Date::today()->subDays(6)->format('l, F j') }}',
             '{{ Date::today()->subDays(5)->format('l, F j') }}',
             '{{ Date::today()->subDays(4)->format('l, F j') }}',
             '{{ Date::today()->subDays(3)->format('l, F j') }}',
             '{{ Date::today()->subDays(2)->format('l, F j') }}',
             '{{ Date::today()->subDays(1)->format('l, F j') }}',
             '{{ Date::today()->format('l, F j') }}'
           ],
    datasets: [{
      label: 'Earnings ',
      data: [
        {{ getSalesTotals(Date::today()->subDays(6)) }},
        {{ getSalesTotals(Date::today()->subDays(5)) }},
        {{ getSalesTotals(Date::today()->subDays(4)) }},
        {{ getSalesTotals(Date::today()->subDays(3)) }},
        {{ getSalesTotals(Date::today()->subDays(2)) }},
        {{ getSalesTotals(Date::today()->subDays(1)) }},
        {{ getSalesTotals(Date::today()) }},
      ],
      backgroundColor: "rgba(27, 28, 29, 0.5)",
      borderColor: "rgba(21, 28, 29, 1)",
      borderWidth: 2
    }]
  },
  options: {
      responsive: true,
      legend: { display: false },
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            return '$ ' + tooltipItem.yLabel.toFixed(2)
          }
        }
      },
      title: { display: false },
      maintainAspectRatio: false,
      scales: {
          yAxes: [{
              ticks: {
                  beginAtZero: true,
                  callback: function(value, index, values) {
                    return '$ ' + value
                  }
              }
          }],
          xAxes: [{
            display: false
          }]
      }
    }
});

var attendanceCanvas = document.getElementById("attendanceChart").getContext("2d");
var attendanceChart = new Chart(attendanceCanvas, {
  type: 'doughnut',
  data: {
    labels: [
            '{{ Date::today()->subDays(6)->format('l, F j') }}',
            '{{ Date::today()->subDays(5)->format('l, F j') }}',
            '{{ Date::today()->subDays(4)->format('l, F j') }}',
            '{{ Date::today()->subDays(3)->format('l, F j') }}',
            '{{ Date::today()->subDays(2)->format('l, F j') }}',
            'Yesterday',
            'Today'
           ],
    datasets: [{
      label: 'Attendance ',
      data: [
        {{ getAttendance(Date::today()->subDays(6)) }},
        {{ getAttendance(Date::today()->subDays(5)) }},
        {{ getAttendance(Date::today()->subDays(4)) }},
        {{ getAttendance(Date::today()->subDays(3)) }},
        {{ getAttendance(Date::today()->subDays(2)) }},
        {{ getAttendance(Date::today()->subDays(1)) }},
        {{ getAttendance(Date::today()) }},
      ],
      backgroundColor: [
        '#fea142',
        '#fdce57',
        '#4bbebf',
        '#e03997',
        '#cf3534',
        '#002e5d',
        '#1b1c1d',
      ]
    }]
  },
  options: {
      animation: { animateScale: true, animateRotate: true },
      responsive: true,
      legend: { display: false, position: 'right' },
      title: { display: true, text: 'by Tickets Sold' },
      maintainAspectRatio: false
    }
});

var secondAttendanceCanvas = document.getElementById("secondAttendanceChart").getContext("2d");
var secondAttendanceChart = new Chart(secondAttendanceCanvas, {
  type: 'pie',
  data: {
    labels: [
            '{{ App\TicketType::find(1)->name }}',
            '{{ App\TicketType::find(2)->name }}',
            '{{ App\TicketType::find(3)->name }}',
            '{{ App\TicketType::find(4)->name }}',
            '{{ App\TicketType::find(5)->name }}',
            '{{ App\TicketType::find(6)->name }}',
           ],
    datasets: [{
      label: 'Attendance ',
      data: [
        {{ getAttendanceByType(1) }},
        {{ getAttendanceByType(2) }},
        {{ getAttendanceByType(3) }},
        {{ getAttendanceByType(4) }},
        {{ getAttendanceByType(5) }},
        {{ getAttendanceByType(6) }},
      ],
      backgroundColor: [
        '#fea142',
        '#fdce57',
        '#4bbebf',
        '#e03997',
        '#cf3534',
        '#002e5d',
        '#1b1c1d',
      ]
    }]
  },
  options: {
      animation: { animateScale: true, animateRotate: true },
      responsive: true,
      legend: { display: false, position: 'right' },
      title: { display: true, text: 'by Demographics' },
      maintainAspectRatio: false
    }
});

//$('.ui..raised.center.aligned.segment')
//.transition({animation:'vertical flip', duration: 2000, interval: 1000 })

</script>

@endsection
