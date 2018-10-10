@if ($type == 'create')
  {!! Form::open(['route' => 'admin.replies.store', 'class' => 'ui form']) !!}
@else
  {!! Form::model($post, ['route' => ['admin.posts.update', $post], 'class' => 'ui fixed bottom sticky form', 'method' => 'PUT']) !!}
@endif
<div class="field">
  {!! Form::label('message', 'Reply') !!}
  {!! Form::textarea('message', null, ['placeholder' => 'Write your reply here', 'id' => 'message', 'data-validate' => 'message']) !!}
</div>
<div class="field">
  @if (Request::routeIs('admin.posts.create') or Request::routeIs('admin.posts.edit'))
    <a href="{{ route('admin.posts.index') }}" class="ui basic black button">
      <i class="left chevron icon"></i> Back
    </a>
    <div class="ui positive right floated right labeled submit icon button">
      Reply <i class="save icon"></i>
    </div>
  @else
    <div class="ui positive right floated right labeled submit icon button">
      Reply <i class="save icon"></i>
    </div>
  @endif
</div>
<input type="hidden" name="post_id" value="{{ $post->id }}">
{!! Form::close() !!}
