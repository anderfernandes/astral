@extends('layout.admin')

@section('title', 'Add Event')

@section('subtitle', 'New Event')

@section('icon', 'calendar check')

@section('content')

  @include('admin.partial.events._create')

@endsection
