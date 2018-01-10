@extends('layout.admin')

@section('title', 'Edit Role')

@section('subtitle', $role->name)

@section('icon', 'users')

@section('content')

  {!! Form::model($role, ['route' => ['admin.roles.update', $role], 'class' => 'ui form', 'method' => 'PUT']) !!}
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.organizations.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  <div class="three fields">
    <div class="field">
      {!! Form::label('name', 'Role Name') !!}
      {!! Form::text('name', null, ['placeholder' => 'Enter role name']) !!}
    </div>
    <div class="field">
      {!! Form::label('staff', 'Staff?') !!}
      {!! Form::select('staff', [true => 'Yes', false => 'No'], $role->staff, ['class' => 'ui dropdown']) !!}
    </div>
    <div class="field">
      {!! Form::label('description', 'Role Description') !!}
      {!! Form::text('description', null, ['placeholder' => 'Describe the role']) !!}
    </div>
  </div>
  <div class="field">
    <div class="ui buttons">
      <a href="{{ route('admin.organizations.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}

@endsection
