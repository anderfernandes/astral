<div class="ui borderless inverted fixed top menu">
  <a class="header toc item"><i class="sidebar large icon"></i></a>
  <div class="header item"><img src="/astral-logo-light.png" style="padding-right:4px"> Astral</div>
  <div class="header active item hide-on-mobile">
    <i class="@yield('icon') icon"></i>
    @yield('title') | @yield('subtitle')
  </div>
  <div class="right menu">
    <div class="item hide-on-mobile">
      <a href="{{ route('cashier.index') }}" target="_blank" class="ui inverted button"> <i class="inbox icon"></i> Cashier</a>
    </div>
    <div class="ui dropdown item">
      <i class="user circle large inverted icon"></i>
      {!! Auth::user()->firstname !!} <i class="dropdown icon"></i>
      <div class="menu">
        <a href="{{ route('account') }}" target="_blank" class="item"><i class="user icon"></i> My Account</a>
        <a href="{{ url('/logout') }}" class="item"><i class="sign out icon"></i> Logout</a>
      </div>
    </div>
  </div>
</div>
