@extends('layout.admin')

@section('title', 'Events')

@section('subtitle', 'Manage Events')

@section('icon', 'calendar')

@section('content')

  <a class="ui secondary button" href="{{ route('admin.events.create') }}">
    <i class="calendar plus icon"></i> Create Event
  </a>

  <!--<div class="ui right icon input">
    <input type="text" placeholder="Search...">
    <i class="search link icon"></i>
  </div>-->

  @if (!isset($events) || count($events) > 0)
    <br /><br />
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
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'listDay,listWeek,listMonth'
      },
      views: {
        listDay: {buttonText: 'Single Day View'},
        listWeek: {buttonText: 'Week View'},
        listMonth: {buttonText: 'Month View'},
      },
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

  $(document).ready(loadCalendar)


  setInterval(refetchEvents, 5000)


</script>

@endsection
