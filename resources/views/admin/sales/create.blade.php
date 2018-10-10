@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', "New {$eventType->name} Sale")

@section ('icon', 'dollar')

@section('content')

  @include('partial.sales._form')

@endsection
