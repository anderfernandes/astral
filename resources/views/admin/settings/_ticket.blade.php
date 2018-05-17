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
