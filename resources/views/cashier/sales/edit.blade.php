@extends('layout.cashier')

@section('title', 'Sales')

@section ('name', 'Sale #' . $sale->id)

@section ('icon', 'dollar')

@section('content')

  {!! Form::model($sale, ['route' => ['cashier.sales.update', $sale], 'class' => 'ui form', 'method' => 'PUT']) !!}
    @include('partial.form._sale')
  {!! Form::close() !!}

  @include('cashier.partial._spinner')

@endsection
