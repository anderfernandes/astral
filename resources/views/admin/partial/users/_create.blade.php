{{-- Add User Modal --}}
@component('admin.partial._modal', [
  'id' => 'add-user',
  'icon' => 'user plus',
  'title' => 'Add User'
])
  @slot('content')
    @include('admin.partial.users._form', ['type' => 'create'])
  @endslot
@endcomponent
