@extends('layout.admin')

@section('title', 'Products')

@section('subtitle', 'Manage products')

@section('icon', 'box')

@section('content')

<div onclick="$('#add-product').modal('toggle')" class="ui secondary button">
  <i class="ui icons">
    <i class="box icon"></i>
    <i class="inverted corner add icon"></i>
  </i>
  Add Product
</div>
<br><br>
<div class="ui two column doubling stackable grid">
  @foreach ($products as $product)
  <div class="column">
    <div class="ui items">
      <div class="item">
        <div class="image">
          <img src="{{ $product->cover == '/default.png' ? $product->cover : Storage::url($product->cover) }}">
          <a href="{{ route('admin.products.edit', $product) }}" class="ui yellow right corner label"><i class="edit icon"></i></a>
        </div>
        <div class="content">
          <a class="header">{{ $product->name }}</a>
          <div class="ui black label">{{ $product->type->name }}</div>
          <div class="ui green label">$ {{ number_format($product->price, 2, '.', ',')}}</div>
          <div class="meta">
            <p><i class="info circle icon"></i> {{ $product->description }}</p>
          </div>
          <div class="description">
            <p></p>
          </div>
          <div class="extra">
            <p><i class="pencil icon"></i>{{ Date::parse($product->created_at)->format('l, F j, Y \a\t g:i A') }}</p>
            <p><i class="edit icon"></i>{{ Date::parse($product->updated_at)->format('l, F j, Y \a\t g:i A') }}</p>
            @if ($product->creator_id != 1)
              <p><i class="user circle icon"></i>{{ $product->creator->fullname }}</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php $product = null ?>
@endforeach
</div>

@include('admin.products._create')

@endsection
