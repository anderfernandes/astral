@extends('layout.admin')

@section('title', 'Product Types')

@section('subtitle', "Edit {$productType->name}")

@section('icon', 'setting')

@section('content')

  <div class="ui container">

    @include('admin.product-types._form')

  </div>

@endsection
