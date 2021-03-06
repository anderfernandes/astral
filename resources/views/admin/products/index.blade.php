@extends('layout.admin')

@section('title', 'Products')

@section('subtitle', 'Manage products')

@section('icon', 'box')

@section('content')

<form action="{{ route('admin.products.index') }}" class="ui form" method="GET">
  <div class="four fields">
    <div class="field">
      <select name="product_name" class="ui search dropdown">
        <option selected value="">All Products</option>
        @foreach (App\Product::all()->sortBy('name') as $p)
          <option value="{{ $p->id }}">{{ $p->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="field">
      <select name="product_type" class="ui search dropdown">
        <option value="">All Product Types</option>
        @foreach ($productTypes->sortBy('name') as $t)
          <option value="{{ $t->id }}">{{ $t->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="field">
      <div class="ui labeled input">
        <div class="ui basic label">$</div>
        <input name="product_price" type="text" value="{{ isSet($request->product_price) ? $request->product_price : null }}" placeholder="Product Price">
      </div>
    </div>
    <div class="field">
      <button class="ui secondary button" type="submit"><i class="search icon"></i> Search</button>
    </div>
  </div>
</form>

@if (str_contains(Auth::user()->role->permissions['products'], "C"))
<div onclick="$('#add-product').modal('toggle')" class="ui secondary button">
  <i class="ui icons">
    <i class="box icon"></i>
    <i class="inverted corner add icon"></i>
  </i>
  Add Product
</div>
<br><br>
@endif

<div class="ui two column doubling stackable grid">
  @foreach ($products as $product)
  <div class="column">
    <div class="ui items">
      <div class="item">
        <div class="image">
          <img src="{{ $product->cover }}">
          @if (str_contains(Auth::user()->role->permissions['products'], "U"))
          <a href="{{ route('admin.products.edit', $product) }}" class="ui yellow right corner label"><i class="edit icon"></i></a>
          @endif
        </div>
        <div class="content">
          <a class="header">{{ $product->name }}</a>
          <div class="extra">
            <div class="ui green tag label" style="margin-right:0">$ {{ number_format($product->price, 2, '.', ',')}}</div>
            <div class="ui black label" style="margin-right:0">{{ $product->type->name }}</div>
            @if ($product->inventory)
              <div class="ui {{ $product->stock < 10 ? 'red' : 'black' }} label" {!! $product->stock < 10 ? "data-tooltip='Only $product->stock in stock!' data-inverted=''" : ""!!} style="margin-right:0">
                <i class="box icon"></i>
                <div class="detail">{{ $product->stock }}</div>
              </div>
            @endif
            @if ($product->creator_id != 1)
              <div class="ui black label" style="margin-right:0">
                <i class="user circle icon"></i>
                <div class="detail">{{ $product->creator->fullname }}</div>
              </div>
            @endif
            <div class="ui basic {{ $product->active ? "green" : "red" }} label">
              {{ $product->active ? "active" : "inactive" }}
            </div>
            @if ($product->public)
                <i class="globe icon" style="color: black !important"></i>
            @endif
            <p><i class="pencil icon"></i>{{ $product->created_at->format('l, F j, Y \a\t g:i A') }}</p>
            <p><i class="edit icon"></i>{{ Date::parse($product->updated_at)->format('l, F j, Y \a\t g:i A') }}</p>
          </div>
          <div class="meta">
            <p><i class="info circle icon"></i> {{ $product->description }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $product = null ?>
@endforeach
</div>

@include('admin.products._create')

<div class="ui centered grid">
  {{ $products->appends(app('request')->input())->links('vendor.pagination.semantic-ui') }}
</div>

<script>
  @if ($request->product_name)
    $('[name="product_name"]').dropdown('set selected', {{ $request->product_name }})
  @endif
  @if ($request->product_type)
    $('[name="product_type"]').dropdown('set selected', {{ $request->product_type }})
  @endif
</script>

@endsection
