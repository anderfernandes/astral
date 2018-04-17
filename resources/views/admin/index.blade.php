@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->fullname)

@section('icon', 'dashboard')

@section('content')

<style>
/*.ui..raised.center.aligned.segment {display: none}*/
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
{{-- Welcome Box --}}
<div class="ui grid">
  <div class="sixteen wide column" style="margin-bottom: -1rem">
    <div class="ui icon message">
      <i class="announcement icon"></i>
      <div class="content">
        <div class="header">Welcome, {{ Auth::user()->firstname }}!</div>
        If you are new, make sure you visit our <a href="http://astral.anderfernandes.com/docs" target="_blank">documentation website</a> for instructions
        on how to use Astral.
      </div>
      </div>
  </div>

  <div class="eight wide computer sixteen wide mobile column">
    {{-- Overall Earnings --}}
    <div class="ui segment">
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
    {{-- Calendar --}}
    <div class="ui segment">
      <div class="ui dividing header">
        <i class="calendar alternate icon"></i>
        <div class="content">
          Calendar
          <div class="sub header">
          {{ App\Setting::find(1)->organization }}
          </div>
        </div>
      </div>
      <div class="ui black icon buttons">
        <div onclick="$('#calendars').fullCalendar('prev')" class="ui button"><i class="left chevron icon"></i></div>
        <div onclick="$('#calendars').fullCalendar('today')" class="ui button"><i class="checked calendar icon"></i></div>
        <div onclick="$('#calendars').fullCalendar('next')" class="ui button"><i class="right chevron icon"></i></div>
      </div>
      <div class="ui secondary floating dropdown labeled icon button" style="margin-bottom: 0.5rem">
        <i class="calendar alternate outline icon"></i>
        <span class="text">Reservations</span>
        <div class="menu">
          <div onclick="toggleCalendar('calendar')" class="active item">Reservations</div>
          <div onclick="toggleCalendar('events')" class="item">Events</div>
        </div>
      </div>
      <div id="calendars"></div>
    </div>
    {{-- Charts --}}
    <div class="ui horizontal segments">
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
    </div>
  </div>

  <div class="eight wide computer sixteen wide mobile column">
    {{-- Attendance --}}
    <div class="ui segment">
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
    {{-- Bulletin --}}
    <div class="ui segment">
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
              <div class="description"><i class="calendar outline alternate icon"></i>{{ Date::parse($post->created_at)->ago() }} | <i class="comments icon"></i>{{ $post->replies->count() }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    {{-- Feed --}}
    <div class="ui segment">
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
  </div>
</div>

<div class="ui large modal" id="event-detail"></div>

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
    events: '/api/calendar',
    eventClick: function(calEvent, jsEvent, view) {
      fetch(`/api/event/${calEvent.id}`)
        .then(response => response.json())
        .then(response => {

          // Start this variable with a message box saying that there are no sales for this event
          var sales = ''

          if (response.sales.length > 0) {
            response.sales.forEach(function (sale)
            {
              var tickets = ``
              sale.tickets.forEach(function (ticket) {
                tickets +=
                `
                <div class="ui black label" style="margin-left:0">
                <i class="ticket icon"></i>
                ${ticket.quantity} <div class="detail">${ticket.type}</div>
                </div>
                `
              })
              sales +=
              `
              <h3 class="ui dividing header">
                <div class="content">
                  <a class="sub header" href="/admin/sales/${sale.id}" target="_blank">Sale # ${sale.id}</a>
                  ${sale.organization.id != 1 ? `<a href="/admin/organizations/${sale.organization.id}" target="_blank">${sale.organization.name}</a>`  : `` }
                  ${sale.organization.name == sale.customer.name ? `` : `| <a href="/admin/users/${sale.customer.id}" target="_blank">${sale.customer.name}</a>`}
                  <div class="sub header">
                    <div class="ui green tag label">$ ${parseFloat(sale.total).toFixed(2)}</div>
                    ${tickets}
                  </div>
                </div>
              </h3>
              `
            }
          )
          } else {
            sales =
            `
            <div class="ui info icon message">
              <i class="info circle icon"></i>
              <div class="content">
                <div class="header">
                  No Group Sales!
                </div>
                <p>There are no group sales for this show.</p>
              </div>
            </div>
            `
          }

          if (response.memo == null) {
            response.memo =
            `
            <div class="ui info icon message">
              <i class="info circle icon"></i>
              <div class="content">
                <div class="header">
                  No Memos
                </div>
                <p>No one has left a memo for this event yet.</p>
              </div>
            </div>
            `
          }

          var header = `
          <i class="close icon" style="color: white"></i>
          <div class="ui header">
            <i class="calendar check icon"></i>
            <div class="content">
              Event Details
              <div class="sub header">Event #${response.id}</div>
            </div>
          </div>
          `
          var body = `
          <div class="content">
            <div class="ui items">
              <div class="ui item">
                <div class="ui small rounded image"><img src="${response.show.cover}"></div>
                <div class="content">
                  <div class="meta">
                  <div class="ui label" style="background-color: ${response.color}; color: rgba(255, 255, 255, 0.8)">${response.type}</div>
                    <div class="ui label">${response.show.duration} ${response.show.duration > 1 ? `minutes` : `minute`}</div>
                    <div class="ui label">${response.tickets_sold} tickets sold</div>
                  </div>
                  <div class="ui large header">
                    ${response.show.name}
                    <div class="sub header">
                      <i class="calendar alternate icon"></i>
                      ${moment(response.start).calendar()}
                    </div>
                  </div>
                  <div class="extra">
                    <p>Created by ${response.creator.name} on ${moment(response.created_at).format('dddd, MMMM D, YYYY [at] h:mm:ss A')}</p>
                    <p>Updated on ${moment(response.updated_at).format('dddd, MMMM D, YYYY [at] h:mm:ss A')}</p>
                  </div>
                  <div class="description">
                    <h4 class="ui horizontal divider header">
                      <i class="comment alternate outline icon"></i> Memo
                    </h4>
                    ${response.memo}
                  </div>
                </div>
              </div>
              <div class="ui item">
                <div class="content">
                  <div class="extra">
                  <h4 class="ui horizontal divider header">
                    <i class="dollar icon"></i> Sales
                  </h4>
                  ${sales}
                  </div>
                </div>
              </div>
            </div>
          </div>
          `
          var footer = `
          <div class="actions">
            <a href="/admin/events/${response.id}/edit" class="ui yellow right labeled icon button">
              Edit
              <i class="edit icon"></i>
            </a>
            <div class="ui black deny button">
              Close
            </div>
          </div>
          </div>
          `

        document.querySelector('#event-detail').innerHTML = header + body + footer
        $('#event-detail').modal('show')
      });
    }
  })
}

function refetchEvents() {
  $('#events').fullCalendar('refetchEvents')
  $('#calendars').fullCalendar('refetchEvents')
}

$(document).ready(loadCalendars)

setInterval(refetchEvents, 5000)

function toggleCalendar(type) {
  $('#calendars').fullCalendar('removeEventSources')
  $('#calendars').fullCalendar('addEventSource', '/api/' + type)
}

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
    type: 'pie',
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



//$('.ui..raised.center.aligned.segment')
//.transition({animation:'vertical flip', duration: 2000, interval: 1000 })

</script>

@endsection
