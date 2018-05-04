@extends('layout.admin')

@section('title', 'Settings')

@section('subtitle', 'Change global values')

@section('icon', 'setting')

@section('content')

<div class="ui grid">
  <div class="four wide column">
    <div class="ui vertical fluid tabular menu">
      <a class="item active" data-tab="general"><i class="setting icon"></i>General</a>
      <a class="item" data-tab="organization-types"><i class="university icon"></i>Organizations</a>
      <a class="item" data-tab="ticket-types"><i class="ticket icon"></i>Tickets</a>
      <a class="item" data-tab="payment-methods"><i class="money icon"></i>Payments</a>
      <a class="item" data-tab="event-types"><i class="calendar icon"></i>Events</a>
      <a class="item" data-tab="user-roles"><i class="users icon"></i>Users</a>
      <a class="item" data-tab="member-types"><i class="address card outline icon"></i>Membership</a>
      <a class="item" data-tab="bulletin"><i class="comments outline icon"></i>Bulletin</a>
      <a class="item" data-tab="product-types"><i class="box icon"></i>Products</a>
    </div>
  </div>

  <div class="twelve wide streched column">

    {{-- General --}}
    <div class="ui tab segment active" data-tab="general">
      {!! Form::model($setting, ['route' => ['admin.settings.update', $setting], 'class' => 'ui form', 'id' => 'general', 'method' => 'PUT']) !!}
        <div class="field">
          <div class="ui buttons">
            {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui primary button']) !!}
          </div>
        </div>
        <div class="four fields">
          <div class="field">
            {!! Form::label('organization', 'Organization Name') !!}
            {!! Form::text('organization', null, ['placeholder' => 'Organization Name', 'data-validate' => 'organization']) !!}
          </div>
          <div class="field">
            {!! Form::label('astc', 'Member of ASTC?') !!}
            {!! Form::select('astc', [true => 'Yes', false => 'No'], null, ['placeholder' => 'Select an Organization Type', 'class' => 'ui search dropdown']) !!}
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
        <div class="three fields">
          <div class="field">
            {!! Form::label('address', 'Address') !!}
            {!! Form::text('address', null, ['placeholder' => 'Full address']) !!}
          </div>
          <div class="field">
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::tel('phone', null, ['placeholder' => 'Phone']) !!}
          </div>
          <div class="field">
            {!! Form::label('fax', 'Fax') !!}
            {!! Form::tel('fax', null, ['placeholder' => 'Fax']) !!}
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            {!! Form::label('email', 'Email') !!}
            {!! Form::text('email', null, ['placeholder' => 'Email']) !!}
          </div>
          <div class="field">
            {!! Form::label('website', 'Website') !!}
            <div class="ui labeled input">
              <div class="ui label">http://</div>
              {!! Form::text('website', null, ['placeholder' => 'Enter organization\'s website']) !!}
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
          {!! Form::label('membership_text', 'Membership Receipt Text') !!}
          {!! Form::textarea('membership_text', null, ['placeholder' => 'Membership information that will be displayed in the membership receipt']) !!}
        </div>
        <div class="field">
          {!! Form::label('confirmation_text', 'Confirmation Text') !!}
          {!! Form::textarea('confirmation_text', null, ['placeholder' => 'Membership information that will be displayed in the membership receipt']) !!}
        </div>
        <div class="field">
          {!! Form::label('invoice_text', 'Invoice Text') !!}
          {!! Form::textarea('invoice_text', null, ['placeholder' => 'Membership information that will be displayed in the membership receipt']) !!}
        </div>
        <div class="field">
          <div class="ui buttons">
            {!! Form::button('<i class="save icon"></i> Save', ['type' => 'submit', 'class' => 'ui primary button']) !!}
          </div>
        </div>
      {!! Form::close() !!}
    </div>

    {{-- Organization Types --}}
    <div class="ui tab segment" data-tab="organization-types">
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
          {!! Form::open(['route' => 'admin.settings.addOrganizationType', 'class' => 'ui form', 'id' => 'organizations']) !!}
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

    {{-- Ticket Types --}}
    <div class="ui tab segment" data-tab="ticket-types">
      <div class="ui icon info message">
        <i class="info circle icon"></i>
        <i class="close icon"></i>
        <div class="content">
          <div class="header">
            About ticket price updates
          </div>
          <p>
            Once you create a ticket type and attached a price, you won't be able
            to delete it. Tickets that have their price changed will affect only future sales.
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
      <div class="ui one column doubling grid">
        <div class="column">
          <div onclick="$('#add-ticket-type').modal('show')" class="ui black button"><i class="plus icon"></i>Add Ticket Type</div>
          {{-- Add User Ticket Modal --}}
          @component('admin.partial._modal', [
              'id' => 'add-ticket-type',
              'icon' => 'plus',
              'title' => 'Add Ticket Type'
            ])
            @slot('content')
              @include('admin.ticket-types._form', ['ticketType' => null])
            @endslot
          @endcomponent
          <table class="ui very basic striped selectable celled table">
            <thead>
              <tr>
                <th>Available Ticket Types</th>
                <th>Price</th>
                <th>Allowed In</th>
                <th>Active?</th>
                <th>Actions</th>
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
                        @if ($ticketType->in_cashier) <i class="inbox icon"></i> @endif
                        <div class="sub header">{{ $ticketType->description }}</div>
                      </div>
                    </h4>
                  </td>
                  <td>
                    $ {{ number_format($ticketType->price, 2) }}
                  </td>
                  <td>
                    @foreach($ticketType->allowedEvents as $eventType)
                      <div class="ui mini label" style="background-color: {{ $eventType->color }}; color: rgba(255, 255, 255, 0.8)">{{ $eventType->name }}</div>
                    @endforeach
                  </td>
                  <td>
                    @if ($ticketType->active)
                      Yes
                    @else
                      No
                    @endif
                  </td>
                  <td><a href="{{ route('admin.ticket-types.edit', $ticketType) }}" class="ui mini basic icon button"><i class="edit icon"></i></a></td>
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

      </div>
    </div>

    {{-- Payment Methods --}}
    <div class="ui tab segment" data-tab="payment-methods">
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
          {!! Form::open(['route' => 'admin.settings.addPaymentMethod', 'class' => 'ui form', 'id' => 'payment_methods']) !!}
            <div class="three fields">
              <div class="field">
                {!! Form::label('name', 'Payment Method Name') !!}
                {!! Form::text('name', null, ['placeholder' => 'Payment Method name']) !!}
              </div>
              <div class="field">
                {!! Form::label('taxable', 'Icon') !!}
                {!! Form::text('icon', null, ['placeholder' => 'Icon class name']) !!}
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

    {{-- Event Types --}}
    <div class="ui tab segment" data-tab="event-types">
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
                  <div class="ui inverted segment" style="background-color: {{ $eventType->color }}">
                    <a href="{{ route('admin.event-types.edit', $eventType) }}" class="ui right corner label"><i class="edit icon"></i></a>
                    <h4 class="ui inverted header" style="margin-top: 0">
                      <div class="content">
                        {{ $eventType->name }}
                        <div class="sub header">{{ $eventType->description }}</div>
                      </div>
                    </h4>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="column">
          @include('admin.event-types.partial._form', ['eventType' => null])
        </div>
      </div>
    </div>

    {{-- User Roles --}}
    <div class="ui tab segment" data-tab="user-roles">
      <div class="ui two column doubling grid">
        <div class="column">
          <table class="ui very basic striped selectable celled table">
            <thead>
              <tr>
                <th>Roles</th>
                <th>Staff</th>
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
                  <div class="ui label">
                    @if ($role->staff)
                      Yes
                    @else
                      No
                    @endif
                  </div>
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
          {!! Form::open(['route' => 'admin.roles.store', 'class' => 'ui form', 'id' => 'users']) !!}
          <div class="two fields">
            <div class="required field">
              {!! Form::label('name', 'Name') !!}
              {!! Form::text('name', null, ['placeholder' => 'Role Name']) !!}
            </div>
            <div class="required field">
              {!! Form::label('staff', 'Staff') !!}
              {!! Form::select('staff', [false => 'No', true => 'Yes'], false, ['class' => 'ui dropdown']) !!}
            </div>
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

    {{-- Member Types --}}
    <div class="ui tab segment" data-tab="member-types">
      <div class="ui two column doubling grid">
        <div class="column">
          <table class="ui very basic striped selectable celled table">
            <thead>
              <tr>
                <th>Membership</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Max Secondaries</th>
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
                <td>
                  {{ $memberType->max_secondaries }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="column">
          {!! Form::open(['route' => 'admin.settings.addMemberType', 'class' => 'ui form', 'id' => 'memberships']) !!}
          <div class="required field">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['placeholder' => 'Membership Type Name']) !!}
          </div>
          <div class="required field">
            {!! Form::label('description', 'Description') !!}
            {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
          </div>
          <div class="three required fields">
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
            <div class="field">
              {!! Form::label('max_secondaries', 'Maximum Number of Secondaries') !!}
              {!! Form::text('max_secondaries', null, ['placeholder' => 'Limit of secondaries for a membership']) !!}
            </div>
          </div>
          <div class="field">
            {!! Form::button('<i class="plus icon"></i> Add Member Type', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>

    {{-- Bulletin --}}
    <div class="ui tab segment" data-tab="bulletin">
      {!! Form::open(['route' => 'admin.categories.store', 'class' => 'ui form', 'id' => 'bulletin']) !!}
      <div class="two fields">
        <div class="required field">
          {!! Form::label('name', 'Name') !!}
          {!! Form::text('name', null, ['placeholder' => 'Membership Type Name']) !!}
        </div>
        <div class="required field">
          {!! Form::label('description', 'Description') !!}
          {!! Form::text('description', null, ['placeholder' => 'Describe this organization type']) !!}
        </div>
      </div>
      <div class="field">
        {!! Form::button('<i class="plus icon"></i> Add Bulletin Category', ['type' => 'submit', 'class' => 'ui secondary button']) !!}
      </div>
      {!! Form::close() !!}
      <table class="ui very basic striped selectable celled table">
        <thead>
          <tr>
            <th>Category Name and Description</th>
            <th>Created by</th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $category)
          <tr>
            <td>
              <h4 class="ui header">
                <i class="tag icon"></i>
                <div class="content">
                  {{ $category->name }}
                  <div class="sub header">{{ $category->description }}</div>
                </div>
              </h4>
            </td>
            <td>
              {{ $category->creator->fullname }}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Product Types --}}
    <div class="ui tab segment" data-tab="product-types">

      @include('admin.product-types._form')

      <table class="ui very basic striped selectable celled table">
        <thead>
          <tr>
            <th>Product Type and Description</th>
            <th>Created by</th>
          </tr>
        </thead>
        <tbody>
          @foreach($productTypes as $productType)
          <tr>
            <td>
              <a href="{{ route('admin.product-types.edit', $productType) }}" class="ui small header">
                <i class="box icon"></i>
                <div class="content">
                  {{ $productType->name }}
                  <div class="sub header">{{ $productType->description }}</div>
                </div>
              </a>
            </td>
            <td>
              <i class="user circle icon"></i>{{ $productType->creator_id == 1 ? 'system' : $productType->creator->fullname }}
            </td>
          </tr>
          <?php $productType = null ?>
          @endforeach
        </tbody>
      </table>

