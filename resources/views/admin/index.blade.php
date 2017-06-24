@extends('layout.admin')

@section('title', 'Admin')

@section('content')

<div class="ui basic segment">
  <h1>Hello, {{ Auth::user()->firstname }}!</h1>
</div>

@endsection
