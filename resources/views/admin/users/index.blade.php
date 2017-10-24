@extends('layout.admin')

@section('title', 'Users')

@section('subtitle', 'Manage Users')

@section('icon', 'users')

@section('content')

  <a class="ui secondary button" href="{{ route('admin.users.create') }}">
    <i class="add user icon"></i> Add User
  </a>

  <div class="ui right icon input">
    <input type="text" placeholder="Search...">
    <i class="search link icon"></i>
  </div>

  <br /><br />

  <div class="ui four doubling link cards">
    @foreach($users as $user)
    <div class="card">
      <div class="content">
        <i class="user circle outline huge right floated icon"></i>
        <div class="header">{{ $user->firstname }} {{ $user->lastname }}</div>
        <div class="meta">
          <div class="ui label">{{ $user->role->name }}</div>
        </div>
        <div class="meta">
          <i class="mail icon"></i> {{ $user->email }}
        </div>
      </div>
      <div class="ui two bottom attached buttons">
        <a href="{{ route('admin.users.show', $user) }}" class="ui black button">
          <i class="book icon"></i> View
        </a>
        <a href="{{ route('admin.users.edit', $user ) }}" class="ui blue button">
          <i class="edit icon"></i> Edit
        </a>
      </div>
    </div>
    @endforeach
  </div>

  <br />

  <div class="ui centered grid">
    {{ $users->links('vendor.pagination.semantic-ui') }}
  </div>

@endsection
