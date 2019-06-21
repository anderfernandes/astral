@extends('layout.admin')

@section('title', 'Shifts')

@section ('subtitle', 'Employee Scheduling')

@section ('icon', 'clock outline')

@section('content')

  <a class="ui black labeled icon button" href="{{ route('admin.shifts.create') }}">
    <i class="calendar plus icon"></i>
    Create New Shift
  </a>

@endsection
