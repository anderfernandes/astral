@extends('layout.admin')

@section('title', 'Show Information')

@section('subtitle', $show->name)

@section('icon', 'book')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.shows.index') }}" class="ui default button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="{{ route('admin.shows.edit', $show) }}" class="ui primary button">
      <i class="edit icon"></i> Edit Show
    </a>
    <a href="{{ route('admin.shows.create') }}" class="ui secondary button">
      <i class="plus icon"></i> Add Another Show
    </a>
    {!! Form::open(['route' => ['admin.shows.destroy', $show], 'method' => 'DELETE']) !!}
      {!! Form::button('<i class="trash icon"></i> Delete Show', ['type' => 'submit', 'class' => 'ui negative button']) !!}
    {!! Form::close() !!}
  </div>

  <div class="ui items">
    <div class="item">
      <div class="ui rounded medium image">
        <img src="{{ $show->cover }}" alt="">
      </div>
      <div class="content">
        <div class="ui large header">{{ $show->name }}</div>
        <div class="meta">
          <div class="ui label">{{ $show->type }}</div>
          <i class="clock icon"></i> {{ $show->duration }} minutes
        </div>
        <div class="meta">
          Created by <i class="user circle outline icon"></i> {{ $show->creator->firstname }} {{ $show->creator->lastname }}
          on {{ Date::parse($show->created_at)->format('l, F j, Y \a\t g:i A') }}
        </div>
        <div class="meta">
          Updated on {{ Date::parse($show->updated_at)->format('l, F j, Y \a\t g:i A') }}
        </div>
        <div class="description">{!! \Illuminate\Mail\Markdown::parse($show->description) !!}</div>
        <div class="extra"></div>
      </div>
    </div>
  </div>

@endsection
