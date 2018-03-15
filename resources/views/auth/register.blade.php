@extends('layout.auth')

@section('content')

<div class="ui middle aligned two column centered  doubling stackable grid">
  <div class="twelve wide computer only column" id="left"></div>
  <div class="four wide computer sixteen wide mobile column">
    <div class="ui basic segment hidden" id="form">
      <div class="ui center aligned icon header">
        <img class="ui centered massive image" src="/astral-logo-dark.png" />
        <div class="content">Astral</div>
        <div class="sub header">{{ App\Setting::find(1)->organization }}</div>
      </div>
      <form class="ui form <?php if (count($errors) > 0) echo 'error'?>" role="form" method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="div two fields">
          <div class="field{{ $errors->has('firstname') ? ' error' : '' }}">

              <label for="name">First Name</label>
              <div class="ui left icon input">
                <input id="firstname" placeholder="First Name" type="text" name="firstname" value="{{ old('firstname') }}" required autofocus>
                <i class="user icon"></i>
              </div>

              @if ($errors->has('firstname'))
                  <div class="ui error message">
                      <strong><i class="warning circle icon"></i> {{ $errors->first('firstname') }}</strong>
                  </div>
              @endif

          </div>
          <div class="field{{ $errors->has('lastname') ? ' error' : '' }}">

              <label for="name">Last Name</label>
              <div class="ui left icon input">
                <input id="lastname" placeholder="Last Name" type="text" name="lastname" value="{{ old('lastname') }}" required autofocus>
                <i class="user icon"></i>
              </div>

              @if ($errors->has('lastname'))
                  <div class="ui error message">
                      <strong><i class="warning circle icon"></i> {{ $errors->first('lastname') }}</strong>
                  </div>
              @endif

          </div>
        </div>
        <div class="field{{ $errors->has('email') ? ' error' : '' }}">
            <label for="email" class="col-md-4 control-label">Email</label>
              <div class="ui left icon input">
                <input id="email" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required>
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
                <input id="password" placeholder="Password" type="password" name="password" required>
                <i class="key icon"></i>
              </div>

              @if ($errors->has('password'))
                <div class="ui error message">
                    <strong><i class="warning circle icon"></i> {{ $errors->first('password') }}</strong>
                </div>
              @endif

        </div>

        <div class="field{{ $errors->has('password') ? ' error' : '' }}">
            <label for="password-confirm">Confirm Password</label>

            <div class="ui left icon input">
                <input id="password-confirm" placeholder="Confirm Password" type="password" name="password_confirmation" required>
                <i class="key icon"></i>
            </div>
        </div>

        <div class="field">
          <div class="ui two buttons">
            <button type="submit" class="ui primary button">
                <i class="sign in icon"></i> Register
            </button>
            <div class="ui secondary button" onclick="$('form').form('clear')"><i class="eraser icon"></i> Clear</div>
          </div>
        </div>
      </form>
      <h5 class="ui center aligned header">
        <div class="sub header">
          Created by <a href="http://anderfernandes.com" target="_blank">@anderfernandes</a>. <a href="http://astral.anderfernandes.com" target="_blank">Astral</a> {{ config('app.version') }}.
        </div>
      </h5>
    </div>
  </div>
</div>
@endsection
