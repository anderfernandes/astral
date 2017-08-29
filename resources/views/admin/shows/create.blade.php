@extends('layout.admin')

@section('title', 'Add Show')

@section('subtitle', 'New Show')

@section('icon', 'plus')

@section('content')

  {!! Form::open(['route' => 'admin.shows.store', 'class' => 'ui form']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.shows.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Show', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="two fields">
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
  </div>
  <div class="two fields">
    <div class="field">
        {!! Form::label('duration', 'Duration') !!}
        <div class="ui right labeled input">
          {!! Form::text('duration', null, ['placeholder' => 'How long is the show?']) !!}
          <div class="ui label">minutes</div>
        </div>
      </div>
      <div class="field">
      {!! Form::label('cover', 'Cover') !!}
      {!! Form::text('cover', null, ['placeholder' => 'URL of the cover (PNG or JPEG)']) !!}
    </div>
  </div>
  <div class="field">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['placeholder' => 'What is the show about?']) !!}
  </div>
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.shows.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="plus icon"></i> Add Show', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

  <script>
    var simplemde = new SimpleMDE({
      element: document.getElementById('description'),
      toolbar: false
    })
  </script>

@endsection
