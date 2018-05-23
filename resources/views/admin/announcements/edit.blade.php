@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->fullname)

@section('icon', 'dashboard')

@section('content')

  @include('admin.announcements._form')

@endsection
