@extends('layout.admin')

@section('title', 'Edit Member Type')

@section('subtitle', $memberType->name)

@section('icon', 'address card')

@section('content')

  <div class="ui container">

    @include('admin.member-types._form')

  </div>

@endsection
