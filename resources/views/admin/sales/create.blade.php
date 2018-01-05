@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'New Sale')

@section ('icon', 'dollar')

@section('content')

  {!! Form::open(['route' => 'admin.sales.store', 'class' => 'ui form']) !!}
    @include('partial.form._sale')
  {!! Form::close() !!}

@endsection
