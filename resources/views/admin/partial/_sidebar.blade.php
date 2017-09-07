<div class="ui sidebar vertical inverted menu">
  <div class="item" style="text-align:center">
    <h1 class="ui inverted icon header"><i class="user circle outline large icon"></i></h1>
    <br />
    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
    <br /><br />
    <div class="ui tiny buttons">
      <a href="{{ route('account') }}" class="ui blue button"><i class="user icon"> </i>Account</a>
      {!! Form::open(['route' => ['logout'], 'method' => 'POST']) !!}
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
    <i class="large calendar icon"></i> Events
  </a>
  <a class="item" href="{{ route('admin.sales.index') }}">
    <i class="large dollar icon"></i> Sales
  </a>
  <a href="{{ route('admin.users.index') }}" class="item">
    <i class="large users icon"></i> Users
  </a>
  <a href="{{ route('admin.organizations.index') }}" class="item">
    <i class="large university icon"></i> Organizations
  </a>
  <a href="{{ route('cashier.index') }}" class="item" target="_blank">
    <i class="large inbox icon"></i> Cashier
  </a>
  <a href="{{ route('admin.settings.index') }}" class="item">
    <i class="large setting icon"></i> Settings
  </a>
  <div class="item">
    <img class="ui centered tiny image" src="{{ '/'.App\Setting::find(1)->logo }}" alt="">
  </div>
</div>
