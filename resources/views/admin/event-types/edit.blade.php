@extends('layout.admin')

@section('title', 'Edit Event Type')

@section('subtitle', 'Edit Event Type ' . $eventType->name)

@section('icon', 'calendar')

@section('content')

  @include('admin.event-types.partial._form', ['eventType' => $eventType])

@endsection
