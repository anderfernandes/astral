@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->fullname)

@section('icon', 'dashboard')

@section('content')

@include('admin.announcements._announcement')

<style>
  .pusher {
    background: linear-gradient(rgba(253,254,255,1), rgba(253,254,255,0.5)), url('{{ App\Setting::find(1)->cover }}') !important;
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
      <div class="ui dividing header">
        <i class="calendar alternate icon"></i>
        <div class="content">
          Calendar
          <div class="sub header" id="calendar-title"></div>
        </div>
      </div>
      <div class="ui black icon buttons">
        <div onclick="$('#calendars').fullCalendar('prev'); setTitle()" class="ui button"><i class="left chevron icon"></i></div>
        <div onclick="$('#calendars').fullCalendar('today'); setTitle()" class="ui button"><i class="checked calendar icon"></i></div>
        <div onclick="$('#calendars').fullCalendar('next'); setTitle()" class="ui button"><i class="right chevron icon"></i></div>
      </div>
      <div class="ui secondary floating dropdown labeled icon button" style="margin-bottom: 0.5rem">
        <i class="calendar alternate outline icon"></i>
        <span class="text">Sales</span>
        <div class="menu">
          <div onclick="toggleCalendar('calendar')" class="active item">Sales</div>
          <div onclick="toggleCalendar('events')" class="item">Events</div>
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
          <canvas height="300" id="attendanceChart"></canvas>
        </div>
        <div class="column">
          <canvas height="300" id="secondAttendanceChart"></canvas>
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
              <div class="description"><i class="calendar outline alternate icon"></i>{{ Date::parse($post->created_at)->ago() }} | <i class="comments icon"></i>{{ $post->replies->count() }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @endif

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
    titleFormat: 'dddd, MMMM D, YYYY',
    eventClick: function(calEvent, jsEvent, view) {
      fetch(`/api/event/${calEvent.id}`)
        .then(response => response.json())
        .then(response => {

          document.querySelector('#event-detail').innerHTML = null

          var memos = ''

          if (response.memos.length > 0) {
            response.memos.forEach(function (memo)
            {
              memos +=
              `
              <div class="comment">
                <div class="avatar"><i class="user circle big icon"></i></div>
                <div class="content">
                  <div class="author">
                    ${memo.author.name}
                    <div class="ui tiny black label">${memo.author.role}</div>
                    <div class="metadata">
                      <span class="date">${moment(memo.created_at).calendar()}</span>
                    </div>
                  </div>
                  <div class="text">
                    ${memo.message}
                  </div>
                </div>
              </div>
              `
            }
          )
        } else {
          memos =
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

          var dateFormat = response.allDay ? 'dddd, MMMM D, YYYY' : 'dddd, MMMM D, YYYY [at] h:mm A'

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

              var products = ``
              sale.products.forEach(function (product) {
                products +=
                `
                <div class="ui black label" style="margin-left:0">
                  <i class="box icon"></i>
                  ${product.quantity} <div class="detail">${product.name}</div>
                </div>
                `
              })

              {{-- This function gets the sale status and returns it prettified in the modal --}}
              function getSaleStatus(status) {
                switch(status) {
                  case 'complete'  : return `<div class="ui green label"><i class="checkmark icon"></i>${status}</div>`
                  case 'no show'   : return `<div class="ui orange label"><i class="thumbs outline down icon"></i>${status}</div>`
                  case 'open'      : return `<div class="ui violet label"><i class="unlock icon"></i>${status}</div>`
                  case 'tentative' : return `<div class="ui yellow label"><i class="help icon"></i>${status}</div>`
                  case 'canceled'  : return `<div class="ui red label"><i class="remove icon"></i>${status}</div>`
                }
              }

              sales +=
              `
              <div class="ui ${sale.status == 'canceled' ? `red raised` : `raised`} card">
                <div class="content">
                  <div class="header">
                    <a href="/admin/sales/${sale.id}" target="_blank" style="padding: 0 0 0 0">Sale # ${sale.id}</a>
                    <div class="right floated">
                      <div class="ui black tag label"><i class="dollar icon"></i> ${parseFloat(sale.total).toFixed(2)}</div>
                      ${getSaleStatus(sale.status)}
                    </div>
                  </div>
                  <a class="meta" href="/admin/users/${sale.creator.id}" target="_blank"><i class="user circle icon"></i> ${sale.creator.name}</a>
                  <div class="meta"><i class="pencil icon"></i> ${moment(sale.created_at).format('dddd, MMMM D, YYYY [at] h:mm:ss A')} (${moment(sale.created_at).fromNow()})</div>
                  ${sale.organization.name == sale.customer.name ? `` : `<a class="description" href="/admin/users/${sale.customer.id}" target="_blank"><i class="user icon"></i> ${sale.customer.name}</a>`}<br>
                  ${sale.organization.id != 1 ? `<a class="description" href="/admin/organizations/${sale.organization.id}" target="_blank"><i class="university icon"></i> ${sale.organization.name}</a>`  : `` }
                  <br><br>
                  <div class="description">${tickets} ${products}</div>
                </div>
              </div>
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

          var header =
          `
          <i class="close icon"></i>
          <div class="ui header">
            <i class="calendar check icon"></i>
            <div class="content">
              Event #${response.id}
            </div>
          </div>
          `
          var body = `
          <div class="scrolling content">
            <div class="ui items">
              <div class="ui item">
                ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui rounded small image"><img src="${response.show.cover}"></div>`}
                <div class="content">
                  <div class="meta">
                    <div class="ui label" style="background-color: ${response.color}; color: rgba(255, 255, 255, 0.8)">${response.type}</div>
                      ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui label">${response.show.duration} minutes</div>`}
                      ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui label">${response.tickets_sold} tickets sold</div>`}
                      <div class="ui basic label">${response.public ? `Public` : `Private`}</div>
                    </div>
                    <div class="ui large header">
                      ${ (response.allDay || response.show.id == 1) ? response.memo : response.show.name}
                      <div class="sub header">
                        <i class="calendar alternate icon"></i>${moment(response.start).format(dateFormat)}
                        (${moment(response.start).fromNow()})
                        </div>
                    </div>
                    <div class="extra">
                      <p><i class="user circle icon"></i> ${response.creator.name}</p>
                      <p><i class="pencil icon"></i> ${moment(response.created_at).format(dateFormat)} (${moment(response.created_at).fromNow()})</p>
                      <p><i class="edit icon"></i> ${moment(response.updated_at).format(dateFormat)} (${moment(response.updated_at).fromNow()})</p>
                    </div>
                    <div class="description">
                    ${ (response.allDay || response.show.id == 1) ? `` : `<i class="info circle icon"></i> ${ response.show.description}` }
                    </div>
                    <div class="ui basic segment">
                      <h4 class="ui horizontal divider header">
                        <i class="comment alternate outline icon"></i> Memos
                      </h4>
                      ${response.memos.length > 0 ? `<div class="ui comments">${memos}</div>` : memos}
                    </div>
                    <div class="ui basic segment">
                    ${ (response.allDay || response.show.id == 1) ? `` :
                      `
                      <h4 class="ui horizontal divider header">
                        <i class="dollar icon"></i> Sales
                      </h4>
                      <div class="ui two doubling stackable cards">
                        ${sales}
                      </div>
                      `
                    }
                  </div>
                </div>
              </div>
            </div>
          </div>
          `
          var deleteButton = ''

          if (response.sales.length <= 0) {
            deleteButton =
            `
            <form action="/admin/events/${response.id}" method="POST" style="display:contents">
              <input type="hidden" name="_method" value="DELETE">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <button class="ui red right labeled icon button" type="submit">
                Delete
                <i class="trash icon"></i>
              </button>
            </form>
            `
          }

          var footer = `
          <div class="actions">
            ${deleteButton}
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
  setTitle()
}

function refetchEvents() {
  $('#events').fullCalendar('refetchEvents')
  $('#calendars').fullCalendar('refetchEvents')
}

function setTitle() {
  var title = $('#calendars').fullCalendar('getView').title
  $('#calendar-title').html(title)
}

$(document).ready(function() {
  loadCalendars()
})

setInterval(refetchEvents, 5000)

function toggleCalendar(type) {
  $('#calendars').fullCalendar('removeEventSources')
  $('#calendars').fullCalendar('addEventSource', '/api/' + type)
  setTitle()
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
