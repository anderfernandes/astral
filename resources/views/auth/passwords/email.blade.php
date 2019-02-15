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

        <div class="ui floating message">
          <div class="content" style="text-align:center">
            <div class="header" style="text-align:center">Request Password Change</div>
            Enter your email below and we will send you a reset link.
          </div>
        </div>

        <form class="ui form <?php if (count($errors) > 0) echo 'error'?>" role="form" method="POST" action="{{ route('password.email') }}">
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

          <div class="field">

            <button type="submit" class="ui fluid secondary button">
              <i class="sign in icon"></i> Request Password Change
            </button>
          </div>

        </form>

        <h5 class="ui center aligned header">
          <div class="sub header">
            &copy; 2017-{{ today()->format('Y') }} <a href="http://anderfernandes.com" target="_blank">@anderfernandes</a> <br><br>
            <a href="http://astral.anderfernandes.com" target="blank" class="ui black tiny image label">
              <img src="/astral-logo-light.png" alt="Astral">
              {{ config('app.version') }}
            </a>
          </div>
        </h5>
      </div>
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
