<div class="ui sidebar vertical menu">
  <div class="item" style="text-align:center">
    <img class="ui tiny avatar image" src="https://semantic-ui.com/images/wireframe/square-image.png">
    <br /><br />
    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
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
  </div>
  <!-- Pending loop to automatically pull all menu items -->
  <a class="item" href="{{ route('admin.index') }}">
    <i class="large dashboard icon"></i> Dashboard
  </a>
  <a class="item" href="{{ route('admin.shows.index') }}">
    <i class="large film icon"></i> Shows
  </a>
  <a class="item" href="{{ route('admin.events.index') }}">
    <i class="large calendar icon"></i> Calendar
  </a>
  <a href="{{ route('admin.users.index') }}" class="item">
    <i class="large users icon"></i> Users
  </a>
  <a href="{{ route('admin.settings.index') }}" class="item">
    <i class="large setting icon"></i> Settings
  </a>
</div>
