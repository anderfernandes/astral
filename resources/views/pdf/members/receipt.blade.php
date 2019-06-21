@extends('layout.pdf')

@section('title', "Astral - " . App\Setting::find(1)->organization . " - Membership Receipt - Member #$sale->id")

@section('content')

  <center>
    <img src="{{ (App\Setting::find(1)->logo == '/logo.png') ? substr(App\Setting::find(1)->logo, 1) : substr(Storage::url(App\Setting::find(1)->logo), 1) }}" style="width:35px; height:auto">
    <h3>Membership Receipt</h3>
  </center>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">

    <h4 class="ui left floated header" style="text-align:left">
      {{ Date::now()->format('l, F j, Y') }}
    </h4>

    <h4 class="ui right floated header">
      Sale # {{ $sale->id }}
    </h4>

  </div>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">
    <h4 class="ui left floated header">
      {{ $member->users[0]->fullname }}<br />
      {{ $member->users[0]->address }} </br>
      {{ $member->users[0]->city }}, {{ $member->users[0]->state }} {{ $member->users[0]->zip }}
    </h4>
  </div>

  <p>Dear {{ $member->users[0]->fullname }},</p>

  <p>
    Thank you very much for purchasing a membership at the {{ App\Setting::find(1)->organization }}.
    We are pleased to confirm your membership as follows:
  </p>

  <table class="ui very basic compact unstackable table">
    <thead>
      <tr>
        <th>Member #</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>Expiration Date</th>
        <th></th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      @foreach($member->users as $key => $user)
      <tr>
        <td>
          <h4 class="ui header">
            {{ $member->number }}
          </h4>
        </td>
        <td>
          <h4 class="ui header">
            <div class="content">
              {{ $user->fullname }}
              <div class="sub header">
                {{ $member->type->name }}
                @if ($key != 0)
                  (Secondary)
                @endif
              </div>
            </div>
          </h4>
        </td>
        <td>{{ Date::parse($member->start)->format('l, F j, Y') }}</td>
        <td>{{ Date::parse($member->end)->format('l, F j, Y') }}</td>
        <td class="right aligned">$</td>
        <td class="right aligned">
          @if ($key != 0)
            0.00
          @else
            {{ number_format($member->type->price, 2) }}
          @endif
        </td>
      </tr>
      @endforeach
      <tr>
        <td colspan="4" class="right aligned"><strong>Subtotal</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($sale->subtotal, 2) }}</td>
      </tr>
      <tr>
        <td colspan="4" class="right aligned" style="border-top: 0"><strong>Tax</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($sale->tax, 2) }}</td>
      </tr>
      <tr>
        <td colspan="4" class="right aligned" style="border-top: 0"><strong>Total</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($sale->payments[0]->total, 2) }}</td>
      </tr>
      <tr>
        <td colspan="4" class="right aligned" style="border-top: 0"><strong>Amount Paid</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned" style="color:#cf3534"><strong>{{ number_format($sale->payments[0]->tendered * - 1, 2) }}</strong></td>
      </tr>
      <tr>
        <td colspan="4" class="right aligned" style="border-top: 0"><strong>Change</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">
          <?php
            $total = number_format($sale->payments[0]->total, 2);
            $paid = number_format($sale->payments[0]->tendered, 2);
            $change = number_format($sale->payments[0]->change_due, 2);

            $balance = $total - ($paid - $change);

            echo  number_format($change, 2);
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="4" style="border-top: 0" class="right aligned"><strong>Balance</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned"><strong>{{ number_format($balance, 2) }}</strong></td>
      </tr>
    </tbody>
  </table>

  {!! \Illuminate\Mail\Markdown::parse(App\Setting::find(1)->invoice_text) !!}

  <p>
    Thank you very much for choosing us. We sincerely appreciate your patronage and hope you enjoy our shows.
  </p>

  <p>Sincerely,</p>

  <p>Visitor Services <br /> {{ App\Setting::find(1)->organization }}</p>

  <h4 class="ui center aligned header">
    <div class="content">
      <center>{{ App\Setting::find(1)->organization }} <br /> {{ App\Setting::find(1)->address }}</center>

      <div class="sub header">
        <center>
          {{ App\Setting::find(1)->phone }} |
          {{ App\Setting::find(1)->email }} |
          <a href="http://{{ App\Setting::find(1)->website }}" target="_blank">{{ App\Setting::find(1)->website }}</a> |
          <img src="astral-logo-dark.png" style="width:10px"> Astral
        </center>
      </div>
    </div>
  </h4>

@endsection
