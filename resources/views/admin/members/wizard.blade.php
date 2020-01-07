@extends('layout.admin')

@section('title', 'Members')

@section('subtitle', 'New Member Wizard')

@section('icon', 'address card')

@section('content')

  <div id="new-member-wizard"></div>

  <script>
    localStorage.setItem("u", {{ auth()->user()->id }})
  </script>

  <script src="{{ mix('js/app.js') }}"></script>

@endsection