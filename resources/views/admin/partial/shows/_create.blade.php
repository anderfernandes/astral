{{-- Create Show Modal --}}
@component('admin.partial._modal', [
  'id'     => 'add-show',
  'icon'   => 'film',
  'title'  => 'Add Show',
  'type'   => 'add',
])
  @slot('content')
    @include('admin.partial.shows._form', ['type' => 'create'])
  @endslot
@endcomponent
