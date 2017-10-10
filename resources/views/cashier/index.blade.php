@extends('layout.cashier')

@section('title', 'Cashier')

@section('icon', 'inbox')

@section('name', 'Cashier | '.Auth::user()->firstname.' '.Auth::user()->lastname)

@section('content')

    <div id="cashier"></div>

@endsection
