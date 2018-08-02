<div class="ui tab segment" data-tab="product-types">

  @include('admin.product-types._form')

  <table class="ui very basic striped selectable celled table">
    <thead>
      <tr>
        <th>Product Type and Description</th>
        <th>Created by</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($productTypes as $productType)
      <tr>
        <td>
          <a href="{{ route('admin.product-types.edit', $productType) }}" class="ui small header">
            <i class="box icon"></i>
            <div class="content">
              {{ $productType->name }}
              <div class="sub header">{{ $productType->description }}</div>
            </div>
          </a>
        </td>
        <td>
          <i class="user circle icon"></i>{{ $productType->creator_id == 1 ? 'system' : $productType->creator->fullname }}
        </td>
        <td>
          <a href="{{ route('admin.product-types.edit', $productType) }}" class="ui tiny yellow icon button"><i class="edit icon"></i></a>
        </td>
      </tr>
      <?php $productType = null ?>
      @endforeach
    </tbody>
  </table>

</div>
