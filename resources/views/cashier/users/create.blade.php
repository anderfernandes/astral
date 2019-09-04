@extends('layout.cashier')

@section('title', 'Add User')

@section ('name', 'Add User')

@section ('icon', 'user plus')

@section('content')

  <div class="ui container">

    @include('partial.users._form', ['type' => 'create'])

  </div>

@endsection
