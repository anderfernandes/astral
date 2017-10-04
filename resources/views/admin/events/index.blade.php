@extends('layout.admin')

@section('title', 'Events')

@section('subtitle', 'Manage Events')

@section('icon', 'calendar')

@section('content')

  <a class="ui secondary button" href="{{ route('admin.events.create') }}">
    <i class="calendar plus icon"></i> Create Event
  </a>

  <div class="ui right icon input">
    <input type="text" placeholder="Search...">
    <i class="search link icon"></i>
  </div>

  @if (!isset($events) || count($events) > 0)
    <br /><br />
    <div class="ui doubling stackable grid">
      @foreach($events as $event)
        <div class="ui eight wide column">
          <div class="ui segment">
            <div class="ui unstackable items">
              <div class="item">
                <div class="ui small image">
                  <img src="{{ $event->show->cover }}">
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
                  <div class="extra">
                    Created by {{ $event->creator->firstname }} {{ $event->creator->lastname }} on {{ Date::parse($event->created_at)->format('l, F j, Y \a\t g:i A') }}
                  </div>
                  <div class="description">
                    {!! Form::open(['route' => ['admin.events.destroy', $event], 'method' => 'DELETE']) !!}
                    {!! Form::button('<i class="trash icon"></i> Delete', ['type' => 'submit', 'class' => 'ui right floated red button']) !!}
                    {!! Form::close() !!}
                    <a href="{{ route('admin.events.show', $event) }}" class="ui secondary button">
                      <i class="book icon"></i> View
                    </a>
                    <a href="{{ route('admin.events.edit', $event) }}" class="ui primary button">
                      <i class="edit icon"></i> Edit
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          No events!
        </div>
        <p>It looks like there are no events in the database.</p>
      </div>
    </div>
  @endif



@endsection
