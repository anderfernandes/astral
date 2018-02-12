{!! Form::model($ticketType, ['route' => ['admin.ticket-types.update', $ticketType], 'class' => 'ui form', 'method' => 'PUT']) !!}
<div class="three fields">
  <div class="field">
    {!! Form::label('name', 'Name of Ticket Type') !!}
    {!! Form::text('name', null, ['placeholder' => 'Name']) !!}
  </div>
  <div class="field">
    {!! Form::label('taxable', 'Price') !!}
    <div class="ui labeled input">
      <div class="ui label">$ </div>
      {!! Form::text('price', null, ['placeholder' => 'Price of the ticket']) !!}
    </div>
  </div>
  <div class="field">
    {!! Form::label('active', 'Active?') !!}
    {!! Form::select('active', [true => 'Yes', false => 'No'], true, ['class' => 'ui dropdown']) !!}
  </div>
</div>
<div class="field">
  {!! Form::label('description', 'Description') !!}
  {!! Form::text('description', null, ['placeholder' => 'Describe this ticket type']) !!}
</div>
<div class="field">
  {!! Form::label('Allow in Events', 'Allow in these Events Types') !!}
  {!! Form::select('allow_in_events[]',
    $eventTypes->pluck('name', 'id'),
    null,
    ['id' => 'allow_in_events','placeholder' => 'Choose all that apply', 'class' => 'ui dropdown', 'multiple' => true]) !!}
</div>
<div class="field">
  <div class="ui positive right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
</div>
{!! Form::close() !!}

<script>
  @foreach ($ticketType->allowedEvents as $event)
    $('#allow_in_events').dropdown('set selected', {{ $event->id }})
  @endforeach

  {{-- Client side form validation --}}
  $('form').form({
    inline: true,
    fields: {
      name: {
        identifier: 'name',
        rules: [
          { type: 'empty', prompt: 'Do not forget a name for this ticket!' },
          { type: 'minLength[1]', prompt: '{name} should be at least 1 character long' },
          { type: 'maxLength[16]', prompt: '{name} should be at least 16 character long' }
       ]
     },
     price: {
       identifier: 'price',
       rules: [
         { type: 'empty', prompt: 'Do not forget to set a price for this ticket!' },
         { type: 'number', prompt: '{name} must be a number (integer or decimal)' },
       ]
     },
     description: {
       identifier: 'description',
       rules: [
         { type: 'empty', prompt: 'Do not forget to write a short description for this ticket!' },
         { type: 'minLength[4]', prompt: '{name} should be at least 1 character long' },
         { type: 'maxLength[64]', prompt: '{name} should be at least 64 character long' }
       ]
     },
     allow_in_events: {
       identifier: 'allow_in_events',
       rules: [
         { type: 'minCount[1]', prompt: 'Select at least 1 event type this ticket is allowed to be sold to' }
       ]
     }
    }
  })
</script>
