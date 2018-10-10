@extends('layout.admin')

@section('title', 'Products')

@section('subtitle', "Edit Grade {$grade->name}")

@section('icon', 'book')

@section('content')

@include('admin.grades._form')

@endsection
