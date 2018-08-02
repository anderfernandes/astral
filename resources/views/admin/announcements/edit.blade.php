@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->fullname)

@section('icon', 'dashboard')

@section('content')

  <div class="ui container">

    @include('admin.announcements._form')

  </div>

@endsection
