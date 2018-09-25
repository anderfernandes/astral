@if ($type == 'create')
  {!! Form::open(['route' => 'admin.shows.store', 'class' => 'ui form', 'enctype' => 'multipart/form-data']) !!}
@else
  {!! Form::model($show, ['route' => ['admin.shows.update', $show], 'class' => 'ui form', 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
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
        <div class="ui basic label">minutes</div>
      </div>
  </div>
  <div class="field">
    <label for="cover">Cover</label>
    <div class="ui action input">
      <input type="text" readonly placeholder="Upload a 9:16 cover image of show">
      <input type="file" name="cover" accept=".jpg,.jpeg,.png" style="display:none !important">
      <div class="ui black button">
        Choose Image...
      </div>
    </div>
  </div>
</div>
<div class="field">
  {!! Form::label('description', 'Description') !!}
  {!! Form::textarea('description', null, ['placeholder' => 'What is the show about?', 'id' => 'description', 'data-validate' => 'description']) !!}
</div>
<div class="field">
  @if (Request::routeIs('admin.shows.create') or Request::routeIs('admin.shows.edit'))
    <a href="{{ route('admin.shows.index') }}" class="ui basic black button"><i class="left chevron icon"></i> Back</a>
    <div class="ui positive right floated right labeled submit icon button">Save <i class="save icon"></i></div>
  @else
    <div class="ui positive right floated right labeled submit icon button">Save <i class="save icon"></i></div>
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
      toolbar: ['bold', 'italic', 'unordered-list', 'ordered-list', '|', 'preview'],
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
    }
  })

  $('input:text, .ui.button', '.ui.action.input').on('click', function(e) {
    $('input:file', $(e.target).parents()).click()
  })

  $('input:file', '.ui.action.input').on('change', function(e) {
    var name = e.target.files[0].name
    $('input:text', $(e.target).parent()).val(name)
  })
</script>
