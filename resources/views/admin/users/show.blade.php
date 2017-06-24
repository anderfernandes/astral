@extends('layout.admin')

@section('title', 'User Information')

@section('content')

  <h2 class="ui dividing header">
    <i class="book icon"></i>
    <div class="content">
      User Information
      <div class="sub header">{{ $user->firstname }} {{ $user->lastname }}</div>
    </div>
  </h2>

  <div class="ui buttons">
    <a href="{{ route('admin.users.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.users.edit', $user) }}" class="ui primary button">
      <i class="edit icon"></i> Edit User
    </a>

    {!! Form::open(['route' => ['admin.users.destroy', $user], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete User', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
  </div>

  <div class="ui unstackable items">
    <div class="item">
      <div class="image">
        <img src="https://semantic-ui.com/images/wireframe/image.png" alt="">
      </div>
      <div class="content">
        <h1 class="ui huge header">
          {{ $user->firstname }} {{ $user->lastname }}
          <div class="sub header">{{ $user->email }}</div>
        </h1>
        <div class="meta">
          <div class="ui label">{{ $user->role }}</div>
        </div>
        <div class="description">
          <p>Created on {{ Date::parse($user->created_at)->format('l, F j, Y \a\t h:i:s A') }} ({{ Date::parse($user->created_at)->diffForHumans()}})</p>
          <p>Updated on {{ Date::parse($user->updated_at)->format('l, F j, Y \a\t h:i:s A') }} ({{ Date::parse($user->updated_at)->diffForHumans()}})</p>
        </div>
        <div class="extra"></div>
      </div>
    </div>
  </div>

@endsection
