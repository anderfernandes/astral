@extends('layout.report')

@section('title', "All Products Report")

@section('content')

  <style>
    @media print {
      .ui.icon.buttons {
        display: none !important;
      }
      p, h4.ui.header, table, thead, tbody, ul, li, h4.ui.header .sub.header {
        font-size: 0.78rem !important;
      }
    }
  </style>

  <div class="ui icon right floated buttons" style="margin-bottom:5rem">
    <div onclick="window.print()" class="ui black button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui red button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <div class="ui center aligned icon header" style="margin-top:8px">
    <div class="content">All Products Report</div>
    <div class="sub header">
      {{ Date::parse($start)->format('l, F j, Y') }} | {{ Date::parse($end)->format('l, F j, Y') }}
    </div>
  </div>

  <h4 class="ui header">
    {{ Date::now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  <?php

    $ast = 0;
    $pt = 0;
    $st = 0;

    foreach ($products as $product)
    {
      $ast += $product->sales->count();
      $st += $product->sales->unique()->sum('subtotal');
      $pt += $product->sales->count() * $product->price;
    }

  ?>

  <div class="ui horizontal divider header">Overview</div>

  <div class="ui mini statistics">
    <div class="statistic">
      <div class="value">{{ $products->count() }}</div>
      <div class="label">Different Products Sold</div>
    </div>
    <div class="statistic">
      <div class="value">{{ $ast }}</div>
      <div class="label">Total Products Sold</div>
    </div>
    <div class="statistic">
      <div class="value">$ {{ number_format($pt, 2, '.', ',') }}</div>
      <div class="label">Revenue</div>
    </div>
  </div>

  <div class="ui horizontal divider header">Details</div>

  <table class="ui table">
    <thead>
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Amount Sold</th>
        <th>Sales</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $amountSoldTotal = 0; // Final sum of all the products sold
        $productsTotal = 0; // Final sum of the product sold
        $salesTotal = 0; // Final sum of the sale total field
      ?>
      @foreach ($products as $product)
        @if ($product->sales->count() > 0)
        <tr>
          <td>
            <div class="ui list">
              <div class="item">
                <img class="ui avatar image" src="{{ $product->cover == '/default.png' ? $product->cover : Storage::url($product->cover) }}">
                <div class="content">
                  <div class="header">{{ $product->name }}</div>
                  <div class="description">
                    {{ $product->description }}
                    @if ($product->inventory)
                    <div class="ui black label" data-tooltip="Only {{ $product->stock }} in stock!" style="margin-right:0">
                      <i class="box icon"></i>
                      <div class="detail">{{ $product->stock }}</div>
                    </div>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </td>
          <td>$ {{ number_format($product->price, 2, '.', ',') }}</td>
          <td>{{ $product->sales->count() }}</td>
          <td>
            @foreach($product->sales->unique() as $sale)
              <a class="ui tiny header" href={{ route('admin.sales.show', $sale) }} target="_blank">
                Sale #{{ $sale->id }}
                <div class="sub header">
                  {{ $sale->created_at->format('l, F j, Y \a\t g:i A') }}
                  ($ {{ number_format($sale->subtotal, 2, '.', ',') }})
                </div>
              </a>
            @endforeach
          </td>
          <td>
            <div class="ui tiny header">
              $ {{ number_format($product->sales->count() * $product->price, 2, '.', ',') }}
              <div class="sub header">($ {{ number_format($product->sales->unique()->sum('subtotal'), 2, '.', ',') }})</div>
            </div>
          </td>
        </tr>
        @endif
        <?php
          $amountSoldTotal += $product->sales->count();
          $salesTotal += $product->sales->unique()->sum('subtotal');
          $productsTotal += $product->sales->count() * $product->price;
        ?>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="2"></th>
        <th>
          {{ $amountSoldTotal }}
        </th>
        <th></th>
        <th colspan="2">
          <div class="ui tiny header">
            $ {{ number_format($productsTotal, 2, '.', ',') }}
            <div class="sub header">($ {{ number_format($salesTotal, 2, '.', ',') }})</div>
          </div>
        </th>
      </tr>
    </tfoot>
  </table>

@endsection
