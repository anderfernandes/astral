@extends('layout.admin')

@section('title', 'Show Information')

@section('subtitle', $show->name)

@section('icon', 'book')

@section('content')

  <div class="ui buttons">
    <a href="{{ route('admin.shows.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i> Back
    </a>
    <a href="javascript:$('#edit-show').modal('show')" class="ui black button">
      <i class="icons"><i class="film icon"></i><i class="corner inverted edit icon"></i></i> Edit Show
    </a>
    <a href="{{ route('admin.shows.create') }}" class="ui black button">
      <i class="icons"><i class="film icon"></i><i class="corner inverted add icon"></i></i> Add Another Show
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
          <div class="ui black label">{{ $show->type }}</div>
          <div class="ui black label">{{ $show->duration }} minutes</div>
        </div>
        <div class="extra">
          <p><i class="user circle icon"></i> {{ $show->creator->fullname }} <br></p>
          <p><i class="pencil icon"></i> {{ $show->created_at->format('l, F j, Y \a\t g:i A') }} ({{ $show->created_at->diffForHumans() }})</p>
          <p><i class="edit icon"></i> {{ Date::parse($show->updated_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($show->updated_at)->diffForHumans() }})</p>
        </div>
        <div class="description">
          {!! \Illuminate\Mail\Markdown::parse($show->description) !!}</div>
      </div>
    </div>
  </div>

  @include('admin.partial.shows._edit')

@endsection
