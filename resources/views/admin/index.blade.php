@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->fullname)

@section('icon', 'dashboard')

@section('content')

@include('admin.announcements._announcement')

<style>
  .pusher {
    background: linear-gradient(rgba(253,254,255,1), rgba(253,254,255,0.5)), url('{{ $cover == '/cover.jpg' ? $cover : Storage::url($cover) }}') !important;
    background-size: cover !important;
  }

</style>

<?php

function getSalesTotals($day)
{
  $start = Date::parse($day)->startOfDay()->toDateTimeString();
  $end = Date::parse($day)->endOfDay()->toDateTimeString();

  $dailyTendered = \App\Payment::where([
    ['created_at','>=', $start],
    ['created_at','<=', $end]
    ])->sum('tendered');

  $dailyChange = \App\Payment::where([
    ['created_at','>=', $start],
    ['created_at','<=', $end]
    ])->sum('change_due');

  $daily = number_format($dailyTendered - $dailyChange, 2, '.', '');

  return $daily;
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

  <div class="eight wide computer sixteen wide mobile column">

    @if(str_contains(Auth::user()->role->permissions['dashboard'], "CRUD"))
    {{-- Overall Earnings --}}
    <div class="ui raised segment">
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
    @endif

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "R"))
    {{-- Calendar --}}
    <div class="ui raised segment">
      <div class="ui two column grid">
        <div class="column">
          <div class="ui dividing header">
            <i class="calendar alternate icon"></i>
            <div class="content">
              Calendar
              <div class="sub header" id="calendar-title"></div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui secondary right floated dropdown labeled icon button">
            <i class="calendar alternate outline icon"></i>
            <span class="text">Sales</span>
            <div class="menu">
              <div onclick="toggleCalendar('events')" class="item">Events</div>
              <div onclick="toggleCalendar('sales')" class="active item">Sales</div>
            </div>
          </div>
          <div class="ui black right floated icon buttons" style="margin-bottom:0.5rem">
            <div onclick="$('#calendars').fullCalendar('prev'); setTitle()" class="ui button"><i class="left chevron icon"></i></div>
            <div onclick="$('#calendars').fullCalendar('today'); setTitle()" class="ui button"><i class="checked calendar icon"></i></div>
            <div onclick="$('#calendars').fullCalendar('next'); setTitle()" class="ui button"><i class="right chevron icon"></i></div>
          </div>
        </div>
      </div>
      <div id="calendars"></div>
    </div>
    @endif

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "CRUD"))
    {{-- Overview --}}
    <div class="ui horizontal raised segments">
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="film icon"></i>
            {{ App\Show::all()->count() - 1 }}
          </div>
          <div class="label">
            Shows
          </div>
        </div>
      </div>
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="users icon"></i>
            {{ App\User::all()->count() - 1 }}
          </div>
          <div class="label">
            Users
          </div>
        </div>
      </div>
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="university icon"></i>
            {{ App\Organization::all()->count() - 1 }}
          </div>
          <div class="label">
            Organizations
          </div>
        </div>
      </div>
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="address card icon"></i>
            {{ App\Member::all()->count() - 1 }}
          </div>
          <div class="label">
            Members
          </div>
        </div>
      </div>
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="box icon"></i>
            {{ App\Product::all()->count() }}
          </div>
          <div class="label">
            Products
          </div>
        </div>
      </div>
    </div>
    @endif

    <?php

    $products = App\Product::where('inventory', true)->where('stock', '<=', 10)->get();

    ?>

    @if (str_contains(Auth::user()->role->permissions['products'], "CRUD"))
    {{-- Products --}}
    <div class="ui raised segment">
      <div class="ui dividing header">
        <i class="box icon"></i>
        <div class="content">
          Products
          <div class="sub header">
            Stock
          </div>
        </div>
      </div>
      <div class="ui list">
        @if ($products->count() > 0)
          @foreach ($products as $product)
          <div class="item">
            <img src="{{ $product->cover == '/default.png' ? $product->cover : Storage::url($product->cover) }}" class="ui avatar image">
            <div class="content">
              <a href="{{ route('admin.products.edit', $product) }}" target="_blank" class="header">
                {{ $product->name }}
                <div class="ui red label" data-tooltip="Only {{ $product->stock }} in stock!" style="margin-right:0">
                  <i class="box icon"></i>
                  <div class="detail">{{ $product->stock }}</div>
                </div>
              </a>
              <div class="description">{{ $product->description }}</div>
            </div>
          </div>
          @endforeach
        @else
        <div class="ui info icon message">
          <i class="info circle icon"></i>
          <div class="content">
            <div class="header">All products are on stock of 10 or more!</div>
            All products are on stock! Keep it up!
          </div>
        </div>
        @endif

      </div>
    </div>
    @endif

  </div>

  <div class="eight wide computer sixteen wide mobile column">

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "CRUD"))
    {{-- Attendance --}}
    <div class="ui raised segment">
      <div class="ui dividing header">
        <i class="child icon"></i>
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
    @endif

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "CRUD"))
    {{-- Feed --}}
    <div class="ui raised segment">
      <div class="ui small dividing header">
        <i class="feed icon"></i>
        <div class="content">
          Feed
          <div class="sub header">
            Latest Sales
          </div>
        </div>
      </div>
      <div class="ui relaxed list">
        <?php $lastSales = App\Sale::where('status', 'complete')->latest()->take(5)->get() ?>
        @foreach ($lastSales as $lastSale)
          {{-- MEMBERSHIP SALES HAVE NO TICKETS UNDER THEM!!! --}}
          @if ($lastSale->tickets->count() > 0)
          <div class="item">
            <i class="big user circle icon"></i>
            <div class="content">
              <div class="header">
                <a target="_blank" href="{{ route('admin.users.show', $lastSale->creator) }}" class="user">
                  {{ $lastSale->creator->firstname }}</a>
                  sold <a target="_blank" href="{{ route('admin.sales.show', $lastSale) }}"> {{ $lastSale->tickets->count() }}
                  @if ($lastSale->tickets->count() == 1)
                    ticket</a> to <a target="_blank" href="{{ route('admin.shows.show', $lastSale->events[0]->show) }}">{{ $lastSale->tickets[0]->event->show->name }}</a> <div class="ui black circular label">{{ $lastSale->tickets[0]->event->type->name }}</div>
                  @else
                    tickets</a> to <a target="_blank" href="{{ route('admin.shows.show', $lastSale->events[0]->show) }}">{{ $lastSale->tickets[0]->event->show->name }}</a> <div class="ui black circular label">{{ $lastSale->tickets[0]->event->type->name }}</div>
                  @endif
              </div>
              <div class="description">
                {{ Date::parse($lastSale->created_at)->ago() }}
              </div>
            </div>
          </div>
        @elseif ($lastSale->customer->role->name == "Member")
            <div class="item">
              <i class="big user circle icon"></i>
              <div class="content">
                <div class="header">
                  <a target="_blank" href="{{ route('admin.users.show', $lastSale->creator) }}">
                    {{ $lastSale->creator->firstname }}</a>
                    sold a
                    <a target="_blank" href="{{ route('admin.members.show', $lastSale->customer->member) }}">{{ $lastSale->customer->member->type->name }}</a>
                    to <a target="_blank" href="{{ route('admin.users.show', $lastSale->customer) }}">{{ $lastSale->customer->fullname }}</a>
                </div>
                <div class="description">
                  {{ Date::parse($lastSale->created_at)->ago() }}
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>
    @endif

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "C"))
    {{-- Bulletin --}}
    <div class="ui raised segment">
      <div class="ui dividing header">
        <i class="comments outline icon"></i>
        <div class="content">
          Bulletin
          <div class="sub header">
          Open posts
          </div>
        </div>
      </div>
      <div class="ui relaxed divided list">
        @foreach (\App\Post::where('open', true)->latest()->take(5)->get() as $post)
          <div class="item">
            <i class="big user circle icon"></i>
            <div class="content">
              <div class="header">
                <a href="{{ route('admin.users.show', $post->author) }}" target="_blank">{{ $post->author->firstname }}</a>
                created a post <a href="{{ route('admin.posts.show', $post->id) }}" target="_blank">{{ $post->title }}</a>
                <div class="ui black label"><i class="tag icon"></i>{{ $post->category->name }}</div>
                @if ($post->sticky)
                  <div class="ui red label"><i class="info circle icon"></i> important</div>
                @endif
              </div>
              <div class="description"><i class="calendar outline alternate icon"></i>{{ $post->created_at->diffForHumans() }} | <i class="comments icon"></i>{{ $post->replies->count() }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</div>

<div class="ui fullscreen modal" id="details"></div>

@include('admin.calendar._fetch-sales')
@include('admin.calendar._fetch-events')

<script>

function loadCalendars() {
  $('#calendars').fullCalendar({
    header: false,
    defaultView: 'listDay',
    defaultDate: moment().format('YYYY-MM-DD'),
    contentHeight: 150,
    hiddenDays: [0],
    navLinks: true,
    editable: false,
    eventLimit: true,
    minTime: '08:00:00',
    events: '/api/calendar/sales',
    titleFormat: 'dddd, MMMM D, YYYY',
    eventClick: function(calEvent, jsEvent, view) {
      var eventSource = $('#calendars').fullCalendar('option', 'events')
      if (eventSource == '/api/calendar/sales') {
        fetchSales(calEvent, jsEvent, view)
      } else {
        fetchEvents(calEvent, jsEvent, view)
      }
    }
  })
  setTitle()
}

function refetchEvents() {
  $('#calendars').fullCalendar('refetchEvents')
}

function setTitle() {
  var title = $('#calendars').fullCalendar('getView').title
  $('#calendar-title').html(title)
}

function toggleCalendar(type) {
  $('#calendars').fullCalendar('removeEventSources')
  $('#calendars').fullCalendar('option', 'events', `/api/calendar/${type}`)
  $('#calendars').fullCalendar('addEventSource', `/api/calendar/${type}`)
}

$(document).ready(function() {
  loadCalendars()
})

window.onload = function() {
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
        legend: { display: true },
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
    type: 'polarArea',
    data: {
      labels: [
              <?php
                foreach (App\TicketType::all() as $ticketType) {
                  echo "'" . $ticketType->name . "',";
                }
              ?>
             ],
      datasets: [{
        label: 'Attendance ',
        data: [
          <?php
            foreach (App\TicketType::all() as $ticketType) {
              echo getAttendanceByType($ticketType->id) . ",";
            }
          ?>
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
}

</script>

@endsection
