<div class="ui borderless secondary huge fixed top menu">
  <a class="header toc item"><i class="sidebar large icon"></i></a>
  <div class="header item"><i class="sun large icon"></i></div>
  <div class="active header item">
    <strong><i class="@yield('icon') icon"></i> @yield('name')</strong>
  </div>
  <div class="right menu">
    <div class="active header item">
      <strong><i class="calendar icon"></i>{{ Date::now()->format('l, F j, Y')}}</strong>
    </div>
    <a class="item">
      <img class="ui avatar image" src="https://semantic-ui.com/images/wireframe/square-image.png">
      {!! Auth::user()->firstname !!} &nbsp;
    </a>
  </div>
</div>
