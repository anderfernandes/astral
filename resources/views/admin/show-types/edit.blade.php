@extends('layout.admin')

@section('title', 'Edit Show Type')

@section('subtitle', $showType->name)

@section('icon', 'film')

@section('content')

  <div class="ui container">

    @include('admin.show-types._form')

  </div>

@endsection
