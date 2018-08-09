@extends('layout.auth')

@section('content')

  <div class="ui middle aligned two column centered  doubling stackable grid">
    <div class="twelve wide computer only column" id="left"></div>
    <div class="four wide computer sixteen wide mobile column">
      <div class="ui basic segment hidden" id="form">
        <div class="ui center aligned icon header">
          <img class="ui centered massive image" id="logo" src="/astral-logo-dark.png" />
          <div class="content">Astral</div>
          <div class="sub header">{{ App\Setting::find(1)->organization }}</div>
        </div>

        {{-- Form --}}
        <form class="ui form <?php if (count($errors) > 0) echo 'error'?>" role="form" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="field{{ $errors->has('email') ? ' error' : '' }}">
                <label for="email">Email</label>

                <div class="ui left icon input">
                    <input id="email" type="email" name="email" value="{{ $email or old('email') }}" required autofocus placeholder="my@email.com">
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
                  <input id="password" type="password" name="password" required placeholder="Password">
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
                  <input id="password-confirm" type="password" name="password_confirmation" required placeholder="Confirm Password">
                  <i class="key icon"></i>
                </div>
                @if ($errors->has('password_confirmation'))
                    <div class="ui warning message">
                      <i class="warning circle icon"></i> {{ $errors->first('password_confirmation') }}
                    </div>
                @endif
            </div>

            <div class="field">

              <button type="submit" class="ui black fluid button">
                  <i class="key icon"></i> Reset Password
              </button>

            </div>
        </form>

        <h5 class="ui center aligned header">
          <div class="sub header">
            &copy; 2017-2018 <a href="http://anderfernandes.com" target="_blank">@anderfernandes</a> <br><br>
            <a href="http://astral.anderfernandes.com" target="blank" class="ui black tiny image label">
              <img src="/astral-logo-light.png" alt="Astral">
              {{ config('app.version') }}
            </a>
          </div>
        </h5>
      </div>
    </div>
  </div>

<div class="ui centered grid">
  <div class="sixteen wide mobile four wide computer column">

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

<script>
  $('#form')
    .transition('toggle')
    .transition({ animation: 'fade', duration: '2s' })

  $('#left')
    .transition('toggle')
    .transition({ animation: 'fade', duration: '20s' })
    .transition({ animation: 'fade', duration: '20s' })
    .transition({ animation: 'fade', duration: '20s' })

  $('#logo')
    .transition('set looping')
    .transition('pulse', '2s')

  $('form').form({
    on: 'blur',
    inline: true,
    fields: {
      email: ['empty', 'email'],
      password: ['empty'],
    }
  })

</script>

@endsection
