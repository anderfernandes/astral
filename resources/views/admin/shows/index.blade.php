@extends('layout.admin')

@section('title', 'Shows')

@section('content')

  <h2 class="ui dividing header">
    <i class="film icon"></i>
    <div class="content">
      Shows
      <div class="sub header">Add, Edit and Delete Planetarium and Laser Light Shows</div>
    </div>
  </h2>

  <div class="ui secondary menu">
    <div class="item">
      <a class="ui secondary button" href="{{ route('admin.shows.create') }}">
        <i class="plus icon"></i> New Show
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

  <div class="ui five doubling link cards">
    @foreach($shows as $show)
    <div class="card">
      <a href="{{ route('admin.shows.show', $show) }}" class="image">
        <img src="https://semantic-ui.com/images/wireframe/image.png">
      </a>
      <div class="content">
        <a class="header">{{ $show->name }}</a>
        <div class="meta">
          <i class="clock icon"></i> {{ $show->duration }} minutes
        </div>
        <div class="description">
          <div class="ui label">{{ $show->type }}</div>
        </div>
      </div>
      <div class="extra content">
        <div class="right floated ui basic icon buttons">
          <a href="{{ route('admin.shows.show', $show) }}" class="ui button">
            <i class="book icon"></i>
          </a>
          <a href="{{ route('admin.shows.edit', $show ) }}" class="ui button">
            <i class="edit icon"></i>
          </a>
          {!! Form::open(['route' => ['admin.shows.destroy', $show], 'method' => 'DELETE']) !!}
						{!! Form::button('<i class="trash icon"></i>', ['type' => 'submit', 'class' => 'ui button']) !!}
					{!! Form::close() !!}
        </div>
      </div>
    </div>
    @endforeach
  </div>

@endsection
