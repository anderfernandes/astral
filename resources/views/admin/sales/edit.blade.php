@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'Sale #'.$sale->id)

@section ('icon', 'dollar')

@section('content')

  @include('partial.form._sale')

@endsection
