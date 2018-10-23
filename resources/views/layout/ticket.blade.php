<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Astral') }} - {{ App\Setting::find(1)->organization }} | @yield('title')</title>

    <link rel="stylesheet" href="/semantic/button.min.css">
    <link rel="stylesheet" href="/semantic/icon.min.css">

  </head>

  <style>

    html {font-family: monospace, sans-serif, serif;}

  </style>

  <body>

    @yield('content')

  </body>
</html>
