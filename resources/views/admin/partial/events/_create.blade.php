{{-- Create Event Modal --}}
@component('admin.partial._modal', [
  'id'     => 'create-event',
  'icon'   => 'plus',
  'title'  => 'Create Event',
])
  @slot('content')
    @include('admin.partial.events._form', ['type' => 'create'])
  @endslot
@endcomponent
