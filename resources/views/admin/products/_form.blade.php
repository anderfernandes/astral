<form enctype="multipart/form-data" action="{{ isSet($product) ? route('admin.products.update', $product) : route('admin.products.store')}}" method="POST" class="ui form">
  @if (isSet($product))
    {{ method_field('PUT') }}
  @endif
  {{ csrf_field() }}
  <div class="three fields">
    <div class="required field">
      <label for="name">Name</label>
      <input type="text" placeholder="Product Name" name="name" value="{{ isSet($product) ? $product->name : old('name') }}">
    </div>
    <div class="required field">
      <label for="type">Type</label>
      <select class="ui dropdown" name="type_id" value="{{ isSet($product) ? $product->type_id : old('type_id') }}">
        @foreach ($productTypes as $productType)
          <option value="{{ $productType->id }}">{{ $productType->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="required field">
      <label for="price">Price</label>
      <div class="ui labeled input">
        <div class="ui basic label">$</div>
        <input type="text" placeholder="Product Price" name="price" value="{{ isSet($product) ? number_format($product->price, 2) : old('price') }}">
      </div>
    </div>
  </div>
    <div class="two required fields">
      <div class="required field">
        <label for="name">Description</label>
        <input type="text" placeholder="Product Description" name="description" value="{{ isSet($product) ? $product->description : old('description') }}">
      </div>
      <div class="field">
        <label for="cover">Cover</label>
        <div class="ui action input">
          <input type="text" readonly placeholder="Upload an image of the product">
          <input type="file" name="cover" style="display:none !important">
          <div class="ui black button">
            Choose Image...
          </div>
        </div>
      </div>
    </div>
  <div class="field">
    <div class="ui positive right floated right labeled submit icon button">Save <i class="save icon"></i></div>
    <br><br>
  </div>
</form>
<script>

  $('input:text, .ui.button', '.ui.action.input').on('click', function(e) {
    $('input:file', $(e.target).parents()).click()
  })

  $('input:file', '.ui.action.input').on('change', function(e) {
    var name = e.target.files[0].name
    $('input:text', $(e.target).parent()).val(name)
  })

  $('form').form({
    inline: true,
    on: 'blur',
    fields: {
      name        : 'empty',
      price       : ['number', 'empty'],
      description : ['empty', 'minLength[5]'],
      type_id     : ['number', 'empty'],
    }
  })
</script>
