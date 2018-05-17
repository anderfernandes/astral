<form action="{{ isSet($productType) ? route('admin.product-types.update', $productType) : route('admin.product-types.store') }}" method="POST" class="ui form" id="product-types">
  @if (isSet($productType))
    {{ method_field('PUT') }}
  @endif
  {{ csrf_field() }}
  <div class="required two fields">
    <div class="field">
      <label for="name">Product Type Name</label>
      <input type="text" name="name" value="{{ isSet($productType) ? $productType->name : old('name') }}" placeholder="Enter name of product type">
    </div>
    <div class="field">
      <label for="description">Product Type Description</label>
      <input type="text" name="description" value="{{ isSet($productType) ? $productType->description : old('description') }}" placeholder="What is this product type for?">
    </div>
  </div>
  <div class="field">
    <div class="ui positive right floated right labeled submit icon button">Save <i class="save icon"></i></div>
  </div>
</form>

<script>
$('#product-types').form({
  on: 'blur',
  inline: true,
  fields : {
    name: ['empty', 'minLength[3]'],
    description: ['empty', 'minLength[3]'],
  }
})
</script>
