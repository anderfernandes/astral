@extends('layout.cashier')

@section('title', 'Sales')

@section ('name', 'New Sale | ' . $eventType->name)

@section ('icon', 'dollar')

@section('content')

  {!! Form::open(['route' => 'cashier.sales.store', 'class' => 'ui form']) !!}
    @include('partial.form._sale')
  {!! Form::close() !!}

  @include('cashier.partial._spinner')

@endsection
