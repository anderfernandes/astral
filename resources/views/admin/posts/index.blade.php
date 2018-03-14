@extends('layout.admin')

@section('title', 'Bulletin')

@section('subtitle', 'Recent Posts')

@section('icon', 'comments outline')

@section('content')

  <div class="ui container">
    <a href="{{ route('admin.posts.create') }}" class="ui black button"><i class="plus icon"></i> Create Post</a>

    @if (!isSet($sticky) || $sticky->count() > 0)
      <div class="ui horizontal divider header">
        <i class="pin icon"></i> Announcements
      </div>
      @foreach($sticky as $sticky)
      <div class="ui piled segment">
        <div class="ui big comments">
          <div class="comment">
          <div class="avatar"><i class="comment outline big icon"></i></div>
          <div class="content">
            <div class="author">
              <a href="{{ route('admin.posts.show', $sticky) }}">{{ $sticky->title }}</a>
              <div class="metadata">
                <span class="date">{{ Date::parse($sticky->created_at)->diffForHumans() }}</span>
              </div>
            </div>
            <div class="text">
              <div class="ui black tag label"><i class="tag icon"></i>{{ $sticky->category->name }}</div>
              <i class="user circle icon"></i> {{ $sticky->author->firstname }}
            </div>
          </div>
        </div>
        </div>
      </div>
      @endforeach
    @endif

    @if (!isSet($posts) || ($posts->count()) > 0)
      <div class="ui divider"></div>
      @foreach($posts as $post)
      <div class="ui raised segment">
        <h1 class="ui huge header">
          <i class="comments outline icon"></i>
          <div class="content"><a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a></div>
          <div class="sub header">
            <i class="user circle icon"></i>{{ $post->author->firstname }}<div class="ui label">{{ $post->author->role->name }}</div> |
            <i class="calendar alternate outline icon"></i>{{ Date::parse($post->created_at)->diffForHumans() }} |
            <i class="comments icon"></i> {{ $post->replies->count() }} &nbsp; &nbsp; &nbsp;
            <div class="ui black tag label"><i class="tag icon"></i>{{ $post->category->name }}</div>
          </div>
        </h1>
      </div>
      @endforeach
    @else
      <div class="ui info icon message">
        <i class="info circle icon"></i>
        <i class="close icon"></i>
        <div class="content">
          <div class="header">
            No posts!
          </div>
          <p>It looks like there are no posts in the database.</p>
        </div>
      </div>
    @endif
  </div>

@endsection
