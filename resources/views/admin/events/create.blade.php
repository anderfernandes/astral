@extends('layout.admin')

@section('title', 'Create Event')

@section('subtitle', 'New Event')

@section('icon', 'plus')

@section('content')

  @include('admin.partial.events._form', ['type' => 'create'])

@endsection
