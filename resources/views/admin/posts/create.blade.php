@extends('layout.admin')

@section('title', 'Create Post')

@section('subtitle', 'New Post')

@section('icon', 'plus')

@section('content')

  <div class="ui container">
    @include('admin.partial.posts._form', ['type' => 'create'])
  </div>

@endsection
