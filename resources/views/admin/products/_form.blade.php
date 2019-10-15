<form enctype="multipart/form-data" action="{{ isSet($product) ? route('admin.products.update', $product) : route('admin.products.store')}}" method="POST" class="ui form">
  @if (isSet($product))
    {{ method_field('PUT') }}
  @endif
  {{ csrf_field() }}
  <div class="three fields">
    <div class="field">
      <label for="active">Public</label>
      <select name="public" id="public" class="ui dropdown">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>
    <div class="field">
      <label for="active">Active</label>
      <select name="active" id="active" class="ui dropdown">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>
    <div class="field">
      <label for="active">Show in Cashier?</label>
      <select name="in_cashier" id="in_cashier" class="ui dropdown">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>
  </div>
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
          <input type="file" name="cover" accept=".jpg,.jpeg,.png" style="display:none !important">
          <div class="ui black button">
            Choose Image...
          </div>
        </div>
      </div>
    </div>
    <div class="two fields">
      <div class="required field">
        <label for="inventory">Track Inventory?</label>
        <select class="ui dropdown" name="inventory" id="inventory" value="{{ isSet($product) ? $product->inventory : old('inventory') }}">
          <option value="0">No</option>
          <option value="1">Yes</option>
        </select>
      </div>
      <div class="disabled field" id="current-stock">
        <label for="stock">Current Stock</label>
        <input type="text" name="stock" placeholder="How many in stock?" value="{{ isSet($product) ? $product->stock : old('stock') }}">
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
      inventory   : ['empty'],
    }
  })

  @isSet($product->inventory)
    $('#inventory').dropdown('set selected', '{{ $product->inventory == 1 ? 'true' : 'false' }}')

    @if ($product->inventory)
      $('#current-stock').removeClass('disabled')
    @else
      $('#current-stock').addClass('disabled')
    @endif

  @endisset

  $("#public").dropdown('set selected', {{ isset($product->public) ? $product->public : old('public') }})
  $("#active").dropdown('set selected', {{ isset($product->active) ? $product->active : old('active') }})
  $("#in_cashier").dropdown('set selected', {{ isset($product->in_cashier) ? $product->in_cashier : old('active') }})

  $('#inventory').change(function() {
    this.value == 'true' ? $('#current-stock').removeClass('disabled') : $('#current-stock').addClass('disabled')
  })


</script>
