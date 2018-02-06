@extends('layout.cashier')

@section('title', 'Sales')

@section ('name', 'Sale #' . $sale->id)

@section ('icon', 'dollar')

@section('content')


  @include('partial.form._sale')

  @include('cashier.partial._spinner')

@endsection
