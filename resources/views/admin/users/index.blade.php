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
      
  <div class="ui link cards">
    @foreach($users as $user)
    <div class="card">
      <div class="content">
        <i class="user circle outline huge right floated icon"></i>
        <div class="header">{{ $user->firstname }} {{ $user->lastname }}</div>
        <div class="meta">{{ $user->role }}</div>
      </div>
      <div class="extra content">
        {!! Form::open(['route' => ['admin.users.destroy', $user], 'method' => 'DELETE']) !!}
          {!! Form::button('<i class="trash icon"></i>', ['type' => 'submit', 'class' => 'ui right floated red icon button']) !!}
        {!! Form::close() !!}
        <div class="ui buttons">
          <a href="{{ route('admin.users.show', $user) }}" class="ui basic blue icon button">
            <i class="book icon"></i>
          </a>
          <a href="{{ route('admin.users.edit', $user ) }}" class="ui basic black icon button">
            <i class="edit icon"></i>
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>

@endsection
