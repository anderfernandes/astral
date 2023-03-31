@extends('layout.admin')

@section('title', 'Calendar')

@section('subtitle', null)

@section('icon', 'calendar alternate')

@section('content')

<div class="ui black icon buttons">
  <div onclick="$('#admin-calendar').fullCalendar('prev')" class="ui button"><i class="left chevron icon"></i></div>
  <div class="ui change date button"><i class="calendar alternate icon"></i></div>
  <div onclick="$('#admin-calendar').fullCalendar('next')" class="ui button"><i class="right chevron icon"></i></div>
</div>

@if (str_contains(Auth::user()->role->permissions['calendar'], "C"))
<a class="ui black button" href="{{ route('admin.events.create') }}">
  <i class="calendar plus icon"></i> Create Event
</a>
@endif

@if (str_contains(Auth::user()->role->permissions['sales'], "C"))
<a href="{{ @route('admin.sales.index') }}" class="ui black button">
  <i class="icons"><i class="dollar icon"></i><i class="corner plus inverted icon"></i></i>
  Create Sale
</a>
@endif

<div class="ui right floated black icon button" onclick="$('#event-colors').modal('toggle')">
  <i class="help circle icon"></i>
</div>

<div class="ui right floated black icon button" onclick="window.print()">
  <i class="print icon"></i>
</div>

<div class="ui right floated secondary floating dropdown button" id="view">
  <i class="eye icon"></i>
  <span class="text">
    @if ($request->view == "agendaDay")
    Single Day
    @elseif ($request->view == "agendaWeek")
    Week
    @else
    Month
    @endif
  </span>
  <i class="dropdown icon"></i>
  <div class="menu">
    <div onclick="$('#admin-calendar').fullCalendar('changeView', 'agendaDay')" class="{{ $request->view == 'agendaDay' ? 'active' : null }} item">Single Day</div>
    <div onclick="$('#admin-calendar').fullCalendar('changeView', 'agendaWeek')" class="{{ $request->view == 'agendaWeek' ? 'active' : null }} item">Week</div>
    <div onclick="$('#admin-calendar').fullCalendar('changeView', 'month')" class="{{ $request->view == 'month' ? 'active' : null }} item">Month</div>
  </div>
</div>

<div class="ui right floated secondary floating dropdown button">
  <i class="calendar alternate outline icon"></i>
  <span class="text">Events</span>
  <i class="dropdown icon"></i>
  <div class="menu">
    <div onclick="toggleCalendar('events')" class="{{ $request->type == "events" ? "active" : "" }} item">Events</div>
    <div onclick="toggleCalendar('sales')" class="{{ $request->type == "sales" ? "active" : "" }} item">Sales</div>
  </div>
</div>

@if (!isset($events) || $events->count() > 0)
<br /><br />
<div class="ui doubling stackable grid">
  <div id="admin-calendar" style="min-width:100%; max-width:100%; padding-bottom: 2rem"></div>
</div>
@else
<div class="ui info icon message">
  <i class="info circle icon"></i>
  <i class="close icon"></i>
  <div class="content">
    <div class="header">
      No events!
    </div>
    <p>It looks like there are no events in the database.</p>
  </div>
</div>
@endif

@include('admin.partial.events._create')

@include('admin.partial.help._event-colors')

<div class="ui fullscreen modal" id="details"></div>

@include('admin.calendar._fetch-sales')
@include('admin.calendar._fetch-events')

<script>
  function loadCalendar() {
    $('#admin-calendar').fullCalendar({
      views: {
        week: {
          hiddenDays: [0],
        },
      },
      header: false,
      defaultView: '{{ $request->view ?? 'agendaWeek' }}',
      defaultDate: moment('{{ $request->date ?? today() }}').format('YYYY-MM-DD'),
      contentHeight: 'auto',
      navLinks: true,
      displayEventTime: false,
      navLinkDayClick: function(date, jsEvent) {
        $('#view').dropdown('set exactly', 'Single Day')
        $('#admin-calendar').fullCalendar('gotoDate', date)
        $('#admin-calendar').fullCalendar('changeView', 'agendaDay')
        setTitle()
      },
      editable: false,
      eventLimit: true,
      minTime: '08:00:00',
      titleFormat: 'dddd, MMMM D, YYYY',
      events: '{{ $request->type == "sales" ? ' / api / calendar / sales ' : ' / api / calendar / events ' }}',
      loading: function(isLoading, view) {
        if (!isLoading) setTitle()
      },
      eventClick: function(calEvent, jsEvent, view) {
        var eventSource = $('#admin-calendar').fullCalendar('option', 'events')
        if (eventSource == '/api/calendar/sales') {
          fetchSales(calEvent, jsEvent, view)
        } else {
          fetchEvents(calEvent, jsEvent, view)
        }
      }
    })
  }

  function setTitle() {
    var view = $('#admin-calendar').fullCalendar('getView')
    var title = (view.name == 'month') ?
      moment(view.intervalStart).format('MMMM YYYY') :
      view.title
    $('.header.active.item.hide-on-mobile').html(`<i class="calendar alternate icon"></i> Calendar | <strong>${title}</strong>`)
    document.title = ` Calendar | ${title}`
  }

  //$(document).ready(loadCalendar)

  $(document).ready(function() {
    loadCalendar()
  })

  $('.ui.button').click(setTitle)

  function toggleCalendar(type) {
    $('#admin-calendar').fullCalendar('removeEventSources')
    $('#admin-calendar').fullCalendar('option', 'events', `/api/calendar/${type}`)
    $('#admin-calendar').fullCalendar('addEventSource', `/api/calendar/${type}`)
  }

  setInterval(() => {
    $('#admin-calendar').fullCalendar('refetchEvents')
  }, 15000)

  $('.ui.change.date.button').flatpickr({
    onChange: function(selectedDates, dateStr, instance) {
      $('#admin-calendar').fullCalendar('gotoDate', dateStr)
    }
  })
</script>

<style>
  @media print {

    .ui.button,
    .ui.label {
      display: none !important;
    }
</style>

@endsection