@extends('layout.admin')

@section('title', 'Add Event')

@section('subtitle', 'New Event')

@section('icon', 'calendar check')


@section('content')

  {!! Form::open(['route' => 'admin.events.store', 'class' => 'ui form']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.events.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Event', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="field">
      {!! Form::label('show_id', 'Show') !!}
      {!! Form::select('show_id', $shows, null, ['placeholder' => 'Select a show', 'class' => 'ui search dropdown']) !!}
    </div>
    <div class="field">
      {!! Form::label('type_id', 'Type') !!}
      {!! Form::select('type_id', $eventTypes, null, ['placeholder' => 'Select event type', 'class' => 'ui dropdown']) !!}
    </div>
    <div class="field">
      {!! Form::label('seats', 'Seats') !!}
      {!! Form::text('seats', App\Setting::find(1)->seats, ['placeholder' => 'Number of seats']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
        {!! Form::label('start', 'Start Date and Time') !!}
        <div class="ui left icon input">
          {!! Form::text('start', null, ['placeholder' => 'Event Date and Time', 'id' => 'start']) !!}
        <i class="calendar icon"></i>
      </div>
    </div>
    <div class="field">
      {!! Form::label('end', 'End Date and Time') !!}
      <div class="ui left icon input">
        {!! Form::text('end', null, ['placeholder' => 'Event End Date and Time', 'id' =>'end']) !!}
        <i class="calendar icon"></i>
      </div>
    </div>
  </div>
  <div class="field">
    {!! Form::label('memo', 'Memo') !!}
    {!! Form::textarea('memo', null, ['placeholder' => 'Write a memo here']) !!}
  </div>
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.events.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Event', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

  <script>

    $('.ui.form').form({ fields: { seats: ['number', 'empty'] }});

    var simplemde = new SimpleMDE({
        element: document.getElementById('memo'),
        toolbar: false
    });

    $('#start').flatpickr({enableTime:true, minDate: 'today', dateFormat: 'l, F j, Y h:i K'});
    $('#end').flatpickr({enableTime:true, minDate: function() {$('#start').val()}, dateFormat: 'l, F j, Y h:i K'});

    document.querySelector('#start').onchange = function() {
      document.querySelector('#end').value = moment(this.value, 'dddd, MMMM D, YYYY h:mm A').add(1, 'hours').format('dddd, MMMM D, YYYY h:mm A');
    }

  </script>

@endsection
