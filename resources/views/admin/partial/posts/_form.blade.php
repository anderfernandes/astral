@if ($type == 'create')
  {!! Form::open(['route' => 'admin.posts.store', 'class' => 'ui form']) !!}
@else
  {!! Form::model($post, ['route' => ['admin.posts.update', $post], 'class' => 'ui form', 'method' => 'PUT']) !!}
@endif
<div class="field">
  {!! Form::label('title', 'Title') !!}
  {!! Form::text('title', null, ['placeholder' => 'What\'s the title of the post?']) !!}
</div>
<div class="two fields">
  <div class="field">
    {!! Form::label('category_id', 'Category') !!}
    {!! Form::select('category_id', $categories, 1, ['placeholder' => 'What is your post about?', 'class' => 'ui dropdown']) !!}
  </div>
  <div class="field">
    {!! Form::label('sticky', 'Sticky') !!}
    {!! Form::select('sticky', [true => 'Yes', false => 'No'], false, ['placeholder' => 'What is your post about?', 'class' => 'ui dropdown']) !!}
  </div>
</div>
<div class="field">
  {!! Form::label('message', 'Message') !!}
  {!! Form::textarea('message', null, ['placeholder' => 'Write your message here', 'id' => 'message', 'data-validate' => 'message']) !!}
</div>
<div class="field">
  @if (Request::routeIs('admin.posts.create') or Request::routeIs('admin.posts.edit'))
    <div class="ui buttons">
      <a href="{{ route('admin.posts.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      <div class="ui positive right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
    </div>
  @else
    <div class="ui positive right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
  @endif
</div>
{!! Form::close() !!}

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
