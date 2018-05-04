@extends('layout.admin')

@section('title', 'Products')

@section('subtitle', "Edit Product {$product->name}")

@section('icon', 'box')

@section('content')

  <div class="ui dividing header">
    <i class="icons">
      <i class="box icon"></i>
      <i class="add corner icon"></i>
    </i>
    <div class="content">
      Edit Product
      <div class="sub header">{{ $product->name }}</div>
    </div>
  </div>

@include('admin.products._form')

@endsection
