@extends('layout.admin')

@section('title', 'User Information')

@section('subtitle', $user->fullname)

@section('icon', 'user')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.users.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="javascript:$('#edit-user').modal('show')" class="ui primary button">
      <i class="edit icon"></i> Edit User
    </a>
    <a href="{{ route('admin.users.create') }}" class="ui secondary button"><i class="add user icon"></i> Add User</a>
    {!! Form::open(['route' => ['admin.users.destroy', $user], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete User', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
  </div>

  <div class="ui unstackable items">
    <div class="item">
      <i class="user circle massive icon"></i>
      <div class="content">
        <h1 class="ui huge header">
          {{ $user->fullname }} @if ($user->staff) <i style="display:inline-block" class="empty star icon"></i>@endif
          <div class="sub header">{{ $user->email }}</div>
        </h1>
        <div class="meta">
          <div class="ui label">{{ $user->role->name }}</div>
        </div>
        @if ($user->organization->name != 'No Organization')
        <div class="meta">
          <div class="ui label">{{ $user->organization->name }}</div>
        </div>
        @endif
        <div class="description">
          <p>Created on {{ Date::parse($user->created_at)->format('l, F j, Y \a\t h:i:s A') }} ({{ Date::parse($user->created_at)->diffForHumans()}})</p>
          <p>Updated on {{ Date::parse($user->updated_at)->format('l, F j, Y \a\t h:i:s A') }} ({{ Date::parse($user->updated_at)->diffForHumans()}})</p>
        </div>
        <div class="extra"></div>
      </div>
    </div>
  </div>

  @include('admin.partial.users._edit')

@endsection
