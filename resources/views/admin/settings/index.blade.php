@extends('layout.admin')

@section('title', 'Settings')

@section('subtitle', 'Change global values')

@section('icon', 'setting')

@section('content')

<div class="ui top attached tabular menu">
  <a class="item active" data-tab="general"><i class="setting icon"></i>General</a>
  <a class="item" data-tab="organization-types"><i class="university icon"></i>Organization Types</a>
  <!--<a class="item" data-tab="tickets"><i class="ticket icon"></i>Tickets</a>-->
</div>
<div class="ui bottom attached tab segment active" data-tab="general">
  {!! Form::model($setting, ['route' => ['admin.settings.update', $setting], 'class' => 'ui form', 'method' => 'PUT']) !!}
  <div class="field">
    <div class="ui buttons">
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui primary button']) !!}
    </div>
  </div>
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
      {!! Form::label('tax', 'Tax (%)') !!}
      <div class="ui right labeled input">
        {!! Form::number('tax', null, ['placeholder' => 'Tax %', 'step' => '0.01']) !!}
        <div class="ui label">%</div>
      </div>
    </div>
  </div>
  <div class="two fields">
    <div class="field">
      {!! Form::label('logo', 'Logo (URL)') !!}
      {!! Form::text('logo', null, ['placeholder' => 'URL to a PNG or JPEG']) !!}
      <br /><br />
    </div>
    <div class="field">
      {!! Form::label('cover', 'Cover (URL)') !!}
      {!! Form::text('cover', null, ['placeholder' => 'URL to a PNG or JPEG']) !!}
      <br /><br />
    </div>
  </div>
  <div class="ui two column grid">
    <div class="column">
      <div class="ui basic segment"><img src="{{ '/'.App\Setting::find(1)->logo }}" alt="" class="ui small image"></div>
    </div>
    <div class="column">
      <div class="ui basic segment"><img src="{{ '/'.App\Setting::find(1)->cover }}" alt="" class="ui medium image"></div>
    </div>
  </div>
  <div class="field">
    <div class="ui buttons">
      {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui primary button']) !!}
    </div>
  </div>
  {!! Form::close() !!}
</div>
<div class="ui bottom attached tab segment" data-tab="organization-types">
  {!! Form::open(['route' => 'admin.settings.addOrganizationType', 'class' => 'ui form']) !!}
  <div class="two fields">
    <div class="field">
      {!! Form::label('name', 'Type') !!}
      {!! Form::text('name', null, ['placeholder' => 'Organization Type']) !!}
    </div>
    <div class="field">
      {!! Form::label('taxable', 'Taxable') !!}
      {!! Form::select('taxable',
        [1 => 'Yes', 0 => 'No'],
        null,
        ['placeholder' => 'Taxable?', 'class' => 'ui dropdown']) !!}
    </div>
  </div>
  <div class="field">
    {!! Form::label('description', 'Description') !!}
    {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
  </div>
  <div class="field">
    {!! Form::button('<i class="plus icon"></i> Add Organization Type', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
  </div>
  {!! Form::close() !!}
  <div class="ui divider"></div>
  <table class="ui very basic collapsing celled table">
    <thead>
      <tr>
        <th>Available Types</th>
        <th>Number of Organizations</th>
        <th>Taxable</th>
      </tr>
    </thead>
    <tbody>
      @foreach($organizationTypes as $organizationType)
      <tr>
        <td>
          <h4 class="ui header">
            <i class="university icon"></i>
            <div class="content">
              {{ $organizationType->name }}
              <div class="sub header">{{ $organizationType->description }}</div>
            </div>
          </h4>
        </td>
        <td>
          {{ App\Organization::where('type_id', $organizationType->id)->count() }}
        </td>
        <td>
          @if ($organizationType->taxable)
            <div class="ui label">Yes</div>
          @else
            <div class="ui label">No</div>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<!--<div class="ui bottom attached tab segment" data-tab="tickets">
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
</div>-->


<script>
  $('.menu .item').tab();
</script>

@endsection
