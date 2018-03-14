@extends('layout.admin')

@section('title', 'Create Post')

@section('subtitle', 'New Post')

@section('icon', 'plus')

@section('content')

  @include('admin.partial.posts._form', ['type' => 'create'])

@endsection
