@extends('layout.admin')

@section('title', 'Add User')

@section('subtitle', 'New User')

@section('icon', 'add user')

@section('content')

  @include('admin.partial.users._form', ['type' => 'create'])

@endsection
