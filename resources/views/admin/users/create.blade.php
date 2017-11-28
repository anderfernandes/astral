@extends('layout.admin')

@section('title', 'Add User')

@section('subtitle', 'New User')

@section('icon', 'add user')

@section('content')

  {!! Form::open(['route' => 'admin.users.store', 'class' => 'ui form']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.users.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="add user icon"></i> Add User', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="required field">
      {!! Form::label('firstname', 'First Name') !!}
      {!! Form::text('firstname', null, ['placeholder' => 'First Name']) !!}
    </div>
    <div class="required field">
      {!! Form::label('lastname', 'Last Name') !!}
      {!! Form::text('lastname', null, ['placeholder' => 'Last Name']) !!}
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
  <div class="three fields">
    <div class="required field">
      {!! Form::label('phone', 'Phone') !!}
      {!! Form::tel('phone', null, ['placeholder' => 'Enter user\'s phone number']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="required field">
      {!! Form::label('role_id', 'Role') !!}
      {!! Form::select('role_id', $roles, 7, ['class' => 'ui dropdown']) !!}
    </div>
    <div class="required field">
      {!! Form::label('organization_id', 'Organization') !!}
      {!! Form::select('organization_id', $organizations, 1, ['class' => 'ui dropdown']) !!}
    </div>
    <div class="required field">
      {!! Form::label('email', 'Email') !!}
      {!! Form::text('email', null, ['placeholder' => 'Email']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="required field">
      {!! Form::label('password', 'Password') !!}
      {!! Form::password('password', null, ['placeholder' => 'Password']) !!}
    </div>
    <div class="required field">
      {!! Form::label('password_confirmation', 'Confirm Password') !!}
      {!! Form::password('password_confirmation', null, ['placeholder' => 'Confirm Password']) !!}
    </div>
  </div>
  <div class="required field">
    <div class="ui buttons">
      <a href="{{ route('admin.users.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="add user icon"></i> Add User', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
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
