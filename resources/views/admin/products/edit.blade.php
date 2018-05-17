@extends('layout.admin')

@section('title', 'Products')

@section('subtitle', "Edit Product {$product->name}")

@section('icon', 'box')

@section('content')

@include('admin.products._form')

@endsection
