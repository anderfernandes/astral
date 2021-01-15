@extends('layout.admin')

@section('title', 'Bulletin')

@section('subtitle', 'Recent Posts')

@section('icon', 'comments outline')

@section('content')

  <div class="ui container">
    <a href="{{ route('admin.posts.create') }}" class="ui black button">
      <i class="ui icons">
        <i class="comment icon"></i>
        <i class="inverted corner add icon"></i>
      </i>
      Create Post
    </a>

    @if (!isSet($sticky) || $sticky->count() > 0)
      <div class="ui horizontal divider header">
        <i class="pin icon"></i> Announcements
      </div>
      @foreach($sticky as $sticky)
        <div class="ui black raised segment">
          <div class="ui header">
            <i class="comments outline icon"></i>
            <div class="content"><a href="{{ route('admin.posts.show', $sticky) }}">{{ $sticky->title }}</a></div>
            <div class="sub header">
              <i class="user circle icon"></i>{{ $sticky->author->firstname }}
              <div class="ui black label">{{ $sticky->author->role->name }}</div> |
              <i class="calendar alternate outline icon"></i> 
              @if ($sticky->created_at == $sticky->updated_at)
                {{ $sticky->created_at->diffForHumans() }}
              @else
                Last updated {{ $sticky->updated_at->diffForHumans() }}
              @endif
              |
              <i class="comments icon"></i> {{ $sticky->replies->count() }} &nbsp; &nbsp; &nbsp;
              <div class="ui black tag label"><i class="tag icon"></i>{{ $sticky->category->name }}</div>
            </div>
          </div>
        </div>
      @endforeach
    @endif

    <div class="ui top attached tabular menu">
      <a class="active item" data-tab="open">Open</a>
      <a class="item" data-tab="closed">Closed</a>
    </div>
    <div class="ui bottom attached active tab segment" data-tab="open">
      @if (!isSet($openPosts) || ($openPosts->count()) > 0 )
        @foreach($openPosts as $post)
        <div class="ui raised segment">
          <div class="ui header">
            <i class="comments outline icon"></i>
            <div class="content"><a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a></div>
            <div class="sub header">
              <i class="user circle icon"></i>{{ $post->author->firstname }}<div class="ui label">{{ $post->author->role->name }}</div> |
              <i class="calendar alternate outline icon"></i> 
              @if ($post->created_at == $post->updated_at)
                {{ $post->created_at->diffForHumans() }}
              @else
                Last updated {{ $post->updated_at->diffForHumans() }}
              @endif
              |
              <i class="comments icon"></i> {{ $post->replies->count() }} &nbsp; &nbsp; &nbsp;
              <div class="ui black tag label"><i class="tag icon"></i>{{ $post->category->name }}</div>
            </div>
          </div>
        </div>
        @endforeach
      @else
        <div class="ui info icon message">
          <i class="info circle icon"></i>
          <i class="close icon"></i>
          <div class="content">
            <div class="header">
              No open posts!
            </div>
            <p>It looks like there are no open posts in the database.</p>
          </div>
        </div>
      @endif
    </div>
    <div class="ui bottom attached tab segment" data-tab="closed">
      @if (!isSet($closedPosts) || ($closedPosts->count()) > 0 )
        @foreach($closedPosts as $post)
        <div class="ui raised segment">
          <div class="ui header" style="margin-top:0 !important">
            <i class="comments outline icon"></i>
            <div class="content"><a href="{{ route('admin.posts.show', $post) }}">{{ $post->title }}</a></div>
            <div class="sub header">
              <i class="user circle icon"></i>{{ $post->author->firstname }}<div class="ui label">{{ $post->author->role->name }}</div> |
              <i class="calendar alternate outline icon"></i>{{ Date::parse($post->created_at)->diffForHumans() }} |
              <i class="comments icon"></i> {{ $post->replies->count() }} &nbsp; &nbsp; &nbsp;
              <div class="ui black tag label"><i class="tag icon"></i>{{ $post->category->name }}</div>
            </div>
          </div>
        </div>
        @endforeach
      @else
        <div class="ui info icon message">
          <i class="info circle icon"></i>
          <i class="close icon"></i>
          <div class="content">
            <div class="header">
              No closed posts!
            </div>
            <p>It looks like there are no closed posts in the database.</p>
          </div>
        </div>
      @endif
    </div>
  </div>


  <script>
    $('.menu .item').tab();
  </script>

@endsection
