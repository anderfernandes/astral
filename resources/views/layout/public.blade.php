<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Astral') }} - {{ App\Setting::find(1)->organization }}</title>

  <!-- Meta -->
  <meta name="description" content="@yield('meta_description')">

  <meta name="keywords" content="mayborn science theater, ctc planetarium, field trip,
  field trips, reservation, @yield('meta_keywords')" />

  @yield('meta')

  <!-- Google Analytics -->
  <!--<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-92903603-1', 'auto');
    ga('send', 'pageview');

  </script>-->

  <!-- Libraries -->
  <link rel="stylesheet" href="/css/vendor.css">
  <script src="/js/vendor.js"></script>

  <link rel="stylesheet" href="/semantic/semantic.min.css">
  <script src="/semantic/semantic.min.js"></script>

  @if (\App\Setting::find(1)->gateway == "stripe")
    <script src="https://js.stripe.com/v3"></script>
  @endif

  @if (\App\Setting::find(1)->gateway == "braintree")
    <script src="https://js.braintreegateway.com/js/braintree-2.32.1.min.js"></script>
  @endif

</head>
<script>
  $(document)
    .ready(function() {
      // close message alerts
      $('.message .close').on('click', function() {
        $(this).closest('.message').transition('fade');
      });
    });
</script>

<style>
    #left {
        padding-top: 2.5rem;
        background: linear-gradient(rgba(0,0,0,1), rgba(255,255,255,0.5)), url('{{ (App\Setting::find(1)->cover == '/cover.jpg') ? App\Setting::find(1)->cover : Storage::url(App\Setting::find(1)->cover) }}');
        background-size: cover;
        min-height: 100vh
    }
</style>

<body>
  
  @yield('content')

  <script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
