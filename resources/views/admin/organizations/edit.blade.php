@extends('layout.admin')

@section('title', 'Edit Organization')

@section('subtitle', $organization->name)

@section('icon', 'university')

@section('content')

  {!! Form::model($organization, ['route' => ['admin.organizations.update', $organization], 'class' => 'ui form', 'method' => 'PUT']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="javascript:window.history.back()" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('name', 'Organization Name') !!}
      {!! Form::text('name', null, ['placeholder' => 'Enter full name of the organization']) !!}
    </div>
    <div class="field">
      {!! Form::label('type_id', 'Organization Type') !!}
      {!! Form::select('type_id', $organizationTypes, null, ['placeholder' => 'Select an Organization Type', 'class' => 'ui search dropdown']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('address', 'Address') !!}
      {!! Form::text('address', null, ['placeholder' => 'Enter full organization address']) !!}
    </div>
    <div class="field">
      {!! Form::label('city', 'City') !!}
      {!! Form::text('city', null, ['placeholder' => 'Enter organization\'s city']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="field">
      {!! Form::label('country', 'Country') !!}
      @include('partial._countries')
    </div>
    <div class="field">
      {!! Form::label('state', 'State') !!}
      @include('partial._states')
    </div>
    <div class="field">
      {!! Form::label('zip', 'ZIP') !!}
      {!! Form::text('zip', null, ['placeholder' => 'ZIP']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('phone', 'Phone') !!}
      {!! Form::tel('phone', null, ['placeholder' => 'Enter organization\'s phone number']) !!}
    </div>
    <div class="field">
      {!! Form::label('fax', 'Fax') !!}
      {!! Form::tel('fax', null, ['placeholder' => 'Enter organization\'s fax number']) !!}
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('email', 'Email') !!}
      {!! Form::text('email', null, ['placeholder' => 'Enter organization\'s email']) !!}
    </div>
    <div class="field">
      {!! Form::label('website', 'Website') !!}
      <div class="ui labeled input">
        <div class="ui label">http://</div>
        {!! Form::text('website', null, ['placeholder' => 'Enter organization\'s website']) !!}
      </div>
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
      <a href="{{ route('admin.organizations.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
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
