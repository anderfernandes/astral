@extends('layout.admin')

@section('title', 'Edit Event Type')

@section('subtitle', 'Edit Event Type ' . $eventType->name)

@section('icon', 'calendar')

@section('content')

  <div class="ui container">

    @include('admin.event-types._form', ['eventType' => $eventType])

  </div>

@endsection
