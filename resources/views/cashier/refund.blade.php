@extends('layout.cashier')

@section('title', 'Cashier')

@section('icon', 'inbox')

@section('name', 'Cashier | Refund | '.Auth::user()->firstname.' '.Auth::user()->lastname)

@section('content')

<h1>Refund</h1>

@endsection
