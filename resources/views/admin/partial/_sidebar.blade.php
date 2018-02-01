<div class="ui sidebar vertical inverted menu">
  <div class="item" style="text-align:center">
    <h1 class="ui inverted icon header"><i class="user circle outline large icon"></i></h1>
    <br />
    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
    <br /><br />
    <div class="ui tiny buttons">
      <span class="ui basic tiny label">{{ Auth::user()->role->name }}</span>
    </div>
  </div>
  <!-- Pending loop to automatically pull all menu items -->
  <a class="item {{ Request::routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
    <i class="large dashboard icon"></i> Dashboard
  </a>
  <a class="item {{ Request::routeIs('admin.shows.index') ? 'active' : '' }}" href="{{ route('admin.shows.index') }}">
    <i class="large film icon"></i> Shows
  </a>
  @if (Auth::user()->role->name == 'Senior Staff' || Auth::user()->role->name == 'Planetarium Lead Assistant')
  <a class="item {{ Request::routeIs('admin.calendar.index') ? 'active' : '' }}" href="{{ route('admin.calendar.index') }}">
    <i class="large calendar icon"></i> Calendar
  </a>
  <a class="item {{ Request::routeIs('admin.events.index') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">
    <i class="large calendar check icon"></i> Events
  </a>
  <a class="item {{ Request::routeIs('admin.sales.index') ? 'active' : '' }}" href="{{ route('admin.sales.index') }}">
    <i class="large dollar icon"></i> Sales
  </a>
  <a class="item {{ Request::routeIs('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
    <i class="large file text icon"></i> Reports
  </a>
  <a class="item {{ Request::routeIs('admin.members.index') ? 'active' : '' }}" href="{{ route('admin.members.index') }}">
    <i class="large address card icon"></i> Members
  </a>
  <a class="item {{ Request::routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
    <i class="large users icon"></i> Users
  </a>
  <a class="item {{ Request::routeIs('admin.organizations.index') ? 'active' : '' }}" href="{{ route('admin.organizations.index') }}">
    <i class="large university icon"></i> Organizations
  </a>
  <a class="item {{ Request::routeIs('admin.settings.index') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}" >
    <i class="large setting icon"></i> Settings
  </a>
  @endif
  <a class="item" href="http://astral.anderfernandes.com/docs/1.0.0-alpha1/" target="_blank">
    <i class="large help circle icon"></i> Help
  </a>

  <div class="item">
    <img class="ui centered tiny image" src="{{ '/'.App\Setting::find(1)->logo }}" alt="">
  </div>
</div>
