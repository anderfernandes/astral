@extends('layout.admin')

@section('title', 'Add Show')

@section('subtitle', 'New Show')

@section('icon', 'plus')

@section('content')

  @include('admin.partial.shows._form', ['type' => 'create'])

@endsection
