{{-- Edit Show Modal --}}
@component('admin.partial._modal', [
  'id'       => 'edit-show',
  'icon'     => 'film',
  'title'    => 'Edit Show',
  'type'     => 'edit',
  'subtitle' => $show->name,
])
  @slot('content')
    @component('admin.partial.shows._form', ['type' => 'edit', 'show' => $show, 'showTypes' => $showTypes])
    @endcomponent
  @endslot
@endcomponent
