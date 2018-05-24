@if ($type == 'create')
  {!! Form::open(['route' => 'admin.shows.store', 'class' => 'ui form']) !!}
@else
  {!! Form::model($show, ['route' => ['admin.shows.update', $show], 'class' => 'ui form', 'method' => 'PUT']) !!}
@endif
<div class="two fields">
  <div class="field">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['placeholder' => 'What\'s the name of the show?']) !!}
  </div>
  <div class="field">
    {!! Form::label('type', 'Type') !!}
    {!! Form::select('type',
      ['Planetarium' => 'Planetarium', 'Laser Light' => 'Laser Light'],
      null,
      ['placeholder' => 'Planetarium or Laser?', 'class' => 'ui dropdown']) !!}
  </div>
</div>
<div class="two fields">
  <div class="field">
      {!! Form::label('duration', 'Duration') !!}
      <div class="ui right labeled input">
        {!! Form::text('duration', null, ['placeholder' => 'How long is the show?']) !!}
        <div class="ui label">minutes</div>
      </div>
    </div>
    <div class="field">
    {!! Form::label('cover', 'Cover') !!}
    {!! Form::text('cover', null, ['placeholder' => 'URL of the cover (PNG or JPEG)']) !!}
  </div>
</div>
<div class="field">
  {!! Form::label('description', 'Description') !!}
  {!! Form::textarea('description', null, ['placeholder' => 'What is the show about?', 'id' => 'description', 'data-validate' => 'description']) !!}
</div>
<div class="field">
  @if (Request::routeIs('admin.shows.create') or Request::routeIs('admin.shows.edit'))
    <div class="ui buttons">
      <a href="{{ route('admin.shows.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
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
            element: document.querySelectorAll('#description')[0],
            toolbar: ['bold', 'italic', 'unordered-list', 'ordered-list', '|', 'preview'],

          })
        }
      }
    })
  } else {
    window.simplemde = new SimpleMDE({
      element: document.querySelector('#description'),
      toolbar: ['bold', 'italic', 'unordered-list', 'ordered-list'],
    })
  }
  {{-- Client side Form Validation --}}
  $('form:not(#search)').form({
    inline: true,
    on: 'blur',
    fields: {
      name: {
        identifier: 'name',
        rules: [
          { type: 'empty', prompt: 'Do not forget the show name!' },
          { type: 'minLength[2]', prompt: '{name} should be at least {ruleValue} characters long'}
        ]
      },
      type: {
        identifier: 'type',
        rules: [{ type: 'empty', prompt: 'Select a show type!' }]
      },
      duration: {
        identifier: 'duration',
        rules: [
          { type: 'empty',   prompt: 'Enter the duration of the show in minutes' },
          { type: 'integer', prompt: '{name} should be an integer' },
          { type: 'maxLength[3]', prompt: '{name} should be at most {ruleValue} characters long'}
        ]
      },
      cover: {
        identifier: 'cover',
        rules: [
          { type: 'empty', prompt: 'Enter the link to the cover of the show' },
          { type: 'url', prompt: 'The link to the show cover must be a public URL to a JPEG or PNG' },
          { type: 'minLength[5]', prompt: '{name} should be at least {ruleValue} characters long'}
        ]
      },

    }
  })
</script>
