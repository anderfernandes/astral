@extends('layout.admin')

@section('title', 'Shows')

@section ('subtitle', 'Manage Shows')

@section ('icon', 'film')

@section('content')

  
  <a class="ui secondary button" href="{{ route('admin.shows.create') }}">
    <i class="plus icon"></i> New Show
  </a>
  <div class="ui right icon input">
    <input type="text" placeholder="Search...">
    <i class="search link icon"></i>
  </div>
  
  <br /><br />

  <div class="ui five doubling link cards">
    @foreach($shows as $show)
    <div class="card">
      <a href="{{ route('admin.shows.show', $show) }}" class="image">
        
        <img src="{{ $show->cover }}">
        <div class="ui top right attached label">{{ $show->type }}</div>
        <div class="ui top left attached label">{{ $show->duration }} min.</div>
      </a>
      
      <div class="content">
        <a class="header">{{ $show->name }}</a>
      </div>
      <div class="extra content">
        {!! Form::open(['route' => ['admin.shows.destroy', $show], 'method' => 'DELETE']) !!}
          {!! Form::button('<i class="trash icon"></i>', ['type' => 'submit', 'class' => 'ui right floated red icon button']) !!}
        {!! Form::close() !!}
        <div class="ui buttons">
          <a href="{{ route('admin.shows.show', $show) }}" class="ui basic blue icon button">
            <i class="book icon"></i>
          </a>
          <a href="{{ route('admin.shows.edit', $show ) }}" class="ui basic black icon button">
            <i class="edit icon"></i>
          </a>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  

  

@endsection
