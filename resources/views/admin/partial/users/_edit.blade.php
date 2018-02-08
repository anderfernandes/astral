{{-- Add User Modal --}}
@component('admin.partial._modal', [
  'id' => 'edit-user',
  'icon' => 'edit',
  'title' => 'Edit User'
])
  @slot('content')
    @include('admin.partial.users._form', ['type' => 'edit', 'user' => $user])
  @endslot
@endcomponent
