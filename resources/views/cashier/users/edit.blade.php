@extends('layout.cashier')

@section('title', 'Members')

@section ('name', 'Members')

@section ('icon', 'address card')

@section('content')

  <div class="ui container">

    @include('cashier.users._form', ['type' => 'edit', 'user' => $user])

  </div>

@endsection
