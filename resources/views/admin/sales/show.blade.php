@extends('layout.admin')

@section('title', 'Sale Information')

@section('subtitle', 'Sale #' . $sale->id)

@section('icon', 'dollar')

@section('content')

  <div class="ui container">

    @include('partial.sales._show')

  </div>

@endsection
