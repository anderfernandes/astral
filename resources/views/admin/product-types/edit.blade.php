@extends('layout.admin')

@section('title', 'Product Types')

@section('subtitle', "Edit Product Type {$productType->name}")

@section('icon', 'setting')

@section('content')

  <div class="ui dividing header">
    <i class="icons">
      <i class="box icon"></i>
      <i class="add corner icon"></i>
    </i>
    <div class="content">
      Edit Product Type
      <div class="sub header">{{ $productType->name }}</div>
    </div>
  </div>

@include('admin.product-types._form')

@endsection
