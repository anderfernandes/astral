@extends('layout.admin')

@section('title', 'Edit Position')

@section('subtitle', $position->name)

@section('icon', 'address card')

@section('content')

  <div class="ui container">
    
    {!! Form::model($position, ['route' => ['admin.positions.update', $position->id], 'class' => 'ui form', 'id' => 'positions', 'method' => 'put']) !!}
    <div class="three fields">
      <div class="required field">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['placeholder' => 'Position Name']) !!}
      </div>
      <div class="required field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this organization position']) !!}
      </div>
      <div class="field">
        <label for="">&nbsp;</label>
        {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui green right labeled icon button']) !!}
      </div>
    </div>
    {!! Form::close() !!}

  </div>

@endsection