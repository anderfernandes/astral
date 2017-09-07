@extends('layout.astral')

@section('content')

<div class="ui centered grid">
  <div class="sixteen wide mobile four wide computer column">
    <h2>Reset Password</h2>
    <form class="ui form" role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="field{{ $errors->has('email') ? ' error' : '' }}">
            <label for="email">Email</label>

            <div class="ui left icon input">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                    <div class="ui warning message">
                        <i class="warning icon"></i> {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="field">
          <button type="submit" class="ui positive fluid button">
              <i class="check icon"></i> Send Password Reset Link
          </button>
        </div>
    </form>
  </div>
</div>

@endsection
