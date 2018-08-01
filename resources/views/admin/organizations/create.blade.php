@extends('layout.admin')

@section('title', 'Organizations')

@section('subtitle', 'New Organization')

@section('icon', 'university')

@section('content')

  <div class="ui container">

    @include('admin.partial.organizations._create')

  </div>

@endsection
