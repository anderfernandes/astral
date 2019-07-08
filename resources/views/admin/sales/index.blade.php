@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'Manage Sales')

@section ('icon', 'dollar')

@section('content')

  <script>
    
    localStorage.setItem("u", {{ auth()->user()->id }})
    
  </script>
  
  <div id="sales"></div>

@endsection
