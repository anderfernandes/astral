{!! Form::open(['route' => 'admin.shows.store', 'class' => 'ui form']) !!}
@if (Request::routeIs('admin.shows.create'))
<div class="field">
  <div class="ui buttons">
    <a href="{{ route('admin.shows.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
    {!! Form::button('Save <i class="checkmark icon"></i>', ['type' => 'submit', 'class' => 'ui positive right labeled icon button']) !!}
  </div>
</div>
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
  {!! Form::textarea('description', null, ['placeholder' => 'What is the show about?']) !!}
</div>
<div class="field">
  @if (Request::routeIs('admin.shows.create'))
    <div class="ui buttons">
      <a href="{{ route('admin.shows.index') }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
      {!! Form::button('Save <i class="checkmark icon"></i>', ['type' => 'submit', 'class' => 'ui positive right labeled icon button']) !!}
    </div>
  @else
    {!! Form::button('Save <i class="checkmark icon"></i>', ['type' => 'submit', 'class' => 'ui positive right floated right labeled icon button']) !!}
  @endif

</div>
{!! Form::close() !!}

<script>
  var simplemde = new SimpleMDE({
    element: document.getElementById('description'),
    toolbar: false
  })
</script>
