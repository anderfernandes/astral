@extends('layout.admin')

@section('title', 'Shifts')

@section ('subtitle', 'Create New Shift')

@section ('icon', 'clock outline')

@section('content')

  <div class="ui container">
  
    @include('admin.shifts._form')

  </div>

@endsection
