@extends('layout.admin')

@section('content')

<h2 class="ui dividing header">
  <i class="setting icon"></i>
  <div class="content">
    Settings
    <div class="sub header">Change global values</div>
  </div>
</h2>

{!! Form::model($setting, ['route' => ['admin.settings.update', $setting], 'class' => 'ui form', 'method' => 'PUT']) !!}
<div class="field">
  <div class="ui buttons">
    {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui primary button']) !!}
  </div>
</div>
<div class="ui top attached tabular menu">
  <a class="item active" data-tab="general"><i class="setting icon"></i>General</a>
  <a class="item" data-tab="tickets"><i class="ticket icon"></i>Tickets</a>
</div>
<div class="ui bottom attached tab segment active" data-tab="general">
  <div class="three fields">
    <div class="field">
      {!! Form::label('organization', 'Organization Name') !!}
      {!! Form::text('organization', null, ['placeholder' => 'Organization Name']) !!}
    </div>
    <div class="field">
      {!! Form::label('seats', 'Number of Seats') !!}
      {!! Form::number('seats', null, ['placeholder' => 'Number of Seats']) !!}
    </div>
    <div class="field">
      {!! Form::label('tax', 'Tax') !!}
      {!! Form::number('tax', null, ['placeholder' => 'Tax %', 'step' => '0.01']) !!}
    </div>
  </div>
</div>
<div class="ui bottom attached tab segment" data-tab="tickets">
  <h3 class="ui dividing header">Adults Ticket Settings</h3>
  <div class="two fields">
    <div class="field">
      {!! Form::label('adults-weekend-price', 'Adults Weekend Price') !!}
      {!! Form::number('adults_weekend', null, ['placeholder' => 'Adults Weekend Price', 'step' => '0.01']) !!}
    </div>
    <div class="field">
      {!! Form::label('adult-matinee-price', 'Adults Matinee Price') !!}
      {!! Form::text('adults_matinee', null, ['placeholder' => 'Adults Matinee Price']) !!}
    </div>
    <div class="field">
      {!! Form::label('adult-special-event-price', 'Adults Special Event Price') !!}
      {!! Form::text('adults_special_event', null, ['placeholder' => 'Adults Special Event Price']) !!}
    </div>
  </div>
  <h3 class="ui dividing header">Children Ticket Settings</h3>
  <div class="three fields">
    <div class="field">
      {!! Form::label('children-weekend-price', 'Children Weekend Price') !!}
      {!! Form::text('children_weekend', null, ['placeholder' => 'Children Weekend Price']) !!}
    </div>
    <div class="field">
      {!! Form::label('children-matinee-price', 'Children Matinee Price') !!}
      {!! Form::text('children_matinee', null, ['placeholder' => 'Children Matinee Price']) !!}
    </div>
    <div class="field">
      {!! Form::label('children-special-event-price', 'Children Special Event Price') !!}
      {!! Form::text('children_special_event', null, ['placeholder' => 'Children Special Event Price']) !!}
    </div>
  </div>
  <h3 class="ui dividing header">Members Ticket Settings</h3>
  <div class="three fields">
    <div class="field">
      {!! Form::label('members-weekend-price', 'Members Weekend Price') !!}
      {!! Form::text('members_weekend', null, ['placeholder' => 'Members Weekend Price']) !!}
    </div>
    <div class="field">
      {!! Form::label('members-matinee-price', 'Members Matinee Price') !!}
      {!! Form::text('members_matinee', null, ['placeholder' => 'Members Matinee Price']) !!}
    </div>
    <div class="field">
      {!! Form::label('members-special-event-price', 'Members Special Event Price') !!}
      {!! Form::text('members_special_event', null, ['placeholder' => 'Members Special Event Price']) !!}
    </div>
  </div>
</div>
<div class="field">
  <div class="ui buttons">
    {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui primary button']) !!}
  </div>
</div>
{!! Form::close() !!}
<script>
  $('.menu .item').tab();
</script>

@endsection
