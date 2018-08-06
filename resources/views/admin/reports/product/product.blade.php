@extends('layout.report')

@section('title', "Product Report - {$product->name}")

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

  <?php
    $totalProducts = 0;
    $totalCost = 0;
  ?>

  <div class="ui icon right floated buttons" style="margin-bottom:5rem">
    <div onclick="window.print()" class="ui black button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui red button"><i class="close icon"></i></div>
  </div>

  <img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <div class="ui center aligned icon header" style="margin-top:8px">
    <div class="content">Product Report - {{ $product->name  }}</div>
    <div class="sub header">
      {{ Date::parse($start)->format('l, F j, Y') }} | {{ Date::parse($end)->format('l, F j, Y') }}
    </div>
  </div>

  <h4 class="ui header">
    {{ Date::now()->format('l, F j, Y \a\t g:i A') }}
  </h4>

  <div class="ui items">
    <div class="item">
      <div class="image">
        <img src="{{ $product->cover == '/default.png' ? $product->cover : Storage::url($product->cover) }}">
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
          <p><i class="pencil icon"></i>{{ $product->created_at->format('l, F j, Y \a\t g:i A') }}</p>
          <p><i class="edit icon"></i>{{ Date::parse($product->updated_at)->format('l, F j, Y \a\t g:i A') }}</p>
        </div>
        <div class="meta">
          <p><i class="info circle icon"></i> {{ $product->description }}</p>
        </div>
      </div>
    </div>
  </div>

  <table class="ui table">
    <thead>
      <tr>
        <th>Sale</th>
        <th>Date</th>
        <th>Cashier</th>
        <th>Amount Sold</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($product->sales->where('created_at', '>=', $start)->where('created_at', '<=', $end)->unique() as $sale)
        <?php
          $totalProducts += $sale->products->where('id', $product->id)->count();
          $totalCost += $sale->products->where('id', $product->id)->count() * $product->price;
        ?>
        <tr>
          <td>{{ $sale->id }}</td>
          <td>{{ $sale->created_at->format('l, F j, Y \a\t g:i A') }}</td>
          <td><i class="user circle icon"></i> {{ $sale->creator->firstname }}</td>
          <td>{{ $sale->products->where('id', $product->id)->count() }}</td>
          <td>
            $ {{ number_format($sale->products->where('id', $product->id)->count() * $product->price, 2, '.', ',') }}
            ($ {{ $sale->total }})
          </td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3"></th>
        <th>
          {{ $totalProducts }}
        </th>
        <th>
          <div class="ui tiny header">
            $ {{ number_format($totalCost, 2, '.', ',') }}
            <div class="sub header">
              ($ {{ number_format($product->sales->where('created_at', '>=', $start)->where('created_at', '<=', $end)->unique()->sum('subtotal'), 2, '.', ',') }})
            </div>
          </div>
        </th>
      </tr>
    </tfoot>
  </table>

@endsection
