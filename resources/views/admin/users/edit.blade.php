@extends('layout.admin')

@section('title', 'Edit User')

@section('subtitle', $user->fullname)

@section('icon', 'user')

@section('content')

@include('admin.partial.users._form', ['type' => 'edit', 'user' => $user])

@endsection
