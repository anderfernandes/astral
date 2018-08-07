@extends('layout.report')

@section('title', "Product Report - {$productType->name}")

@section('content')
  <?php
    $revenue = 0;
    $sold = 0;
  ?>

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
    <div class="content">Product Type Report - {{ $productType->name  }}</div>
    <div class="sub header">
      {{ Date::parse($start)->format('l, F j, Y') }} | {{ Date::parse($end)->format('l, F j, Y') }}
    </div>
  </div>

  <h4 class="ui header">
    {{ Date::now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  <div class="ui horizontal divider header">Overview</div>

  <?php

    foreach (App\Sale::where('status', 'complete')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->get() as $sale)
    {
      $sold += $sale->products->where('type_id', $productType->id)->count();

      // Looping through the products in each sale within that date/time range
      foreach ($sale->products->where('type_id', $productType->id)->unique() as $product)
      {

        $revenue += $product->price * $sale->products->where('type_id', $productType->id)->count();
      }
    }

  ?>

  <div class="ui mini statistics">
    <div class="statistic">
      <div class="value">{{ $productType->products->count() }}</div>
      <div class="label">Products</div>
    </div>
    <div class="statistic">
      <div class="value">{{ $sold }}</div>
      <div class="label">Sold</div>
    </div>
    <div class="statistic">
      <div class="value">$ {{ number_format($revenue, 2, '.', ',') }}</div>
      <div class="label">Revenue</div>
    </div>
  </div>

  <div class="ui horizontal divider header">Products</div>

  <div class="ui celled list">
    @foreach ($productType->products as $product)
      <div class="item">
        <img src="{{ $product->cover == '/default.png' ? $product->cover : Storage::url($product->cover) }}" class="ui avatar image">
        <div class="content">
          <div class="header">
            {{ $product->name }}
            <div class="ui tiny green tag label" style="margin-right:0">$ {{ number_format($product->price, 2, '.', ',')}}</div>
            @if ($product->inventory)
              <div class="ui tiny {{ $product->stock < 10 ? 'red' : 'black' }} label" {!! $product->stock < 10 ? "data-tooltip='Only $product->stock in stock!' data-inverted=''" : ""!!} style="margin-right:0">
                <i class="box icon"></i>
                <div class="detail">{{ $product->stock }}</div>
              </div>
            @endif
          </div>
          {{ $product->description }}
        </div>
      </div>
    @endforeach
  </div>

  <div class="ui horizontal divider header">Sales</div>

  <table class="ui table">
    <thead>
      <tr>
        <th>Sale</th>
        <th>Date</th>
        <th>Cashier</th>
        <th>Sold</th>
        <th>Revenue</th>
      </tr>
    </thead>
    @foreach (App\Sale::where('status', 'complete')->where('created_at', '>=', $start)->where('created_at', '<=', $end)->get() as $sale)
      @if ($sale->products->count() > 0)
        <tr>
          <td>
            <a href="{{ route('admin.sales.show', $sale) }}" target="_blank" class="ui tiny header">#{{ $sale->id }}</a>
          </td>
          <td>{{ $sale->created_at->format('l, F j, Y \a\t g:i A') }}</td>
          <td><i class="user circle icon"></i>{{ $sale->creator->firstname }}</td>
          <td>

            @foreach ($sale->products->where('type_id', $productType->id)->unique() as $product)
              <div class="ui black label">
                {{ $sale->products->where('id', $product->id)->count() }}
                <div class="detail">{{ $product->name }}</div>
              </div>
            @endforeach

            ({{ $sale->products->where('type_id', $productType->id)->count() }})

          </td>
          <td>
            $
            <?php
              $subRevenue = 0;
              foreach($sale->products->where('type_id', $productType->id)->unique() as $product)
              {
                $subRevenue += $sale->products->where('id', $product->id)->count() * $product->price;
              }
              echo number_format($subRevenue, 2, '.', ',');
            ?>

          </td>
        </tr>
      @endif
    @endforeach
    <tfoot>
      <tr>
        <th colspan="3" class="right aligned"><strong>Total:</strong></th>
        <th>{{ $sold }}</th>
        <th><div class="ui tiny header">$ {{ number_format($revenue, 2, '.', ',') }}</div></th>
      </tr>
    </tfoot>
  </table>

@endsection
