@extends('layout.report')

@section('title', $member->primary->firstname . ' ' . $member->primary->lastname.'\'s Membership Receipt')

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

  <div class="ui icon right floated buttons" style="margin-bottom:2rem">
    <a href="{{ route('admin.members.receipt', $member)}}?format=pdf" target="_blank" class="ui basic black button"><i class="file pdf outline icon"></i></a>
    <div onclick="window.print()" class="ui black button"><i class="print icon"></i></div>
    <div onclick="window.close()" class="ui red button"><i class="close icon"></i></div>
  </div>

  <img src="{{ (App\Setting::find(1)->logo == '/logo.png') ? App\Setting::find(1)->logo : Storage::url(App\Setting::find(1)->logo) }}" alt="" class="ui centered mini image">

  <div class="ui center aligned big header" style="margin-top:8px; margin-bottom: 0">
    <div class="content">Membership Receipt</div>
  </div>

  <h4 class="ui header">
    {{ now()->format('l, F j, Y') }}
  </h4>

  <div class="ui clearing basic segment" style="padding:0 0 0 0">
    <h4 class="ui right floated header">
      Sale # {{ $sale->id }}
    </h4>

    <h4 class="ui left floated header">
      {{ $member->primary->fullname }}<br />
      {{ $member->primary->address }} </br>
      {{ $member->primary->city }}, {{ $member->primary->state }} {{ $member->primary->zip }}
    </h4>
  </div>

  <p>Dear {{ $member->primary->fullname }},</p>

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
      <tr>
        <td>
          <h4 class="ui header">
            {{ $member->number }}
          </h4>
        </td>
        <td>
          <h4 class="ui header">
            <div class="content">
              {{ $member->primary->fullname }}
              <div class="sub header">
                {{ $member->type->name }}
              </div>
            </div>
          </h4>
        </td>
        <td>{{ Date::parse($member->start)->format('l, F j, Y') }}</td>
        <td>{{ Date::parse($member->end)->format('l, F j, Y') }}</td>
        <td class="right aligned">$</td>
        <td class="right aligned">{{ number_format($member->type->price, 2) }}</td>
      </tr>
      @foreach($member->secondaries as $secondary)
      <tr>
        <td>
          <h4 class="ui header">
            {{ $member->number }}
          </h4>
        </td>
        <td>
          <h4 class="ui header">
            <div class="content">
              {{ $secondary->fullname }}
              <div class="sub header">
                {{ $member->type->name }} (Secondary)
              </div>
            </div>
          </h4>
        </td>
        <td>{{ Date::parse($member->start)->format('l, F j, Y') }}</td>
        <td>{{ Date::parse($member->end)->format('l, F j, Y') }}</td>
        <td class="right aligned">$</td>
        <td class="right aligned">
          @if ($loop->iteration <= $member->type->max_secondaries)
            {{ number_format(0, 2) }}
          @else
            {{ number_format($member->type->secondary_price, 2) }}
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
        <td class="right aligned">{{ number_format($sale->payments->first()->total, 2) }}</td>
      </tr>
      <tr>
        <td colspan="4" class="right aligned" style="border-top: 0"><strong>Amount Paid</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned" style="color:#cf3534"><strong>{{ number_format($sale->payments->first()->tendered * - 1, 2) }}</strong></td>
      </tr>
      <tr>
        <td colspan="4" class="right aligned" style="border-top: 0"><strong>Change</strong></td>
        <td class="right aligned">$</td>
        <td class="right aligned">
          <?php
            $total = number_format($sale->payments->first()->total, 2);
            $paid = number_format($sale->payments->first()->tendered, 2);
            $change = number_format($sale->payments->first()->change_due, 2);

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

  {!! \Illuminate\Mail\Markdown::parse(App\Setting::find(1)->membership_text) !!}

  <h4 class="ui center aligned header">
    <div class="content">
      {{ App\Setting::find(1)->organization }} <br /> {{ App\Setting::find(1)->address }}
      <div class="sub header">
        <i class="phone icon"></i>{{ App\Setting::find(1)->phone }} |
        <i class="at icon"></i>{{ App\Setting::find(1)->email }} |
        <i class="globe icon"></i><a href="http://{{ App\Setting::find(1)->website }}" target="_blank">{{ App\Setting::find(1)->website }}</a> |
        <img src="/astral-logo-dark.png" style="width:10px"> Astral
      </div>
    </div>
  </h4>

@endsection
