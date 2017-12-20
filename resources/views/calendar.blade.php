@extends('layout.report')

@section('title', 'Calendar')

@section('content')

  <style>
      body {
        background: linear-gradient(rgba(255,255,255,0.6), rgba(255,255,255,9)), url('/cover.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
      }
    </style>

  <div id="calendar"></div>

  <script src="/js/app.js"></script>

@endsection
