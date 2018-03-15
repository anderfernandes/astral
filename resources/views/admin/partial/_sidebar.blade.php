<div class="ui sidebar vertical inverted menu" style="overflow: visible !important">
  <div class="item" style="text-align:center">
    <h1 class="ui inverted icon header"><i class="user circle large icon"></i></h1>
    <br />
    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
    <br /><br />
    <div class="ui tiny buttons">
      <span class="ui basic tiny label">{{ Auth::user()->role->name }}</span>
    </div>
  </div>
  <!-- Pending loop to automatically pull all menu items -->
  <a class="item {{ Request::routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
    <i class="large dashboard icon"></i></i> Dashboard
  </a>
  <div class="ui dropdown item">
    <i class="large film icon"></i> Shows
    <div class="menu">
      <a class="item {{ Request::routeIs('admin.shows.index') ? 'active' : '' }}" href="{{ route('admin.shows.index') }}">
        <i class="large film icon"></i> All Shows
      </a>
      <a class="item {{ Request::routeIs('admin.shows.create') ? 'active' : '' }}" href="{{ route('admin.shows.create') }}">
        <i class="large plus icon"></i> Add Show
      </a>
    </div>
  </div>
  @if (Auth::user()->role->name == 'Senior Staff' || Auth::user()->role->name == 'Planetarium Lead Assistant')
  <div class="ui dropdown item" href="{{ route('admin.calendar.index') }}">
    <i class="large calendar icon"></i> Calendar
    <div class="menu">
      <a class="item" href="{{ route('admin.calendar.index') }}/?type=calendar&view=agendaWeek">
        <i class="large dollar icon"></i> Reservations
      </a>
      <a class="item" href="{{ route('admin.calendar.index') }}/?type=events&view=agendaWeek">
        <i class="large calendar check icon"></i> Events
      </a>
    </div>
  </div>
  <a class="item {{ Request::routeIs('admin.sales.index') ? 'active' : '' }}" href="{{ route('admin.sales.index') }}">
    <i class="large dollar icon"></i> Sales
  </a>
  <div class="ui dropdown item" href="{{ route('admin.reports.index') }}">
    <i class="large file text icon"></i> Reports
    <div class="menu">
      <a class="item" href="{{ route('admin.reports.index') }}/#cashier">
        <i class="large inbox icon"></i> Cashier
      </a>
      <a class="item" href="{{ route('admin.reports.index') }}/#royalties">
        <i class="large money icon"></i> Royalties
      </a>
      <a class="item" href="{{ route('admin.reports.index') }}/#membership">
        <i class="large address card icon"></i> Membership
      </a>
    </div>
  </div>
  <div class="ui dropdown item">
    <i class="large address card icon"></i> Members
    <div class="menu">
      <a class="item {{ Request::routeIs('admin.members.index') ? 'active' : '' }}" href="{{ route('admin.members.index') }}">
        <i class="large address card icon"></i> All Members
      </a>
      <a class="item {{ Request::routeIs('admin.members.create') ? 'active' : '' }}" href="{{ route('admin.members.create') }}">
        <i class="large plus icon"></i> Add Member
      </a>
    </div>
  </div>
  <div class="ui dropdown item">
    <i class="large users icon"></i> Users
    <div class="menu">
      <a class="item {{ Request::routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
        <i class="large users icon"></i> All Users
      </a>
      <a class="item {{ Request::routeIs('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.create') }}">
        <i class="large user plus icon"></i> Add User
      </a>
    </div>
  </div>
  <div class="ui dropdown item">
    <i class="large university icon"></i> Organizations
    <div class="menu">
      <a class="item {{ Request::routeIs('admin.organizations.index') ? 'active' : '' }}" href="{{ route('admin.organizations.index') }}">
        <i class="large university icon"></i> All Organizations
      </a>
      <a class="item {{ Request::routeIs('admin.organizations.create') ? 'active' : '' }}" href="{{ route('admin.organizations.create') }}">
        <i class="large plus icon"></i> Add Organization
      </a>
    </div>
  </div>
  <a class="item {{ Request::routeIs('admin.posts.index') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
    <i class="large comments outline icon"></i> Bulletin
  </a>
  <div class="ui dropdown item">
    <i class="large setting icon"></i> Settings
    <div class="menu">
      <a class="item" href="{{ route('admin.settings.index') }}">
        <i class="large setting icon"></i> General
      </a>
      <a class="item" href="{{ route('admin.settings.index') }}/#organization-types">
        <i class="large university icon"></i> Organizations
      </a>
      <a class="item" href="{{ route('admin.settings.index') }}/#ticket-types">
        <i class="large ticket icon"></i> Tickets
      </a>
      <a class="item" href="{{ route('admin.settings.index') }}/#payment-methods">
        <i class="large money icon"></i> Payments
      </a>
      <a class="item" href="{{ route('admin.settings.index') }}/#event-types">
        <i class="large calendar icon"></i> Events
      </a>
      <a class="item" href="{{ route('admin.settings.index') }}/#user-roles">
        <i class="large users icon"></i> Users
      </a>
      <a class="item" href="{{ route('admin.settings.index') }}/#member-types">
        <i class="large address card icon"></i> Membership
      </a>
      <a class="item" href="{{ route('admin.settings.index') }}/#bulletin">
        <i class="large comments outline icon"></i> Bulletin
      </a>
    </div>
  </div>
  @endif
  <a class="item" href="http://astral.anderfernandes.com/docs/1.0.0-alpha1/" target="_blank">
    <i class="large help circle icon"></i> Help
  </a>

  <div class="item">
    <img class="ui centered tiny image" src="{{ '/'.App\Setting::find(1)->logo }}" alt="">
  </div>
</div>
