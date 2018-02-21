@extends('layout.auth')

@section('content')

<div class="ui centered grid">
  <div class="sixteen wide mobile four wide computer column">
    <div class="ui raised attached segment">
      <img class="ui centered tiny image" src={{ '/'.App\Setting::find(1)->logo }} />
      <form class="ui form <?php if (count($errors) > 0) echo 'error'?>" role="form" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="field{{ $errors->has('email') ? ' error' : '' }}">
            <label for="email">Email</label>
            <div class="ui left icon input">
              <input id="email" type="email" name="email" placeholder="my@email.com" value="{{ old('email') }}" required autofocus>
              <i class="mail icon"></i>
            </div>
            @if ($errors->has('email'))
                <div class="ui error message">
                    <strong><i class="warning circle icon"></i> {{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="field{{ $errors->has('password') ? ' error' : '' }}">
            <label for="password">Password</label>
            <div class="ui left icon input">
              <input id="password" type="password" name="password" placeholder="Password" required>
              <i class="key icon"></i>
            </div>
            @if ($errors->has('password'))
              <div class="ui error message">
                  <strong><i class="warning icon"></i> {{ $errors->first('password') }}</strong>
              </div>
            @endif
        </div>

        <div class="field">
          <div class="ui checkbox">
              <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
              <label>Remember me</label>
          </div>
        </div>

        <div class="field">

            <button type="submit" class="ui fluid secondary button">
              <i class="sign in icon"></i> Login
            </button>
            <div class="ui horizontal divider">OR</div>
            <a href="{{ route('register') }}" class="ui fluid primary button">
              Register
              <i class="right chevron icon"></i>
            </a>



          <!-- <a href="{ /* route('password.request') */ }">
              Forgot Your Password?
          </a>-->

        </div>
    </form>
    </div>
    <div class="ui raised bottom attached segment">
      <h5 class="ui center aligned header">
        <div class="sub header">
          Powered by <a href="http://astral.anderfernandes.com" target="_blank">Astral</a> &copy; 2016-2018 <a href="http://anderfernandes.com" target="_blank">@anderfernandes</a>.
        </div>
      </h5>
    </div>
  </div>
</div>
@endsection
