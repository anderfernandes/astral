@extends('layout.astral')

@section('title', 'Welcome!')

@section('content')

<div class="ui basic segment">
  <h2>{{ $user->firstname }} {{ $user->lastname}}</h2>
  <h3>{{ $user->role }}</h3>
</div>

@endsection
