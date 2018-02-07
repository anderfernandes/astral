{{-- Edit Event Modal --}}
@component('admin.partial._modal', [
  'id'     => 'edit-event',
  'icon'   => 'edit',
  'title'  => 'Edit Event',
])
  @slot('content')
    @component('admin.partial.events._form', ['type' => 'edit', 'eventTypes' => $eventTypes, 'shows' => $shows, 'event' => $event])@endcomponent
  @endslot
@endcomponent
