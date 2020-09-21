@extends('layout.public')

@section('title', 'Welcome!')

@section('content')

<?php

  $events = \App\Event::whereDate('start', now()->toDateString())->get();

?>

<div class="ui basic segment">
  <div class="ui dividing header">
    Today's Events
  </div>
  <div class="ui link cards">
    @foreach ($events as $event)
      <a href="{{ route('event', $event) }}" class="card">
        <div class="image">
          <img src="{{ $event->show->cover }}" alt="{{ $event->show->name }}">
        </div>
        <div class="content">
          <div class="header">{{ $event->show->name }}</div>
          <div class="meta">
            <div class="ui black label">
              {{ $event->type->name }}
            </div>
            <div class="ui black label">
              {{ $event->show->type }}
            </div>
          </div>
        </div>
      </a>
    @endforeach
  </div>
</div>

@endsection
