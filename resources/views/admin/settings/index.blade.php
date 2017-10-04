@extends('layout.admin')

@section('title', 'Settings')

@section('subtitle', 'Change global values')

@section('icon', 'setting')

@section('content')

<div class="ui top attached tabular menu">
  <a class="item active" data-tab="general"><i class="setting icon"></i>General</a>
  <a class="item" data-tab="organization-types"><i class="university icon"></i>Organization Types</a>
  <a class="item" data-tab="ticket-types"><i class="ticket icon"></i>Ticket Types</a>
  <a class="item" data-tab="payment-methods"><i class="money icon"></i>Payment Methods</a>
</div>

<!--- General --->
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

<!--- Organization Types --->
<div class="ui bottom attached tab segment" data-tab="organization-types">
  <div class="ui two column doubling grid">
    <div class="column">
      <table class="ui very basic striped selectable celled table">
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
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addOrganizationType', 'class' => 'ui form']) !!}
      <div class="two fields">
        <div class="field">
          {!! Form::label('name', 'Name') !!}
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
    </div>
  </div>
</div>

<!--- Ticket Types --->
<div class="ui bottom attached tab segment" data-tab="ticket-types">
  <div class="ui icon info message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        About ticket price updates
      </div>
      <p>
        Once you create a ticket type and attached a price, you won't be able
        to change or delete it. This will prevent you changing the value of
        tickets previously sold and delete ticket types that were created by mistake.
      </p>
    </div>
  </div>
  <div class="ui icon info message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        If you need to update a ticket price
      </div>
      <p>How about create a new ticket type with a different name and the new price?</p>
    </div>
  </div>
  <div class="ui two column doubling grid">
    <div class="column">
      <table class="ui very basic striped selectable celled table">
        <thead>
          <tr>
            <th>Available Ticket Types</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
          @foreach($ticketTypes as $ticketType)
          <tr>
            <td>
              <h4 class="ui header">
                <i class="ticket icon"></i>
                <div class="content">
                  {{ $ticketType->name }}
                  <div class="sub header">{{ $ticketType->description }}</div>
                </div>
              </h4>
            </td>
            <td>
              $ {{ number_format($ticketType->price, 2) }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addTicketType', 'class' => 'ui form']) !!}
      <div class="two fields">
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
      </div>
      <div class="field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this ticket type']) !!}
      </div>
      <div class="field">
        {!! Form::button('<i class="plus icon"></i> Add Ticket Type', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<!--- Payment Methods --->
<div class="ui bottom attached tab segment" data-tab="payment-methods">
  <div class="ui two column doubling grid">
    <div class="column">
      <table class="ui very basic striped selectable celled table">
        <thead>
          <tr>
            <th>Available Payment Methods</th>
          </tr>
        </thead>
        <tbody>
          @foreach($paymentMethods as $paymentMethod)
          <tr>
            <td>
              <h4 class="ui header">
                <i class="{{ $paymentMethod->icon }} icon"></i>
                <div class="content">
                  {{ $paymentMethod->name }}
                  <div class="sub header">{{ $paymentMethod->description }}</div>
                </div>
              </h4>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addPaymentMethod', 'class' => 'ui form']) !!}
      <div class="two fields">
        <div class="field">
          {!! Form::label('name', 'Payment Method Name') !!}
          {!! Form::text('name', null, ['placeholder' => 'Payment Method name']) !!}
        </div>
        <div class="field">
          {!! Form::label('taxable', 'Icon') !!}
          {!! Form::text('icon', null, ['placeholder' => 'Font Awesome icon class name']) !!}
        </div>
      </div>
      <div class="field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this payment method']) !!}
      </div>
      <div class="field">
        {!! Form::button('<i class="plus icon"></i> Add Payment Method', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.address/1.6/jquery.address.min.js"></script>

<script>
  $('.menu .item').tab({ history: true });
  $('.ui.form').form({ fields: { price: ['number', 'empty'] } });
</script>

@endsection
