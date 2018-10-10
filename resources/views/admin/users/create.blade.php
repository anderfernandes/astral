@extends('layout.admin')

@section('title', 'Add User')

@section('subtitle', 'New User')

@section('icon', 'add user')

@section('content')

  <div class="ui container">

    @include('admin.partial.users._form', ['type' => 'create'])

  </div>

@endsection
