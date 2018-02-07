@extends('layout.admin')

@section('title', 'Edit Event')

@section('subtitle', $event->show->name)

@section('icon', 'edit')

@section('content')

  @include('admin.partial.events._form', ['type' => 'edit'])

@endsection
