@if (isSet($eventType))
  {!! Form::model($eventType, ['route' => ['admin.event-types.update', $eventType], 'class' => 'ui form', 'id' => 'event_types', 'method' => 'PUT']) !!}
@else
  {!! Form::open(['route' => 'admin.event-types.store', 'class' => 'ui form', 'id' => 'event_types']) !!}
@endif
  <div class="two fields">
    <div class="field">
      {!! Form::label('name', 'Name') !!}
      {!! Form::text('name', null, ['placeholder' => 'Organization Type']) !!}
    </div>
    <div class="field">
      {!! Form::label('color', 'Color') !!}
      <div class="ui selection dropdown">
        <input type="hidden" name="color">
        <i class="dropdown icon"></i>
        <div class="default text">Select an event color</div>
        <div class="menu">
          @foreach ($colors as $name => $hex)
            <div class="item" data-value="{{ $hex }}">
              <div class="ui label" style="background-color: {{ $hex }} !important; border-color: {{ $hex }} !important; color: #fff !important">{{ $name }}</div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="field">
    {!! Form::label('description', 'Description') !!}
    {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
  </div>
  <div class="field">
    <div class="ui {{ Request::routeIs('admin.settings.*') ? 'primary' : 'positive' }} right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
  </div>
{!! Form::close() !!}

<script>
$('#event_types').form({
  on: 'blur',
  inline: true,
  fields: {
    name        : ['empty'],
    color       : ['empty'],
    description : ['empty'],
  }
})

@if (isSet($eventType)) {
  $(document).ready(function() {
    $('.ui.dropdown').dropdown('set selected', '{{ $eventType->color }}')
  })
}
@endif

</script>
