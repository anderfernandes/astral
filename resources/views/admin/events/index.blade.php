@extends('layout.admin')

@section('title', 'Events')

@section('content')

  <h2 class="ui dividing header">
    <i class="calendar icon"></i>
    <div class="content">
      Events
      <div class="sub header">Add, Edit and Delete Events</div>
    </div>
  </h2>

  <div class="ui secondary menu">
    <div class="item">
      <a class="ui primary button" href="{{ route('admin.events.create') }}">
        <i class="plus icon"></i> New Event
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
      @foreach($events as $event)
        <tr>
          <td>
            <h4 class="ui image header">
              <img src="https://semantic-ui.com/images/wireframe/square-image.png" class="ui mini rounded image">
              <div class="content">
                {{ $event->show }}
                <div class="sub header">{{ $event->type }}</div>
              </div>
            </h4>
          </td>
          <td class="collapsing">
            <div class="ui basic icon buttons">
              <a href="{{ route('admin.events.show', $event) }}" class="ui button">
                <i class="book icon"></i>
              </a>
              <a href="{{ route('admin.events.edit', $event) }}" class="ui button">
                <i class="edit icon"></i>
              </a>
              {!! Form::open(['route' => ['admin.events.destroy', $event], 'method' => 'DELETE']) !!}
    						{!! Form::button('<i class="trash icon"></i>', ['type' => 'submit', 'class' => 'ui button']) !!}
    					{!! Form::close() !!}
            </div>
          </td>
        </tr>

      @endforeach
    </tbody>
  </table>

@endsection
