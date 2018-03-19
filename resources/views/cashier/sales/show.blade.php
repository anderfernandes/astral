@extends('layout.cashier')

@section('title', 'Sales')

@section ('name', 'Sales #' . $sale->id)

@section ('icon', 'dollar')

@section('content')

  @include('partial.sales._show')  

@endsection