</div>

<script>
  $('.menu .item').tab({ history: true });

  $('#general').form({
    on: 'blur',
    inline: true,
    fields: {
      organization : ['empty'],
      seats        : ['number', 'empty'],
      tax          : ['number', 'empty'],
      logo         : ['url', 'empty'],
      cover        : ['url', 'empty'],
    }
  })

  $('#organizations').form({
    on: 'blur',
    inline: true,
    fields: {
      name: ['empty'],
      taxable: ['empty'],
      description: ['empty'],
    }
  })

  $('#payment_methods').form({
    on: 'blur',
    inline: true,
    fields: {
      name        : ['empty'],
      icon        : ['empty'],
      type        : ['empty'],
      description : ['empty'],
    }
  })

  $('#users').form({
    on: 'blur',
    inline: true,
    fields: {
      name        : 'empty',
      staff       : 'empty',
      description : 'empty',
    }
  })

  $('#memberships').form({
    on: 'blur',
    inline: true,
    fields: {
      name            : 'empty',
      description     : 'empty',
      price           : ['number', 'empty'],
      duration        : ['number', 'empty'],
      max_secondaries : ['number', 'empty'],
    }
  })

  $('#bulletin').form({
    on: 'blur',
    inline: true,
    fields: {
      name        : 'empty',
      description : 'empty',
    }
  })

  var hideIcons = ["quote", "image", "guide"]

  var simplemde = new SimpleMDE({
    element: document.getElementById('membership_text'),
    hideIcons: hideIcons
  })

  var simplemde = new SimpleMDE({
    element: document.getElementById('confirmation_text'),
    hideIcons: hideIcons
  })

  var simplemde = new SimpleMDE({
    element: document.getElementById('invoice_text'),
    hideIcons: hideIcons
  })

  var tel = document.querySelectorAll('[type="tel"]');
  for (var i = 0; i < tel.length; i++) {
    tel[i].addEventListener('input', function(e) {
      var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
      e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    })
  }
</script>

@endsection
