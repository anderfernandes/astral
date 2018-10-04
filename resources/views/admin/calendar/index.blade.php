@extends('layout.admin')

@section('title', 'Calendar')

@section('subtitle', null)

@section('icon', 'calendar alternate')

@section('content')

  <div class="ui black icon buttons">
    <div onclick="$('#admin-calendar').fullCalendar('prev')" class="ui button"><i class="left chevron icon"></i></div>
    <div onclick="$('#admin-calendar').fullCalendar('today')" class="ui button"><i class="calendar outline icon"></i></div>
    <div onclick="$('#admin-calendar').fullCalendar('next')" class="ui button"><i class="right chevron icon"></i></div>
  </div>

  @if (str_contains(Auth::user()->role->permissions['calendar'], "C"))
  <div class="ui black button" onclick="$('#create-event').modal('toggle')">
    <i class="calendar plus icon"></i> Create Event
  </div>
  @endif

  @if (str_contains(Auth::user()->role->permissions['sales'], "C"))
  <div class="ui dropdown black button">
    <i class="icons"><i class="dollar icon"></i><i class="corner plus inverted icon"></i></i>
    Create Sale
    <i class="dropdown icon"></i>
    <div class="menu">
      @foreach (App\EventType::where('id', '!=', 1)->get() as $eventType)
        @if ($eventType->allowedTickets->count() > 0)
        <a href="{{ route('admin.sales.create') }}?eventType={{ $eventType->id }}" class="item">{{ $eventType->name }}</a>
        @endif
      @endforeach
    </div>
  </div>
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
      header: false,
      views: null,
      defaultView: '{{ $request->view ?? 'agendaWeek' }}',
      defaultDate: moment('{{ $request->date ?? today() }}').format('YYYY-MM-DD'),
      contentHeight: 'auto',
      hiddenDays: [0],
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
      events: '{{ $request->type == "sales" ? '/api/calendar/sales' : '/api/calendar/events' }}',
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
    var title = $('#admin-calendar').fullCalendar('getView').title
    $('.header.active.item.hide-on-mobile').html(`<i class="calendar alternate icon"></i> Calendar | <strong>${title}</strong>`)
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

  setInterval(() => { $('#admin-calendar').fullCalendar('refetchEvents') }, 5000)


</script>

  <style>
    @media print {
      .ui.button, .ui.label {
        display: none !important;
      }
  </style>

@endsection
