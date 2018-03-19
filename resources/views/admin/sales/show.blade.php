@extends('layout.admin')

@section('title', 'Sale Information')

@section('subtitle', 'Sale #' . $sale->id)

@section('icon', 'dollar')

@section('content')

  @include('partial.sales._show')

@endsection
