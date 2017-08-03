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
        <i class="calendar plus icon"></i> Create Event
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
            <div class="ui unstackable items">
              <div class="item">
                <div class="ui small image">
                  <img src="https://semantic-ui.com/images/wireframe/square-image.png">
                </div>
                <div class="content">
                  <div class="meta">
                    <span class="ui label">{{ $event->type }}</span>
                    <span class="ui label">{{ App\Show::find($event->show_id)->type }}</span>
                    <span class="ui label">{{ App\Show::find($event->show_id)->duration }} minutes</span>
                  </div>
                  <div class="ui header">
                    {{ App\Show::find($event->show_id)->name }}
                    <div class="sub header">
                      <i class="calendar icon"></i>
                      {{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}
                    </div>
                  </div>
                  <div class="meta">
                    <span class="ui tag label">$ {{ $event->adults_price }} / adult</span>
                    <span class="ui tag label">$ {{ $event->children_price }} / child</span>
                    <span class="ui tag label">$ {{ $event->members_price }} / member</span>
                  </div>
                  <div class="description">

                  </div>
                  <div class="extra">
                    Created by {{ $event->creator->firstname }} {{ $event->creator->lastname }} on {{ Date::parse($event->created_at)->format('l, F j, Y \a\t g:i A') }}
                  </div>
                </div>
              </div>
            </div>
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
