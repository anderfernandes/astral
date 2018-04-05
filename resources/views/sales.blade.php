{{-- THE ROUTE /sales MUST BE PROTECTED IN A FUTURE RELEASE!!! --}}

@extends('layout.report')

@section('title', 'Calendar')

@section('content')

  <style>
      body {
        background: linear-gradient(rgba(255,255,255,0.6), rgba(255,255,255,0.6)), url('/cover.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
      }
    </style>

  <div class="ui top right attached big basic blue image label">
    <img src="{{ App\Setting::find(1)->logo }}" alt="{{ App\Setting::find(1)->organization }}">
    Upcoming Field Trips
  </div>

  <div id="sales"></div>

  <script src="/js/app.js"></script>

@endsection
