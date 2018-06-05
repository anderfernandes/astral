@extends('layout.admin')

@section('title', 'Add Show')

@section('subtitle', 'New Show')

@section('icon', 'film')

@section('type', 'add')

@section('content')

  <div class="ui container">

    @include('admin.partial.shows._form', ['type' => 'create'])

  </div>
  
@endsection
