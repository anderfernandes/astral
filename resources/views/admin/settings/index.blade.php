@extends('layout.admin')

@section('title', 'Settings')

@section('subtitle', 'Change global values')

@section('icon', 'setting')

@section('content')

<div class="ui top attached tabular menu">
  <a class="item active" data-tab="general"><i class="setting icon"></i>General</a>
  <a class="item" data-tab="organization-types"><i class="university icon"></i>Organizations</a>
  <a class="item" data-tab="ticket-types"><i class="ticket icon"></i>Tickets</a>
  <a class="item" data-tab="payment-methods"><i class="money icon"></i>Payments</a>
  <a class="item" data-tab="event-types"><i class="calendar icon"></i>Events</a>
  <a class="item" data-tab="user-roles"><i class="users icon"></i>Users</a>
  <a class="item" data-tab="member-types"><i class="address card outline icon"></i>Membership</a>
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
            <th>Allowed In</th>
            <th>Active?</th>
          </tr>
        </thead>
        <tbody>
          @if( $ticketTypes->count() > 0)
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
              <td>
                @foreach($ticketType->allowedEvents as $eventType)
                  <div class="ui mini label">{{ $eventType->name }}</div>
                @endforeach
              </td>
              <td>
                @if ($ticketType->active)
                  Yes
                @else
                  No
                @endif
              </td>
            </tr>
            @endforeach
          @else
            <tr class="warning center aligned">
              <td colspan="4"><i class="info circle icon"></i>You have not added any ticket types yet.</td>
            </tr>
          @endif
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addTicketType', 'class' => 'ui form']) !!}
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
            <th>Type</th>
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
            <td><div class="ui label">{{ $paymentMethod->type }}</div></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addPaymentMethod', 'class' => 'ui form']) !!}
      <div class="three fields">
        <div class="field">
          {!! Form::label('name', 'Payment Method Name') !!}
          {!! Form::text('name', null, ['placeholder' => 'Payment Method name']) !!}
        </div>
        <div class="field">
          {!! Form::label('taxable', 'Icon') !!}
          {!! Form::text('icon', null, ['placeholder' => 'Font Awesome icon class name']) !!}
        </div>
        <div class="field">
          {!! Form::label('type', 'Type') !!}
          {!! Form::select('type',
            [
              'cash'        => 'Cash',
              'card'        => 'Card',
              'check'       => 'Check',
              'money order' => 'Money Order',
              'other'       => 'Other',
            ], 'card', ['placeholder' => 'Taxable?', 'class' => 'ui dropdown']) !!}
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

<!-- Event Types -->
<div class="ui bottom attached tab segment" data-tab="event-types">
  <div class="ui two column doubling grid">
    <div class="column">
      <table class="ui very basic striped selectable celled table">
        <thead>
          <tr>
            <th>Event Types</th>
          </tr>
        </thead>
        <tbody>
          @foreach($eventTypes as $eventType)
          <tr>
            <td>
              <h4 class="ui header">
                <i class="university icon"></i>
                <div class="content">
                  {{ $eventType->name }}
                  <div class="sub header">{{ $eventType->description }}</div>
                </div>
              </h4>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addEventType', 'class' => 'ui form']) !!}
      <div class="field">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['placeholder' => 'Organization Type']) !!}
      </div>
      <div class="field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
      </div>
      <div class="field">
        {!! Form::button('<i class="plus icon"></i> Add Event Type', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<!-- User Roles -->
<div class="ui bottom attached tab segment" data-tab="user-roles">
  <div class="ui two column doubling grid">
    <div class="column">
      <table class="ui very basic striped selectable celled table">
        <thead>
          <tr>
            <th>Roles</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($roles as $role)
          <tr>
            <td>
              <h4 class="ui header">
                <i class="user icon"></i>
                <div class="content">
                  {{ $role->name }}
                  <div class="sub header">{{ $role->description }}</div>
                </div>
              </h4>
            </td>
            <td>
              <a href="{{ route('admin.roles.edit', $role->id) }}" class="ui basic icon button">
                <i class="edit icon"></i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.roles.store', 'class' => 'ui form']) !!}
      <div class="field">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['placeholder' => 'Organization Type']) !!}
      </div>
      <div class="field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
      </div>
      <div class="field">
        {!! Form::button('<i class="plus icon"></i> Add User Role', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<!-- Member Types -->
<div class="ui bottom attached tab segment" data-tab="member-types">
  <div class="ui two column doubling grid">
    <div class="column">
      <table class="ui very basic striped selectable celled table">
        <thead>
          <tr>
            <th>Membership</th>
            <th>Price</th>
            <th>Duration</th>
          </tr>
        </thead>
        <tbody>
          @foreach($memberTypes as $memberType)
          <tr>
            <td>
              <h4 class="ui header">
                <i class="address card outline icon"></i>
                <div class="content">
                  {{ $memberType->name }}
                  <div class="sub header">{{ $memberType->description }}</div>
                </div>
              </h4>
            </td>
            <td>
              $ {{ $memberType->price }}
            </td>
            <td>
              {{ $memberType->duration }} days
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="column">
      {!! Form::open(['route' => 'admin.settings.addMemberType', 'class' => 'ui form']) !!}
      <div class="field">
        {!! Form::label('name', 'Name') !!}
        {!! Form::text('name', null, ['placeholder' => 'Organization Type']) !!}
      </div>
      <div class="field">
        {!! Form::label('description', 'Description') !!}
        {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
      </div>
      <div class="two fields">
        <div class="field">
          {!! Form::label('price', 'Price') !!}
          <div class="ui labeled input">
            <div class="ui label">$</div>
            {!! Form::text('price', null, ['placeholder' => 'How much is this membership going to cost?']) !!}
          </div>
        </div>
        <div class="field">
          {!! Form::label('duration', 'Duration') !!}
          <div class="ui right labeled input">
            {!! Form::text('duration', null, ['placeholder' => 'Enter the duration in days']) !!}
            <div class="ui label">days</div>
          </div>

        </div>
      </div>
      <div class="field">
        {!! Form::button('<i class="plus icon"></i> Add Member Type', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<script>
  $('.menu .item').tab({ history: true });
  $('.ui.form').form({ fields: { price: ['number', 'empty'] } });
</script>

@endsection
