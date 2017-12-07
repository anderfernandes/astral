@extends('layout.admin')

@section('title', 'Calendar')

@section('subtitle', App\Setting::find(1)->organization)

@section('icon', 'calendar')

@section('content')

  <a class="ui secondary button" href="{{ route('admin.events.create') }}">
    <i class="calendar plus icon"></i> Create Event
  </a>
  <a class="ui secondary button" href="{{ route('admin.sales.create') }}">
    <i class="dollar sign icon"></i> Create Sale
  </a>

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
        right: 'agendaDay,agendaWeek,month'
      },
      views: {
        agendaDay: {buttonText: 'Single Day View'},
        agendaWeek: {buttonText: 'Week View'},
        month: {buttonText: 'Month View'},
      },
      defaultView: 'agendaWeek',
      defaultDate: moment().format('YYYY-MM-DD'),
      contentHeight: 'auto',
      hiddenDays: [0],
      navLinks: true,
      editable: false,
      eventLimit: true,
      minTime: '07:00:00',
      eventColor: '#000',
      events: '/api/calendar',
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
