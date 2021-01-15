@extends('layout.admin')

@section('title', 'Post')

@section('subtitle', $post->title)

@section('icon', 'comments outline')

@section('content')

  <div class="ui container">
    <a href="{{ route('admin.posts.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i> Back
    </a>
    <div class="ui huge header">
      <i class="comments outline icon"></i>
      <div class="content">{{ $post->title }}</div>
      <div class="sub header">
        <i class="user circle icon"></i>{{ $post->author->firstname }}
        <div class="ui black label">{{ $post->author->role->name }}</div> |
          <i class="calendar alternate outline icon"></i>
          @if ($post->created_at == $post->updated_at)
            {{ $post->created_at->diffForHumans() }}
          @else
            Last updated {{ $post->updated_at->diffForHumans() }}
          @endif
          | &nbsp; &nbsp; &nbsp;
        <div class="ui black tag label"><i class="tag icon"></i>{{ $post->category->name }}</div>
        @if (!$post->open)
          <div class="ui red label"><i class="cancel icon"></i> Closed</div>
        @endif
      </div>
    </div>
    <div class="ui segment" style="font-size:large">
      @if (Auth::user()->id == $post->author_id)
        @if ($post->open)
          <a href="{{ route('admin.posts.edit', $post) }}" class="ui yellow right corner label"><i class="edit icon"></i></a>
        @endif
      @endif
      {!! \Illuminate\Mail\Markdown::parse($post->message) !!}
    </div>

    <div class="ui horizontal divider header"><i class="comments icon"></i>Replies</div>

      @if (isSet($post->replies))
        @if ($post->replies->count() > 0)
          <div class="ui segments">
          @foreach($replies as $reply)
            <div class="ui segment">
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
            </div>
          @endforeach
          </div>
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
      @endif

    @if ($post->open)
    <div class="ui segment">
      @include('admin.partial.replies._create')
      <br><br>
    </div>
    @endif

    <a href="{{ route('admin.posts.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i> Back
    </a>

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
        toolbar: ['bold', 'italic', 'strikethrough', '|', 'code', '|', 'unordered-list', 'ordered-list', '|', 'link', 'image', 'table', 'horizontal-rule', '|', 'preview', 'guide'],
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
