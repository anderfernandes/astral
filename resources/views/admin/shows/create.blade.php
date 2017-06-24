@extends('layout.admin')

@section('title', 'Add Shows')

@section('content')

  <h2 class="ui dividing header">
    <i class="edit icon"></i>
    <div class="content">
      Add Show
      <div class="sub header"></div>
    </div>
  </h2>

  {!! Form::open(['route' => 'admin.shows.store', 'class' => 'ui form']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.shows.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Show', ['type' => 'submit', 'class' => 'ui primary button']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="field">
      {!! Form::label('name', 'Name') !!}
      {!! Form::text('name', null, ['placeholder' => 'What\'s the name of the show?']) !!}
    </div>
    <div class="field">
      {!! Form::label('type', 'Type') !!}
      {!! Form::select('type', ['Planetarium' => 'Planetarium', 'Laser Light' => 'Laser Light'], ['placeholder' => 'Planetarium or Laser?']) !!}
    </div>
    <div class="field">
      {!! Form::label('duration', 'Duration') !!}
      <div class="ui right labeled input">
        {!! Form::text('duration', null, ['placeholder' => 'How many minutes long is the show?']) !!}
        <div class="ui label">minutes</div>
      </div>

    </div>
  </div>
  <div class="field">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['placeholder' => 'What is the show about?']) !!}
  </div>
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.shows.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Show', ['type' => 'submit', 'class' => 'ui primary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

@endsection
