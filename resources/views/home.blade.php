@extends('layout.astral')

@section('title', 'Welcome!')

@section('content')

<div class="ui basic segment">
  <h2>Hello, {{ $user->firstname }}! You are logged in!</h2>
</div>

@endsection
