@extends('layout.report')

@section('title', $member->users[0]->firstname . ' ' . $member->users[0]->lastname.'\'s Membership Receipt')

@section('content')

  <style>
    @media print {
      .ui.icon.buttons {
        display: none !important;
      }
    }
  </style>

<div class="ui icon buttons">
  <div onclick="window.print()" class="ui primary button"><i class="print icon"></i></div>
  <div onclick="window.close()" class="ui secondary button"><i class="close icon"></i></div>
</div>

<img src="{{ asset(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

<h2 class="ui center aligned icon header" style="margin-top:8px">
  <div class="content">Membership Receipt</div>
</h2>

<h4 class="ui header">
  {{ Date::now()->format('l, F j, Y') }}
</h4>

<h4 class="ui header">
  {{ $member->users[0]->firstname . ' ' . $member->users[0]->lastname }} <br />
  {{ $member->users[0]->address }} </br>
  {{ $member->users[0]->city }}, {{ $member->users[0]->state }} {{ $member->users[0]->zip }}
</h4>

<p>Dear {{ $member->users[0]->firstname . ' ' . $member->users[0]->lastname }},</p>

<p>
  Thank you very much for purchasing a membership at the {{ App\Setting::find(1)->organization }}.
  We are pleased to confirm your membership as follows:
</p>

<table class="ui very basic unstackable table">
  <thead>
    <tr>
      <th>Member #</th>
      <th>Name</th>
      <th>Start Date</th>
      <th>Expiration Date</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      @foreach($member->users as $user)
      <td>
        <h4 class="ui header">
          {{ $member->id }}
        </h4>
      </td>
      <td>
        <h4 class="ui header">
          <div class="content">
            {{ $member->users[0]->firstname . ' ' . $member->users[0]->lastname }}
            <div class="sub header">
              {{ $member->type->name }}
            </div>
          </div>
        </h4>
      </td>
      <td>{{ Date::parse($member->start)->format('l, F j, Y') }}</td>
      <td>{{ Date::parse($member->end)->format('l, F j, Y') }}</td>
      <td>$ {{ number_format($member->type->price, 2) }}</td>
      @endforeach
    </tr>
  </tbody>
  <?php
    $sale = App\Sale::where('customer_id', $member->users[0]->id)->where('subtotal', $member->type->price)->get();
    $sale = $sale[count($sale) - 1]
  ?>
  <tfoot>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><strong>Subtotal</strong></td>
      <td>$ {{ number_format($sale->subtotal, 2) }}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><strong>Tax</strong></td>
      <td>$ {{ number_format($sale->tax, 2) }}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><strong>Total</strong></td>
      <td>$ {{ number_format($sale->payments[0]->total, 2) }}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><strong>Amount Paid</strong></td>
      <td>$ {{ number_format($sale->payments[0]->tendered, 2) }}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><strong>Change</strong></td>
      <td>$ {{ number_format($sale->payments[0]->change_due, 2) }}</td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td><strong>Balance</strong></td>
      <td>
        <?php
          $total = number_format($sale->payments[0]->total, 2);
          $paid = number_format($sale->payments[0]->tendered, 2);
          $change = number_format($sale->payments[0]->change_due, 2);

          $balance = $total - ($paid - $change);

          echo  '$ ' . number_format($balance, 2);
        ?>
      </td>
    </tr>
  </tfoot>
</table>

{!! \Illuminate\Mail\Markdown::parse(App\Setting::find(1)->membership_text) !!}

<h4 class="ui center aligned header">
  <div class="content">
    {{ App\Setting::find(1)->organization }} <br /> {{ App\Setting::find(1)->address }}
    <div class="sub header">
      {{ App\Setting::find(1)->phone }} - {{ App\Setting::find(1)->email }} - {{ App\Setting::find(1)->website }}
    </div>
  </div>
</h4>

@endsection
