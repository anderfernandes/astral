<div class="ui sidebar vertical inverted menu" style="overflow: visible !important">

  <div class="item" style="text-align:center">
    <h3 class="ui inverted icon header"><i class="user circle large icon"></i></h3>
    <br />
    {!! Auth::user()->fullname !!}
    <br /><br />
    <div class="ui tiny buttons">
      <span class="ui basic tiny label">{{ Auth::user()->role->name }}</span>
    </div>
  </div>

  {{-- Pending loop to automatically pull all menu items --}}
  <a class="item {{ Request::routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
    <i class="large dashboard icon"></i></i> Dashboard
  </a>

  @if(str_contains(Auth::user()->role->permissions['shows'], "R"))
  {{-- Shows --}}
  <div class="ui dropdown item" onclick="location.href='{{ route('admin.shows.index') }}'">
    <i class="large film icon"></i> Shows
    <div class="menu">
      <a class="item {{ Request::routeIs('admin.shows.index') ? 'active' : '' }}" href="{{ route('admin.shows.index') }}">
        <i class="large film icon"></i> All Shows
      </a>
      <a class="item {{ Request::routeIs('admin.shows.create') ? 'active' : '' }}" href="{{ route('admin.shows.create') }}">
        <i class="add icon"></i> Add Show
      </a>
    </div>
  </div>
  @endif

  @if(str_contains(Auth::user()->role->permissions['products'], "R"))
  {{-- Products --}}
  <div class="ui dropdown item" onclick="location.href='{{ route('admin.products.index') }}'">
    <i class="large box icon"></i> Products
    <div class="menu">
      <a class="item {{ Request::routeIs('admin.products.index') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
        <i class="large box icon"></i> All Products
      </a>
      <a class="item {{ Request::routeIs('admin.products.create') ? 'active' : '' }}" href="{{ route('admin.products.create') }}">
        <i class="add icon"></i> Add Product
      </a>
    </div>
  </div>
  @endif

  @if(str_contains(Auth::user()->role->permissions['calendar'], "R"))
  {{-- Calendar --}}
  <a class="ui dropdown item" href="{{ route('admin.calendar.events') }}?type=events&view=agendaWeek">
    <i class="large calendar alternate icon"></i> Calendar
  </a>
  @endif

  @if(str_contains(Auth::user()->role->permissions['sales'], "R"))
  {{-- Sales --}}
  <a class="item {{ Request::routeIs('admin.sales.index') ? 'active' : '' }}" href="{{ route('admin.sales.index') }}">
    <i class="large dollar icon"></i> Sales
  </a>
  @endif

  @if(str_contains(Auth::user()->role->permissions['calendar'], "R"))
  {{-- Reports --}}
  <div class="ui dropdown item" onclick="location.href='{{ route('admin.reports.index') }}'">
    <i class="large file text icon"></i> Reports
    <div class="menu">
      <a class="item" href="{{ route('admin.reports.index') }}/#cashier">
        <i class="large inbox icon"></i> Cashier
      </a>
      <a class="item" href="{{ route('admin.reports.index') }}/#attendance">
        <i class="large ticket icon"></i> Attendance
      </a>
      <a class="item" href="{{ route('admin.reports.index') }}/#royalties">
        <i class="large money icon"></i> Royalties
      </a>
      <a class="item" href="{{ route('admin.reports.index') }}/#membership">
        <i class="large address card icon"></i> Membership
      </a>
      <a class="item" href="{{ route('admin.reports.index') }}/#product">
        <i class="large box icon"></i> Product
      </a>
      <a class="item" href="{{ route('admin.reports.index') }}/#system">
        <i class="large setting icon"></i> System
      </a>
    </div>
  </div>
  @endif

  @if(str_contains(Auth::user()->role->permissions['members'], "R"))
  {{-- Members --}}
  <div class="ui dropdown item" onclick="location.href='{{ route('admin.members.index') }}'">
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
  @endif

  @if(str_contains(Auth::user()->role->permissions['users'], "R"))
  {{-- Users --}}
  <div class="ui dropdown item" onclick="location.href='{{ route('admin.users.index') }}'">
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
  @endif

  @if(str_contains(Auth::user()->role->permissions['organizations'], "R"))
  {{-- Organizations --}}
  <div class="ui dropdown item" onclick="location.href='{{ route('admin.organizations.index') }}'">
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
  @endif

  @if(str_contains(Auth::user()->role->permissions['bulletin'], "R"))
  {{-- Bulletin --}}
  <a class="item {{ Request::routeIs('admin.posts.index') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
    <i class="large comments outline icon"></i> Bulletin
  </a>
  @endif

  @if(str_contains(Auth::user()->role->permissions['settings'], "R"))
  {{-- Settings --}}
  <div class="ui dropdown item" onclick="location.href='{{ route('admin.settings.index') }}'">
    <i class="large setting icon"></i> Settings
    <div class="menu">
      <a class="item" href="{{ route('admin.settings.index') }}">
        <i class="large setting icon"></i> General
      </a>
      <a class="item" href="{{ route('admin.settings.index') }}/#announcements">
        <i class="large announcement icon"></i> Announcements
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
      <a class="item" href="{{ route('admin.settings.index') }}/#product-types">
        <i class="large box icon"></i> Products
      </a>
    </div>
  </div>
  @endif

  {{-- Help --}}
  <a class="item" href="http://astral.anderfernandes.com/docs/{{ config('app.version') }}" target="_blank">
    <i class="large help circle icon"></i> Help
  </a>

  <div class="item" style="text-align: center">
    <div class="ui tiny buttons">
      <div class="ui basic tiny image label">
        <img src="/astral-logo-dark.png" alt="Astral">
        {{ config('app.version') }}
      </div>
    </div>
  </div>
  <div class="item" style="text-align: center">
    2017-2018 <a href="http://anderfernandes.com" target="_blank">@anderfernandes</a>
  </div>
</div>
