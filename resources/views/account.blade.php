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
      <a href="javascript:window.close()" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="two disabled fields">
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
    <div class="required field">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['placeholder' => 'Email']) !!}
    </div>
    <div class="required field">
      {!! Form::label('phone', 'Phone') !!}
      {!! Form::tel('phone', null, ['placeholder' => 'Enter user\'s phone number']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="required field">
      {!! Form::label('address', 'Address') !!}
      {!! Form::text('address', null, ['placeholder' => 'Enter full organization address']) !!}
    </div>
    <div class="required field">
      {!! Form::label('city', 'City') !!}
      {!! Form::text('city', null, ['placeholder' => 'Enter organization\'s city']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="required field">
      {!! Form::label('country', 'Country') !!}
      @include('partial._countries')
    </div>
    <div class="required field">
      {!! Form::label('state', 'State') !!}
      @include('partial._states')
    </div>
    <div class="required field">
      {!! Form::label('zip', 'ZIP') !!}
      {!! Form::text('zip', null, ['placeholder' => 'ZIP']) !!}
    </div>
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
      <a href="javascript:window.close()" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

  <script>
    var tel = document.querySelectorAll('[type="tel"]');
    for (var i = 0; i < tel.length; i++) {
      tel[i].addEventListener('input', function(e) {
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
      })
    }
  </script>

@endsection
