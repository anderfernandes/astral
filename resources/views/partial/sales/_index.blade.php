<?php
  function getRowBgColor($sale_status)
  {
    $color = null;

    switch($sale_status)
    {
      case 'complete' : $color = '#21ba45'; break;
      case 'confirmed': $color = '#ffffff; color: #21ba45'; break;
      case 'open'     : $color = '#6435c9'; break;
      case 'canceled' : $color = '#cf3534'; break;
      case 'tentative': $color = '#fbbd08'; break;
      case 'no show'  : $color = '#f2851c'; break;
    }

    return $color;
  }
?>

@if (!isset($sales) || count($sales) > 0)

<br />

<table class="ui inverted very compact selectable table">
  <thead>
    <tr>
      <th></th>
      <th>#</th>
      <th>Customer</th>
      <th>Total</th>
      <th>Balance</th>
      <th>Status</th>
      <th>Created by</th>
      <th>Created on</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sales as $sale)
      @if($sale->refund)
      <tr class="negative">
      @else
      <tr style="background-color: {{ getRowBgColor($sale->status) }}">
      @endif
        <td>
          <div class="ui left pointing dropdown">
            <i class="ellipsis horizontal icon"></i>
            <div class="menu">
              <div class="header">
                Options
              </div>
              <a href="{{ route('admin.sales.show', $sale) }}" class="item">
                <i class="eye icon"></i> View Sale
              </a>
              <a href="{{ route('admin.sales.edit', $sale) }}" class="item">
                <i class="edit icon"></i> Edit Sale
              </a>
              <div class="divider"></div>
              <div class="header">
                Documents
              </div>
              @if ($sale->events->count() > 0)
                @if ($sale->status != "canceled")
                  <a class="item" target="_blank" href="{{ route('admin.sales.confirmation', $sale) }}">
                    <i class="file icon"></i>
                    Reservation Confirmation
                  </a>
                  <a class="item" target="_blank" href="{{ route('admin.sales.invoice', $sale) }}">
                    <i class="file icon"></i>
                    Invoice
                  </a>
                  <a class="item" target="_blank" href="{{ route('admin.sales.receipt', $sale) }}">
                    <i class="file icon"></i>
                    Receipt
                  </a>
                  <a class="item" target="_blank" href="{{ route('admin.sales.tickets', $sale) }}">
                    <i class="ticket icon"></i>
                    Tickets
                  </a>
                @else
                  <a class="item" target="_blank" href="{{ route('admin.sales.cancelation', $sale) }}">
                    <i class="file icon"></i>
                    Cancelation Receipt
                  </a>
                @endif
              @else
                <a class="item" href="{{ route('admin.members.receipt', $sale->customer->member) }}" target="_blank">Membership Receipt</a>
              @endif
            </div>
          </div>
        </td>
        <td>
          <h3 class="ui {{ $sale->refund ? 'refund' : 'inverted' }} {{ $sale->status == "confirmed" ? "confirmed" : null }} center aligned header">
            {{ $sale->id }}
          </h3>
        </td>
        <td>
          <h4 class="ui {{ $sale->refund ? 'refund' : 'inverted' }} {{ $sale->status == "confirmed" ? "confirmed" : null }} header">
            @if ($sale->customer->firstname == "Walk-up" or $sale->customer->firstname == $sale->organization->name)
              {{ $sale->customer->firstname }}
            @else
              {{ $sale->customer->fullname }}
              @if ($sale->organization->id != 1)
              <div class="sub {{ $sale->refund ? "refund " : "inverted" }} {{ $sale->status == "confirmed" ? "confirmed" : null }} header">
                {{ $sale->organization->name }}
              </div>
              @endif
            @endif
          </h3>
        </td>
        <td>
          $ {{ number_format($sale->total, 2) }}
        </td>
        <td>
          $ {{  number_format( $sale->total - ($sale->payments->sum('tendered') - $sale->payments->sum('change_due')) , 2) }}
        </td>
        <td>
          @if ($sale->refund)
              <i class="reply icon"></i>
          @else
            @if ($sale->status == 'complete')
              <i class="checkmark icon"></i>
            @elseif ($sale->status == 'no show')
              <i class="thumbs outline down icon"></i>
            @elseif ($sale->status == 'open')
              <i class="unlock icon"></i>
            @elseif ($sale->status == 'tentative')
              <i class="help icon"></i>
            @elseif ($sale->status == 'canceled')
              <i class="remove icon"></i>
            @elseif ($sale->status == 'confirmed')
              <i class="thumbs up icon"></i>
            @endif
          @endif
        </td>
        <td>
          <i class="user circle icon"></i>
          {{ $sale->creator->id == 1 ? "System" : $sale->creator->firstname }}
        </td>
        <td>
          {{ $sale->created_at->format('l, F j, Y \a\t g:i A') }} <br />
          ({{ $sale->created_at->diffForHumans() }})
        </td>
      </tr>
    @endforeach
  </tbody>

</table>
@else
  <div class="ui info icon message">
    <i class="info circle icon"></i>
    <i class="close icon"></i>
    <div class="content">
      <div class="header">
        No sales!
      </div>
      <p>It looks like we couldn't find what you were looking for or there are no sales in the database.</p>
    </div>
  </div>
@endif

<br /><br />

<div class="ui centered grid">
  {{ $sales->appends(app('request')->input())->links('vendor.pagination.semantic-ui') }}
</div>

<br /> <br />

<style>
  .refund                { color: #9f3a38 !important }
  .confirmed             { color: #21ba45 !important }
  .sub.header.refund     { color: inherit !important }
  .sub.header.confirmed  { color: inherit !important }
  tr:hover td .refund    { color: #ffffff !important }
  tr:hover td .confirmed { color: #ffffff !important }
</style>
