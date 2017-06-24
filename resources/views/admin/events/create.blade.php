@extends('layout.admin')

@section('title', 'Add Event')

@section('content')

  <h2 class="ui dividing header">
    <i class="users icon"></i>
    <div class="content">
      Add Event
      <div class="sub header"></div>
    </div>
  </h2>

  {!! Form::open(['route' => 'admin.events.store', 'class' => 'ui form']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.events.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Event', ['type' => 'submit', 'class' => 'ui primary button']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('show', 'Show') !!}
      {!! Form::select('show', $shows, null, ['placeholder' => 'Select a show']) !!}
    </div>
    <div class="field">
      {!! Form::label('type', 'Type') !!}
      {!! Form::select('type',
        [
        'matinee'       => 'matinee',
        'weekend'       => 'weekend',
        'special event' => 'special event',
        'ctc event'     => 'ctc event',
      ], null, ['placeholder' => 'Select a show type']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="field">
      {!! Form::label('date', 'Date') !!}
      {!! Form::date('date', null, ['placeholder' => 'Event Date']) !!}
    </div>
    <div class="field">
      {!! Form::label('starttime', 'Start Time') !!}
      {!! Form::text('starttime', null, ['placeholder' => 'Start Time']) !!}
    </div>
    <div class="field">
      {!! Form::label('endtime', 'End Time') !!}
      {!! Form::text('endtime', null, ['placeholder' => 'End Time']) !!}
    </div>
  </div>
  <div class="field">
    {!! Form::label('memo', 'Email') !!}
    {!! Form::textarea('memo', null, ['placeholder' => 'Write a memo here']) !!}
  </div>
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.events.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Event', ['type' => 'submit', 'class' => 'ui primary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

@endsection
