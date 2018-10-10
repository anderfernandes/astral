@extends('layout.admin')

@section('title', "Edit Organization Type {$organizationType->name}")

@section('subtitle', $organizationType->name)

@section('icon', 'university')

@section('content')
  
  <div class="ui container">

    @include('admin.organization-types._form')

  </div>

@endsection
