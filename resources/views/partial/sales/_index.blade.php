@if (!isset($sales) || count($sales) > 0)

<br />

<table class="ui selectable striped single line very compact table">
  <thead>
    <tr>
      <th>Sale #</th>
      <th>Customer</th>
      <th>Total</th>
      <th>Balance</th>
      <th>Status</th>
      <th>Created by</th>
      <th>Created on</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sales as $sale)
      @if($sale->refund)
        <tr class="negative">
      @else
        <tr>
      @endif
        <td><h3 class="ui center aligned header">{{ $sale->id }}</h3></td>
        <td>
          <h4 class="ui header">
            @if ($sale->customer->firstname == "Walk-up" or $sale->customer->firstname == $sale->organization->name)
              {{ $sale->customer->firstname }}
            @else
              @if ($sale->sell_to_organization)
                {{ $sale->customer->fullname }}
                @if ($sale->organization->id != 1)
                <div class="sub header">
                  {{ $sale->organization->name }}
                </div>
                @endif
              @else
                {{ $sale->customer->fullname }}
              @endif

            @endif
          </h3>
        </td>
        <td>$ {{ number_format($sale->total, 2) }}</td>
        <td>
          $ {{  number_format( $sale->total - ($sale->payments->sum('tendered') - $sale->payments->sum('change_due')) , 2) }}
        </td>
        <td>
          @if ($sale->refund)
            <span class="ui red label"><i class="reply icon"></i>refund</span>
          @else
            @if ($sale->status == 'complete')
              <span class="ui green label"><i class="checkmark icon"></i>
            @elseif ($sale->status == 'no show')
              <span class="ui orange label"><i class="thumbs outline down icon"></i>
            @elseif ($sale->status == 'open')
              <span class="ui violet label"><i class="unlock icon"></i>
            @elseif ($sale->status == 'tentative')
              <span class="ui yellow label"><i class="help icon"></i>
            @elseif ($sale->status == 'canceled')
              <span class="ui red label"><i class="remove icon"></i>
            @else
              <span class="ui label">
            @endif
            {{ $sale->status }}</span>
          @endif
        </td>
        <td><i class="user circle icon"></i>{{ $sale->creator->firstname }}</td>
        <td>{{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }} ({{ Date::parse($sale->created_at)->diffForHumans() }})</td>
        <td>
          <div class="ui icon buttons">
            @if (($sale->customer->membership_id == 1))
              <a href="{{ route('admin.sales.show', $sale) }}" class="ui secondary button"><i class="eye icon"></i></a>
              <a href="{{ route('admin.sales.edit', $sale) }}" class="ui primary button"><i class="edit icon"></i></a>
            @endif
            <div class="ui icon top left pointing dropdown secondary button">
              <i class="copy icon"></i>
              <div class="menu">
                @if ($sale->events->count() > 0)
                  @if ($sale->status != "canceled")
                    <a class="item" target="_blank" href="{{ route('admin.sales.confirmation', $sale) }}">Reservation Confirmation</a>
                    <a class="item" target="_blank" href="{{ route('admin.sales.invoice', $sale) }}">Invoice</a>
                    <a class="item" target="_blank" href="{{ route('admin.sales.receipt', $sale) }}">Receipt</a>
                  @else
                    <a class="item" target="_blank" href="{{ route('admin.sales.cancelation', $sale) }}">Cancelation Receipt</a>
                  @endif
                @else
                  <a class="item" href="{{ route('cashier.members.receipt', $sale->customer->member) }}" target="_blank">Membership Receipt</a>
                @endif

              </div>
            </div>

          </div>
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
