@extends('layout.admin')

@section('title', 'New Calendar')

@section('subtitle', null)

@section('icon',     'calendar alternate')

@section('content')

<script>
    $(function() {

        // page is now ready, initialize the calendar...

        $('#calendar').fullCalendar({
            events: "/api/v2/calendar/events",
            defaultView: "agendaWeek",
            hiddenDays: [0]
        })

    });
</script>

<div id="calendar"></div>

@endsection