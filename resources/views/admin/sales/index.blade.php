@extends('layout.admin')

@section('title', 'Sales')

@section ('subtitle', 'Manage Sale')

@section ('icon', 'dollar')

@section('content')

  <a class="ui secondary button" href="{{ route('admin.sales.create') }}">
    <i class="plus icon"></i> New Sale
  </a>
  <div class="ui right icon input">
    <input type="text" placeholder="Sale Number">
    <i class="search link icon"></i>
  </div>
  <select name="type" id="" class="ui dropdown">
    <option value="">All Types</option>
    <option value="Planetarium">Cash</option>
    <option value="Laser Light">Credit Card</option>
  </select>
</select>

@if (!isset($sales) || count($sales) > 0)
<br /><br />
<table class="ui selectable striped celled table">
  <thead>
    <tr>
      <th>Sale #</th>
      <th>Customer</th>
      <th>Total</th>
      <th>Status</th>
      <th>Created at</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($sales as $sale)
      <tr>
        <td><h3 class="ui center aligned header">{{ $sale->id }}</h3></td>
        @if ($sale->customer->firstname == "Walk-up")
        <td>{{ $sale->customer->firstname }}</td>
        @else
        <td>{{ $sale->customer->firstname }} {{ $sale->customer->firstname }}</td>
        @endif

        <td>$ {{ number_format($sale->total, 2) }}</td>
        <td>
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
        </td>
        <td>{{ Date::parse($sale->created_at)->format('l, F j, Y \a\t g:i A') }}</td>
        <td>
          <div class="ui buttons">
            <a href="{{ route('admin.sales.show', $sale) }}" class="ui secondary button"><i class="book icon"></i>View</a>
            <div class="ui primary button"><i class="pencil icon"></i>Edit</div>
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
      <p>It looks like there are no sales in the database.</p>
    </div>
  </div>
@endif

@endsection
