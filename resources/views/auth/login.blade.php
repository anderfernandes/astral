@extends('layout.astral')

@section('content')

<div class="ui centered grid">
  <div class="sixteen wide mobile eight wide computer column">
    <h2 class="ui center aligned icon header">
    <i class="sun icon"></i>
    <div class="content">
      Astral
      <div class="sub header">
      {{ App\Setting::find(1)->organization }}
      </div>
    </div>
    </h2>
  </div>
</div>

<div class="ui centered grid">
  <div class="sixteen wide mobile four wide computer column">
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

          <button type="submit" class="ui primary button">
              <i class="sign in icon"></i> Login
          </button>

          <a href="{{ route('password.request') }}">
              Forgot Your Password?
          </a>

        </div>
    </form>
  </div>
</div>
@endsection
