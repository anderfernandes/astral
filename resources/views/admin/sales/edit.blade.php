@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'Sale #'.$sale->id)

@section ('icon', 'dollar')

@section('content')

  {!! Form::model($sale, ['route' => ['admin.sales.update', $sale], 'class' => 'ui form', 'method' => 'PUT']) !!}
    @include('partial.form._sale')
  {!! Form::close() !!}

@endsection
