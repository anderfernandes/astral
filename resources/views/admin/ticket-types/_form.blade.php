@if (isSet($ticketType))
  {!! Form::model($ticketType, ['route' => ['admin.ticket-types.update', $ticketType], 'class' => 'ui form', 'id' => 'ticket-type', 'method' => 'PUT']) !!}
@else
  {!! Form::open(['route' => 'admin.ticket-types.store', 'class' => 'ui form', 'id' => 'ticket-type']) !!}
@endif
<div class="two fields">
  <div class="field">
    {!! Form::label('name', 'Name of Ticket Type') !!}
    {!! Form::text('name', null, ['placeholder' => 'Name', 'data-validate' => 'tt_name']) !!}
  </div>
  <div class="field">
    {!! Form::label('taxable', 'Price') !!}
    <div class="ui labeled input">
      <div class="ui label">$ </div>
      {!! Form::text('price', null, ['placeholder' => 'Price of the ticket', 'data-validate' => 'tt_price']) !!}
    </div>
  </div>
</div>
<div class="two fields">
  <div class="field">
    {!! Form::label('active', 'Active?') !!}
    {!! Form::select('active', [true => 'Yes', false => 'No'], true, ['class' => 'ui dropdown', 'data-validate' => 'tt_active']) !!}
  </div>
  <div class="field">
    {!! Form::label('in_cashier', 'Show In Cashier?') !!}
    {!! Form::select('in_cashier', [true => 'Yes', false => 'No'], ( isSet($ticketType->in_cashier) ? $ticketType->in_cashier : false ), ['class' => 'ui dropdown', 'data-validate' => 'tt_in_cashier']) !!}
  </div>
</div>
<div class="field">
  {!! Form::label('description', 'Description') !!}
  {!! Form::text('description', null, ['placeholder' => 'Describe this ticket type', 'data-validate' => 'tt_description']) !!}
</div>
<div class="field">
  {!! Form::label('Allow in Events', 'Allow in these Events Types') !!}
  {!! Form::select('allow_in_events[]',
    $eventTypes->pluck('name', 'id'),
    null,
    ['id' => 'allow_in_events', 'data-validate' => 'event_types', 'placeholder' => 'Choose all that apply', 'class' => 'ui dropdown', 'multiple' => true]) !!}
</div>
<div class="field">
  <div class="ui positive right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
</div>
{!! Form::close() !!}

<script>
  @isset($ticketType)
    @foreach ($ticketType->allowedEvents as $event)
      $('#allow_in_events').dropdown('set selected', {{ $event->id }})
    @endforeach
  @endisset

  {{-- Client side form validation --}}
  $(document).ready(function() {
    $('#ticket-type').form({
      inline: true,
      on: 'blur',
      fields: {
        tt_name: {
          identifier: 'tt_name',
          rules: [
            { type: 'empty', prompt: 'Do not forget a name for this ticket!' },
            { type: 'minLength[1]'},
            { type: 'maxLength[32]'}
         ]
       },
       tt_price: {
         identifier: 'tt_price',
         rules: [
           { type: 'empty', prompt: 'Do not forget to set a price for this ticket!' },
           { type: 'number', prompt: '{name} must be a number (integer or decimal)' },
         ]
       },
       tt_description: {
         identifier: 'tt_description',
         rules: [
           { type: 'empty', prompt: 'Do not forget to write a short description for this ticket!' },
           { type: 'minLength[4]', prompt: '{name} should be at least 1 character long' },
           { type: 'maxLength[64]', prompt: '{name} should be at least 64 character long' }
         ]
       },
       event_types: {
         identifier: 'event_types',
         rules: [
           { type: 'empty', prompt: 'Select at least 1 event type this ticket is allowed to be sold to' }
         ]
       }
      }
    })
  })
</script>
