{{-- Add User Modal --}}
@component('admin.partial._modal', [
  'id' => 'add-ticket-type',
  'icon' => 'plus',
  'title' => 'Add Ticket Type'
])
  @slot('content')
    @include('admin.partial.ticket-types._form', ['type' => 'create'])
  @endslot
@endcomponent
