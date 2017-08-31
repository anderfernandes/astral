<div class="ui borderless fixed top menu">
  <a class="header toc item"><i class="sidebar large icon"></i></a>
  <div class="header item"><i class="sun large icon"></i></div>
  <div class="active header item">
    <strong><i class="@yield('icon') icon"></i> @yield('name')</strong>
  </div>
  <div class="right menu">
    <div class="active header item">
      <strong><i class="calendar icon"></i>{{ Date::now()->format('l, F j, Y')}}</strong>
    </div>
    <div class="ui dropdown item">
      <i class="user circle outline large icon"></i>
      {!! Auth::user()->firstname !!} <i class="dropdown icon"></i>
      <div class="menu">
        <a href="{{ route('account') }}" class="item"><i class="user icon"></i> My Account</a>
        <a href="/logout" class="item"><i class="sign out icon"></i> Logout</a>
      </div>
    </div>
  </div>
</div>
