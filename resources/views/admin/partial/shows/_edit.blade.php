{{-- Edit Show Modal --}}
@component('admin.partial._modal', [
  'id'     => 'edit-show',
  'icon'   => 'edit',
  'title'  => 'Edit Show',
])
  @slot('content')
    @component('admin.partial.shows._form', ['type' => 'edit', 'show' => $show])@endcomponent
  @endslot
@endcomponent
