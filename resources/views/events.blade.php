@extends('layout.report')

@section('title', 'Upcoming Events')

@section('content')

  <style>
      body {
        background: linear-gradient(rgba(255,255,255,0.6), rgba(255,255,255,0.9)), url('/cover.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
      }
    </style>

  <div class="ui top right attached big basic blue image label">
    <img src="{{ App\Setting::find(1)->logo }}" alt="{{ App\Setting::find(1)->organization }}">
    Upcoming Events
  </div>

  <div id="events"></div>

  <script src="/js/app.js"></script>

@endsection
