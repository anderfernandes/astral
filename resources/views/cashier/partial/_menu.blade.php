<div class="ui borderless fixed top menu">
  <a class="header toc item"><i class="sidebar large icon"></i></a>
  <div class="header item"><img src="/astral-logo-dark.png" style="padding-right:4px"></div>
  <div class="active header item hide-on-mobile">
    <strong>
      <i class="@yield('icon') icon"></i> @yield('name') |
      {{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}
    </strong>
  </div>
  <div class="right menu">
    <div class="active header item hide-on-mobile">
      <strong><i class="calendar icon"></i>{{ Date::now()->format('l, F j, Y')}}</strong>
    </div>
    <div class="ui dropdown item">
      <i class="user circle large icon"></i>
      {!! Auth::user()->firstname !!} <i class="dropdown icon"></i>
      <div class="menu">
        <a href="{{ route('account') }}" target="_blank" class="item"><i class="user icon"></i> My Account</a>
        <a href="{{ url('/logout') }}" class="item"><i class="sign out icon"></i> Logout</a>
      </div>
    </div>
  </div>
</div>
