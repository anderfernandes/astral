@extends('layout.admin')

@section('title', 'Add Event')

@section('subtitle', 'New Event')

@section('icon', 'calendar')


@section('content')

  {!! Form::open(['route' => 'admin.events.store', 'class' => 'ui form']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.events.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Event', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('show', 'Show') !!}
      {!! Form::select('show', $shows, null, ['placeholder' => 'Select a show', 'class' => 'ui search dropdown']) !!}
    </div>
    <div class="field">
      {!! Form::label('type', 'Type') !!}
      <div class="ui selection dropdown">
        {!! Form::hidden('type', null) !!}
        <i class="dropdown icon"></i>
        <div class="default text">Select a show type</div>
        <div class="menu">
          <div class="item" data-value="matinee">matinee</div>
          <div class="item" data-value="weekend">weekend</div>
          <div class="item" data-value="special event">special event</div>
          <div class="item" data-value="ctc event">ctc event</div>
        </div>
      </div>
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
  <div class="four fields">
    <div class="field">
      {!! Form::label('adults_price', 'Adult Ticket Price') !!}
      <div class="ui labeled input">
        <div class="ui label">
          $
        </div>
        {!! Form::number('adults_price', null, ['placeholder' => 'Adult Ticket Price', 'step' => '0.50', 'min' => 0]) !!}
      </div>
    </div>
    <div class="field">
      {!! Form::label('children_price', 'Children Ticket Price') !!}
      <div class="ui labeled input">
        <div class="ui label">
          $
        </div>
        {!! Form::number('children_price', null, ['placeholder' => 'Adult Ticket Price', 'step' => '0.50', 'min' => 0]) !!}
      </div>
    </div>
    <div class="field">
      {!! Form::label('members_price', 'Member Ticket Price') !!}
      <div class="ui labeled input">
        <div class="ui label">
          $
        </div>
        {!! Form::number('members_price', null, ['placeholder' => 'Member Ticket Price', 'step' => '0.50', 'min' => 0]) !!}
      </div>
    </div>
    <div class="field">
      {!! Form::label('seats', 'Number of Seats Available') !!}
      {!! Form::number('seats', App\Setting::find(1)->seats, ['placeholder' => 'Number of Seats Available', 'min' => 0]) !!}
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
