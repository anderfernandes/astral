@extends('layout.admin')

@section('title', 'Users')

@section('content')

  <h2 class="ui dividing header">
    <i class="users icon"></i>
    <div class="content">
      Users
      <div class="sub header">Add, Edit and Delete Users</div>
    </div>
  </h2>

  <div class="ui secondary menu">
    <div class="item">
      <a class="ui secondary button" href="{{ route('admin.users.create') }}">
        <i class="add user icon"></i> Add User
      </a>
    </div>
    <div class="right item">
      <div class="item">
        <div class="ui transparent icon input">
          <input type="text" placeholder="Search...">
          <i class="search link icon"></i>
        </div>
      </div>
    </div>
  </div>

  <table class="ui striped table">
    <tbody>
      @foreach($users as $user)
        <tr>
          <td>
            <h4 class="ui header">
              <i class="user circle outline icon"></i>
              <div class="content">
                {{ $user->firstname }} {{ $user->lastname }}
                <div class="sub header">{{ $user->role }}</div>
              </div>
            </h4>
          </td>
          <td class="collapsing">
            <div class="ui basic icon buttons">
              <a href="{{ route('admin.users.show', $user) }}" class="ui button">
                <i class="book icon"></i>
              </a>
              <a href="{{ route('admin.users.edit', $user) }}" class="ui button">
                <i class="edit icon"></i>
              </a>
              {!! Form::open(['route' => ['admin.users.destroy', $user], 'method' => 'DELETE']) !!}
    						{!! Form::button('<i class="trash icon"></i>', ['type' => 'submit', 'class' => 'ui button']) !!}
    					{!! Form::close() !!}
            </div>
          </td>
        </tr>

      @endforeach
    </tbody>
  </table>

@endsection
