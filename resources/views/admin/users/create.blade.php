@extends('layout.admin')

@section('title', 'Add User')

@section('content')

  <h2 class="ui dividing header">
    <i class="users icon"></i>
    <div class="content">
      Add User
      <div class="sub header"></div>
    </div>
  </h2>

  {!! Form::open(['route' => 'admin.users.store', 'class' => 'ui form']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.users.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="add user icon"></i> Add User', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
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
  <div class="two fields">
    <div class="field">
      {!! Form::label('role', 'Role') !!}
      {!! Form::select('role',
        ['admin' => 'admin', 'teacher' => 'teacher'],
        null,
        ['placeholder' => 'Role', 'class' => 'ui dropdown']) !!}
    </div>
    <div class="field">
      {!! Form::label('email', 'Email') !!}
      {!! Form::text('email', null, ['placeholder' => 'Email']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('password', 'Password') !!}
      {!! Form::password('password', null, ['placeholder' => 'Password']) !!}
    </div>
    <div class="field">
      {!! Form::label('password_confirmation', 'Confirm Password') !!}
      {!! Form::password('password_confirmation', null, ['placeholder' => 'Confirm Password']) !!}
    </div>
  </div>
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.users.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="add user icon"></i> Add User', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

@endsection
