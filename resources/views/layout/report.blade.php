<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Astral') }} - {{ App\Setting::find(1)->organization }} | @yield('title')</title>

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

</head>
<script>
  $(document)
    .ready(function() {
      // Create sidebar and attach to menu open
      $('.ui.sidebar')
      .sidebar('setting', 'transition', 'overlay')
      .sidebar('setting', 'dimPage', false)
      .sidebar('attach events', '.toc.item');

      // close message alerts
      $('.message .close').on('click', function() {
        $(this).closest('.message').transition('fade');
      });

      // Initialize Semantic UI components
      $('.ui.radio.checkbox').checkbox();
      $('.ui.dropdown').dropdown();
    });
</script>

<body>
  <!-- Load Facebook SDK for JavaScript -->
  <!--<div id="fb-root"></div>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>-->

    <div class="ui basic segment">

      @yield('content')

    </div>

  </div>

</body>
</html>
