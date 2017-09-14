@extends('layout.admin')

@section('title', 'Edit Event')

@section('subtitle', $event->show->name)

@section('icon', 'calendar')

@section('content')

  {!! Form::model($event, ['route' => ['admin.events.update', $event], 'class' => 'ui form', 'method' => 'PUT']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.events.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="field">
      {!! Form::label('show', 'Show') !!}
      {!! Form::select('show_id', $shows, null, ['placeholder' => 'Select a show', 'class' => 'ui search dropdown']) !!}
    </div>
    <div class="field">
      {!! Form::label('type', 'Type') !!}
      <div class="ui selection dropdown">
        {!! Form::hidden('type', null) !!}
        <i class="dropdown icon"></i>
        <div class="default text">Select an event type</div>
        <div class="menu">
          <div class="item" data-value="matinee">matinee</div>
          <div class="item" data-value="weekend">weekend</div>
          <div class="item" data-value="special event">special event</div>
          <div class="item" data-value="ctc event">ctc event</div>
        </div>
      </div>
    </div>
    <div class="field">
      {!! Form::label('seats', 'Seats') !!}
      {!! Form::text('seats', App\Setting::find(1)->seats, ['placeholder' => 'Number of seats']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('start', 'Start Date') !!}
      <div class="ui left icon input">
        {!! Form::text('start',
                       Date::parse($event->start)->format('l, F j, Y g:i A'),
                       ['placeholder' => 'Event Date and Time', 'id' => 'start'])
        !!}
        <i class="calendar icon"></i>
      </div>
    </div>
    <div class="field">
      {!! Form::label('end', 'End Date') !!}
      <div class="ui left icon input">
        {!! Form::text('end',
                        Date::parse($event->end)->format('l, F j, Y H:i A'),
                        ['placeholder' => 'Event End Date and Time', 'id' =>'end'])
        !!}
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
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
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
      document.querySelector('#end').value = moment(this.value, 'dddd, MMMM DD, YYYY h:mm A').add(1, 'hours').format('dddd, MMMM DD, YYYY h:mm A');
    }

  </script>

@endsection
