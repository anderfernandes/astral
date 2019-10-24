@extends('layout.cashier')

@section('title', 'Cashier')

@section('icon', 'inbox')

@section('name', 'Cashier')

@section('content')

  <div id="cashier"></div>

  <script>
    localStorage.setItem('u', {{ auth()->user()->id }})
  </script>

@endsection
