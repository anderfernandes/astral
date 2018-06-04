@extends('layout.admin')

@section('title', 'Edit Member Type')

@section('subtitle', $memberType->name)

@section('icon', 'address card')

@section('content')

  @include('admin.member-types._form')

@endsection
