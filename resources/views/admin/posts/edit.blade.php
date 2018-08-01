@extends('layout.admin')

@section('title', 'Edit Post')

@section('subtitle', $post->title)

@section('icon', 'edit')

@section('content')

  <div class="ui container">

    @include('admin.partial.posts._form', ['type' => 'edit'])

  </div>

@endsection
