@component('admin.partial._modal', [
  'id'    => 'add-product',
  'icon'  => 'box',
  'type'  => 'add',
  'title' => 'Add Product'
])
@slot('content')
  @include('admin.products._form')
@endslot
@endcomponent
