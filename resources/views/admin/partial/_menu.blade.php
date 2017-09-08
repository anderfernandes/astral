<div class="ui borderless inverted fixed top menu">
  <a class="header toc item"><i class="sidebar large icon"></i></a>
  <div class="header item"><i class="sun large icon"></i>Astral</div>
  <div class="header active item">
    <i class="@yield('icon') icon"></i>
    @yield('title') | @yield('subtitle')
  </div>
  <div class="right menu">
    <div class="item">
      <a href="{{ route('cashier.index') }}" target="_blank" class="ui inverted button"> <i class="inbox icon"></i> Cashier</a>
    </div>
    <div class="ui dropdown item">
      <i class="user circle outline large inverted icon"></i>
      {!! Auth::user()->firstname !!} <i class="dropdown icon"></i>
      <div class="menu">
        <a href="{{ route('account') }}" class="item"><i class="user icon"></i> My Account</a>
        <!--<a class="item"><i class="sign out icon"></i> Logout</a>-->
      </div>
    </div>
  </div>
</div>
