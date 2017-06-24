@extends('layout.astral')

@section('content')

<div class="ui centered grid">
  <div class="sixteen wide mobile four wide computer column">
    <form class="ui form" role="form" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field{{ $errors->has('email') ? ' error' : '' }}">
            <label for="email">Email</label>

            <div class="ui left icon input">
                <input id="email" type="email" name="email" value="{{ $email or old('email') }}" required autofocus>
                <i class="mail icon"></i>
            </div>
            @if ($errors->has('email'))
                <div class="ui error message">
                    <strong>{{ $errors->first('email') }}</strong>
                </div>
            @endif
        </div>

        <div class="field{{ $errors->has('password') ? ' error' : '' }}">
            <label for="password">Password</label>

            <div class="ui left icon input">
              <input id="password" type="password" name="password" required>
              <i class="key icon"></i>
            </div>
            @if ($errors->has('password'))
              <div class="ui error message">
                <i class="warning circle icon"></i> {{ $errors->first('password') }}
              </div>
            @endif

        </div>

        <div class="field{{ $errors->has('password_confirmation') ? ' error' : '' }}">
            <label for="password-confirm">Confirm Password</label>
            <div class="ui left icon input">
              <input id="password-confirm" type="password" name="password_confirmation" required>
              <i class="key icon"></i>
            </div>
            @if ($errors->has('password_confirmation'))
                <div class="ui warning message">
                  <i class="warning circle icon"></i> {{ $errors->first('password_confirmation') }}
                </div>
            @endif
        </div>

        <div class="field">

          <button type="submit" class="ui primary button">
              <i class="check icon"></i> Reset Password
          </button>

        </div>
    </form>
  </div>
</div>

<div class="ui centered grid">
  <div class="sixteen wide mobile eight wide computer column">
    <h2>Reset Password</h2>
    @if (session('status'))
        <div class="ui success message">
            {{ session('status') }}
        </div>
    @endif
  </div>
</div>

@endsection
