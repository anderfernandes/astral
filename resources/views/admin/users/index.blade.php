@extends('layout.admin')

@section('title', 'Users')

@section('subtitle', 'Manage Users')

@section('icon', 'users')

@section('content')

  {!! Form::open(['route' => 'admin.users.index', 'class' => 'ui form', 'method' => 'get']) !!}
  <div class="five fields">
    <div class="field">
      <div class="ui secondary button" onclick=""="$('#add-user').modal('show')">
        <i class="add user icon"></i> Add User
      </div>
      {!! Form::button('<i class="search icon"></i> Search', ['type' => 'submit', 'class' => 'ui right floated secondary button']) !!}
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="user-id">
        <input type="hidden" id="userId" name="userId">
        <i class="dropdown icon"></i>
          <div class="default text">All Users</div>
        <div class="menu">
          <div class="item" data-value="">All Users</div>
          @foreach (App\User::where('type', 'individual')->where('role_id', '!=', 5)->orderBy('name', 'asc')->get() as $user)
            <div class="item" data-value="{{ $user->id }}">
              {{ $user->fullname }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="role-id">
        <input type="hidden" id="roleId" name="roleId">
        <i class="dropdown icon"></i>
          <div class="default text">All Roles</div>
        <div class="menu">
          <div class="item" data-value="">All Roles</div>
          @foreach (App\Role::where('type', 'individuals')->orderBy('name', 'asc')->get() as $role)
            <div class="item" data-value="{{ $role->id }}">
              {{ $role->name }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="organization-id">
        <input type="hidden" id="organizationId" name="organizationId">
        <i class="dropdown icon"></i>
          <div class="default text">All Organizations</div>
        <div class="menu">
          <div class="item" data-value="">All Organizations</div>
          @foreach (App\Organization::where('type', '!=', 'System')->orderBy('name', 'asc')->get() as $organization)
            <div class="item" data-value="{{ $organization->id }}">
              {{ $organization->name }}
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="field">
      <div class="ui selection search dropdown" id="is-staff">
        <input type="hidden" id="isStaff" name="isStaff">
        <i class="dropdown icon"></i>
          <div class="default text">All Users</div>
        <div class="menu">
          <div class="item" data-value="">All Users</div>
          <div class="item" data-value="true">Staff</div>
          <div class="item" data-value="false">Non-Staff</div>
        </div>
      </div>
    </div>
  </div>
  {!! Form::close() !!}

  @if ($users->count() > 0)
  <div class="ui four doubling link cards">
    @foreach($users as $user)
    <div class="card">
      <div class="content">
        <i class="user circle huge right floated icon"></i>
        <div class="header">{{ $user->fullname }} @if ($user->staff) <i class="star icon"></i>@endif </div>
        <div class="meta">
          <div class="ui label">{{ $user->role->name }}</div>
        </div>
        <div class="meta">
          <i class="mail icon"></i> {{ $user->email }}
        </div>
      </div>
      <div class="ui two bottom attached buttons">
        <a href="{{ route('admin.users.show', $user) }}" class="ui black button">
          <i class="eye icon"></i> View
        </a>
        <a href="{{ route('admin.users.edit', $user ) }}" class="ui blue button">
          <i class="edit icon"></i> Edit
        </a>
      </div>
    </div>
    @endforeach
  </div>

  <br /><br />

  <div class="ui centered grid">
    {{ $users->links('vendor.pagination.semantic-ui') }}
  </div>

  @else
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          Nothing found!
        </div>
        <p>Your search has returned no results</p>
      </div>
    </div>
  @endif

  @include('admin.partial.users._create')

  <script>
    @if ($request->userId)
      $('#user-id').dropdown('set exactly', {{ $request->userId }})
    @endif
    @if ($request->roleId)
      $('#role-id').dropdown('set exactly', "{{ $request->roleId }}")
    @endif
    @if ($request->organizationId)
      $('#organization-id').dropdown('set exactly', "{{ $request->organizationId }}")
    @endif
    @if ($request->isStaff)
      $('#is-staff').dropdown('set exactly', "{{ $request->isStaff }}")
    @endif
  </script>

@endsection
