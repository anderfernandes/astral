@extends('layout.admin')

@section('title', 'Organizations')

@section('subtitle', 'New Organization')

@section('icon', 'university')

@section('content')

  @include('admin.partial.organizations._create')

@endsection
