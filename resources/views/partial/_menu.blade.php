<div class="ui borderless blue inverted fixed top menu">
  <a class="header toc item"><i class="sidebar large icon"></i></a>
  <a class="header item"><i class="large sun icon"></i> Astral</a>
  <a class="item"><i class="calendar icon"></i>Calendar</a>
  <div class="right menu">
    <!--<div class="item"><a href="" class="ui primary button"><i class="sign out icon"></i> Logout</a></div>-->
    <div class="item">

    </div>
    <div class="item">

      @if (Auth::check())
        <img class="ui avatar image" src="https://semantic-ui.com/images/wireframe/square-image.png">
        {!! $user->firstname !!} &nbsp;

      @else
        <a href="{{ route('login') }}" class="ui red button">
          <i class="sign in icon"></i>Login
        </a> &nbsp;
        <a href="{{ route('register') }}" class="ui button">
          <i class="add user icon"></i>Register
        </a> &nbsp;
      @endif

    </div>
  </div>
</div>
