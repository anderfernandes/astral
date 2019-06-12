@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'Manage Sales')

@section ('icon', 'dollar')

@section('content')

  <script>
    @if (auth()->check())
      if (!localStorage.getItem("u"))
        localStorage.setItem("u", {{ auth()->user()->id }})
    @else
      localStorage.removeItem("u")
    @endif
  </script>
  
  <div id="sales"></div>

@endsection
