@extends('layout.admin')

@section('title', 'Edit Show')

@section('subtitle', $show->name)

@section('icon', 'edit')

@section('content')

  @include('admin.partial.shows._form', ['type' => 'edit'])

@endsection
