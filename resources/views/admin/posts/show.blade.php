@extends('layout.admin')

@section('title', 'Post')

@section('subtitle', $post->title)

@section('icon', 'comments outline')

@section('content')

  <div class="ui container">
    <a href="{{ route('admin.posts.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
    <div class="ui raised {{ $post->sticky ? 'black' : null }} segment">
      <div class="ui huge dividing header">
        <i class="comments outline icon"></i>
        <div class="content">{{ $post->title }}</div>
        <div class="sub header">
          <i class="user circle icon"></i>{{ $post->author->firstname }}<div class="ui label">{{ $post->author->role->name }}</div> |
          <i class="calendar alternate outline icon"></i>{{ Date::parse($post->created_at)->diffForHumans() }} |
          <i class="comments icon"></i> {{ $post->replies->count() }} &nbsp; &nbsp; &nbsp;
          <div class="ui black tag label"><i class="tag icon"></i>{{ $post->category->name }}</div>
        </div>
      </div>
      <div style="font-size:large">
        {!! \Illuminate\Mail\Markdown::parse($post->message) !!}
      </div>
      <div class="ui divider"></div>
      @if (Auth::user()->id == $post->author_id)
        <a href="{{ route('admin.posts.edit', $post) }}" class="ui primary button"><i class="edit icon"></i> Edit</a>
      @endif
    </div>
    <div class="ui segment">
      <div class="ui dividing header">Replies</div>
      @if (isSet($post->replies) || $post->replies > 0)
        @foreach($replies as $reply)
          <div class="ui comments">
            <div class="comment">
            <div class="avatar"><i class="user circle big icon"></i></div>
            <div class="content">
              <div class="author">
                {{ $reply->author->firstname }}
                <div class="metadata">
                  <span class="date">{{ Date::parse($reply->created_at)->diffForHumans() }}</span>
                </div>
              </div>
              <div class="text">
                {!! \Illuminate\Mail\Markdown::parse($reply->message) !!}
              </div>
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
              No replies!
            </div>
            <p>It looks like there are no one has replied to this post yet.</p>
          </div>
        </div>
      @endif
    </div>
    <div class="ui segment">
      @include('admin.partial.replies._create')
      <br><br>
    </div>

    <a href="{{ route('admin.posts.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>

  </div>

  <script>
    if (document.querySelector('.ui.modal')) {
      $('.ui.modal').modal({
        onShow: function() {
          if (!window.simplemde) {
            window.simplemde = new SimpleMDE({
              element: document.querySelectorAll('#message')[0],
              toolbar: ['bold', 'italic', 'unordered-list', 'ordered-list'],

            })
          }
        }
      })
    } else {
      window.simplemde = new SimpleMDE({
        element: document.querySelector('#message'),
        toolbar: ['bold', 'italic', 'unordered-list', 'ordered-list'],
      })
    }
    {{-- Client side Form Validation --}}
    $('form').form({
      inline: true,
      on: 'blur',
      fields: {
        title: {
          identifier: 'title',
          rules: [
            { type: 'empty', prompt: 'Do not forget the title of the post!' },
            { type: 'minLength[5]', prompt: '{name} should be at least {ruleValue} characters long'}
          ]
        },
      }
    })
  </script>

@endsection
