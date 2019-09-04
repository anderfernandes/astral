@extends('layout.cashier')

@section('title', 'Members')

@section ('name', 'Members')

@section ('icon', 'address card')

@section('content')

  @include('partial.members._index')

  @include('cashier.partial._spinner')

@endsection
