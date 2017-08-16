@extends('layout.astral')

@section('title', 'Welcome!')

@section('content')

  <h2 class="ui dividing header">
    <i class="user icon"></i>
    <div class="content">
      My Account
      <div class="sub header">{{ $user->firstname }} {{ $user->lastname }}</div>
    </div>
  </h2>

  {!! Form::model($user, ['route' => ['selfupdate', $user], 'class' => 'ui form', 'method' => 'PUT']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('firstname', 'First Name') !!}
      {!! Form::text('firstname', null, ['placeholder' => 'First Name']) !!}
    </div>
    <div class="field">
      {!! Form::label('lastname', 'Last Name') !!}
      {!! Form::text('lastname', null, ['placeholder' => 'Last Name']) !!}
    </div>
  </div>
  <div class="field">
      {!! Form::label('email', 'Email') !!}
      {!! Form::text('email', null, ['placeholder' => 'Email']) !!}
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('password', 'Password') !!}
      {!! Form::password('password', null, ['placeholder' => 'Password']) !!}
    </div>
    <div class="field">
      {!! Form::label('password_confirmation', 'Confirm Password') !!}
      {!! Form::password('password_confirmation', null, ['placeholder' => 'Last Name']) !!}
    </div>
  </div>
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

@endsection
