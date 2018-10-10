@extends('layout.admin')

@section('title', 'Products')

@section('subtitle', "Edit Product {$product->name}")

@section('icon', 'box')

@section('content')

  <div class="ui container">
    @include('admin.products._form')
  </div>

@endsection
