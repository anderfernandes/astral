@extends('layout.admin')

@section('title', 'Show Information')

@section('content')

  <h2 class="ui dividing header">
    <i class="book icon"></i>
    <div class="content">
      Show Information
      <div class="sub header">{{ $show->name }}</div>
    </div>
  </h2>

  <div class="ui buttons">
    <a href="{{ route('admin.shows.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.shows.edit', $show) }}" class="ui primary button">
      <i class="edit icon"></i> Edit Show
    </a>

    {!! Form::open(['route' => ['admin.shows.destroy', $show], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete Show', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
  </div>

  <div class="ui unstackable items">
    <div class="item">
      <div class="image">
        <img src="https://semantic-ui.com/images/wireframe/image.png" alt="">
      </div>
      <div class="content">
        <div class="header">{{ $show->name }}</div>
        <div class="meta">
          <div class="ui label">{{ $show->type }}</div>
          <i class="clock icon"></i> {{ $show->duration }} minutes</div>
        <div class="description"><p>{{ $show->description }}</p></div>
        <div class="extra"></div>
      </div>
    </div>
  </div>

  <div class="ui buttons">
    <a href="{{ route('admin.shows.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.shows.edit', $show) }}" class="ui primary button">
      <i class="edit icon"></i> Edit Show
    </a>

    {!! Form::open(['route' => ['admin.shows.destroy', $show], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete Show', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
  </div>

@endsection
