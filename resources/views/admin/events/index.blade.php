@extends('layout.admin')

@section('title', 'Events')

@section('subtitle', 'Manage Events')

@section('icon', 'calendar')

@section('content')

  <div class="ui black icon buttons">
    <div onclick="$('#calendar').fullCalendar('prev')" class="ui button"><i class="left chevron icon"></i></div>
    <div onclick="$('#calendar').fullCalendar('today')" class="ui button"><i class="checked calendar icon"></i></div>
    <div onclick="$('#calendar').fullCalendar('next')" class="ui button"><i class="right chevron icon"></i></div>
  </div>

  <a class="ui secondary button" href="{{ route('admin.events.create') }}">
    <i class="calendar plus icon"></i> Create Event
  </a>
  <a class="ui secondary button" href="{{ route('admin.sales.create') }}">
    <i class="dollar sign icon"></i> Create Sale
  </a>

  <div class="ui right floated buttons">
    <div class="ui black button"><i class="eye icon"></i>View</div>
    <div class="ui black floating dropdown icon button">
      <i class="dropdown icon"></i>
      <div class="menu">
        <div onclick="$('#calendar').fullCalendar('changeView', 'agendaDay')" class="item">Single Day</div>
        <div onclick="$('#calendar').fullCalendar('changeView', 'agendaWeek')" class="active item">Week</div>
        <div onclick="$('#calendar').fullCalendar('changeView', 'month')" class="item">Month</div>
      </div>
    </div>
  </div>

  @if (!isset($events) || count($events) > 0)
    <br /><br /><br />
    <div class="ui doubling stackable grid">
      <div id="calendar" style="min-width:100%; max-width:100%; padding-bottom: 2rem"></div>
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

<script>

  function loadCalendar(events) {
    $('#calendar').fullCalendar({
      header: false,
      views: null,
      defaultView: 'listWeek',
      defaultDate: moment().format('YYYY-MM-DD'),
      contentHeight: 'auto',
      hiddenDays: [0],
      navLinks: true,
      editable: false,
      eventLimit: true,
      minTime: '07:00:00',
      eventColor: '#1b1c1d',
      events: '/api/events'
    })
    console.log(events)
  }

  function refetchEvents() {
    $('#calendar').fullCalendar('refetchEvents')
  }

  function setTitle() {
    var title = $('#calendar').fullCalendar('getView').title
    $('.header.active.item.hide-on-mobile').html('<i class="calendar icon"></i> Calendar | {{ App\Setting::find(1)->organization }} | <strong>' + title + '</strong>')
  }

  //$(document).ready(loadCalendar)

  $(document).ready(function() {
    loadCalendar()
    setTitle()
  })

  $('.ui.button').click(setTitle)


  setInterval(refetchEvents, 5000)

</script>

@endsection
