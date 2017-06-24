@extends('layout.admin')

@section('content')

<h1>This is the settings page!</h1>

{!! Form::model($setting, ['route' => ['admin.settings.update', $setting], 'class' => 'ui form', 'method' => 'PUT']) !!}
{!! Form::label('organization', 'Organization Name') !!}
{!! Form::text('organization') !!}
{!! Form::label('seats', 'Number of Seats') !!}
{!! Form::number('seats') !!}
{!! Form::submit('Save')!!}
{!! Form::close() !!}

@endsection
