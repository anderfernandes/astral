<div class="ui sidebar blue inverted vertical inverted menu">
  <div class="item" style="text-align:center">
    @if (Auth::check())
      <img class="ui tiny avatar image" src="https://semantic-ui.com/images/wireframe/square-image.png">
      <br /><br />
      {{ $user->firstname }} {{ $user->lastname }}
      <br /><br />
      <div class="ui tiny buttons">
        <a href="{{ route('account') }}" class="ui red button"><i class="user icon"> </i>Account</a>
        {!! Form::open(['route' => ['logout'], 'method' => 'POST']) !!}
          {{ csrf_field() }}
          {!! Form::button('<i class="sign out icon"></i> Logout',
            ['type' => 'submit', 'class' => 'ui button'])
          !!}
        {!! Form::close() !!}

      </div>



    @else
      <div class="ui two buttons">
        <a href="" class="ui tiny red button"><i class="sign in icon"></i> Login</a>
        <a href="" class="ui tiny button"><i class="add user icon"> </i>Register</a>
      </div>

    @endif

  </div>
  <!-- Pending loop to automatically pull all menu items -->
  <a class="item">
    <i class="large calendar icon"></i> Calendar
  </a>
</div>
