@extends('layout.report')

@section('title', $member->users[0]->firstname . ' ' . $member->users[0]->lastname.'\'s Membership Receipt')

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

  <div class="ui icon right floated buttons">
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

  <div class="ui clearing basic segment" style="padding:0 0 0 0">
    <h4 class="ui right floated header">
      Sale # {{ $sale->id }}
    </h4>

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
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
        @foreach($member->users as $key => $user)
        <tr>
          <td>
            <h4 class="ui header">
              {{ $member->id }}
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
          <td>
            @if ($key != 0)
              $ 0.00
            @else
              $ {{ number_format($member->type->price, 2) }}
            @endif
          </td>
        </tr>
        @endforeach
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>
          <table class="ui very basic compact collapsing unstackable table" style="margin-left:auto; margin-right:0; width:auto">
            <tbody>
              <tr>
                <td class="right aligned"><strong>Subtotal</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Tax</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Total</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Amount Paid</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Change</strong></td>
              </tr>
              <tr>
                <td class="right aligned"><strong>Balance</strong></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td>
          <table class="ui very basic compact unstackable table">
            <tbody>
              <tr>
                <td>$ {{ number_format($sale->subtotal, 2) }}</td>
              </tr>
              <tr>
                <td>$ {{ number_format($sale->tax, 2) }}</td>
              </tr>
              <tr>
                <td>$ {{ number_format($sale->payments[0]->total, 2) }}</td>
              </tr>
              <tr>
                <td style="color:#cf3534"><strong>-$ {{ number_format($sale->payments[0]->tendered, 2) }}</strong></td>
              </tr>
              <tr>
                <td>
                  <?php
                    $total = number_format($sale->payments[0]->total, 2);
                    $paid = number_format($sale->payments[0]->tendered, 2);
                    $change = number_format($sale->payments[0]->change_due, 2);

                    $balance = $total - ($paid - $change);

                    echo  '$ ' . number_format($change, 2);
                  ?>
                </td>
              </tr>
              <tr>
                <td><strong>{{ '$ ' . number_format($balance, 2) }}</strong></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>

  {!! \Illuminate\Mail\Markdown::parse(App\Setting::find(1)->membership_text) !!}

  <h4 class="ui center aligned header">
    <div class="content">
      {{ App\Setting::find(1)->organization }} <br /> {{ App\Setting::find(1)->address }}
      <div class="sub header">
        <i class="phone icon"></i>{{ App\Setting::find(1)->phone }} |
        <i class="at icon"></i>{{ App\Setting::find(1)->email }} |
        <i class="globe icon"></i><a href="http://{{ App\Setting::find(1)->website }}" target="_blank">{{ App\Setting::find(1)->website }}</a> | <i class="sun icon"></i>Astral
      </div>
    </div>
  </h4>

@endsection
