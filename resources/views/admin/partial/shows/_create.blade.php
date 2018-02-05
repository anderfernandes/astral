{{-- Create Show Modal --}}
@component('admin.partial._modal', [
  'id'     => 'add-show',
  'icon'   => 'plus',
  'title'  => 'Add Show',
])
  @slot('content')
    @include('admin.partial.shows._form', ['type' => 'create'])
  @endslot
@endcomponent
