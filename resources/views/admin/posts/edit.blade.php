@extends('layout.admin')

@section('title', 'Edit Post')

@section('subtitle', $post->title)

@section('icon', 'edit')

@section('content')

  @include('admin.partial.posts._form', ['type' => 'edit'])

@endsection
