@extends('layout.admin')

@section('title', 'Edit Show')

@section('content')

  <h2 class="ui dividing header">
    <i class="edit icon"></i>
    <div class="content">
      Edit Show
      <div class="sub header">{{ $show->name }}</div>
    </div>
  </h2>

  {!! Form::model($show, ['route' => ['admin.shows.update', $show], 'class' => 'ui form', 'method' => 'PUT']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.shows.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save Changes', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="field">
      {!! Form::label('name', 'Name') !!}
      {!! Form::text('name', null, ['placeholder' => 'What\'s the name of the show?']) !!}
    </div>
    <div class="field">
      {!! Form::label('type', 'Type') !!}
      {!! Form::select('type',
        ['Planetarium' => 'Planetarium', 'Laser Light' => 'Laser Light'],
        null,
        ['placeholder' => 'Planetarium or Laser?', 'class' => 'ui dropdown']) !!}
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
      {!! Form::button('<i class="save icon"></i> Save Changes', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}



@endsection
