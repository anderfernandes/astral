@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->fullname)

@section('icon', 'dashboard')

@section('content')

@include('admin.announcements._announcement')

<style>
  .pusher {
    background: linear-gradient(rgba(253,254,255,1), rgba(253,254,255,0.5)), url('{{ App\Setting::find(1)->cover }}') !important;
    background-size: cover !important;
  }

</style>

<?php

function getSalesTotals($day)
{
  $start = Date::parse($day)->startOfDay()->toDateTimeString();
  $end = Date::parse($day)->endOfDay()->toDateTimeString();

  $dailyTendered = \App\Payment::where([
    ['created_at','>=', $start],
    ['created_at','<=', $end]
    ])->sum('tendered');

  $dailyChange = \App\Payment::where([
    ['created_at','>=', $start],
    ['created_at','<=', $end]
    ])->sum('change_due');

  $daily = number_format($dailyTendered - $dailyChange, 2, '.', '');

  return $daily;
}

function getAttendance($date) {
  $events = App\Event::whereDate('start', $date->format('Y-m-d'))->pluck('id');
  $tickets = App\Ticket::whereIn('event_id', $events)->count();
  return $tickets;
}

function getAttendanceByType($ticketTypeID) {
  $today = Date::today();
  $tickets = App\Ticket::where('created_at', '>=', $today->subDays(6)->toDateTimeString())
                        ->where('ticket_type_id', $ticketTypeID)
                        ->count();

  return $tickets;
}

?>

<div class="ui grid">

  <div class="eight wide computer sixteen wide mobile column">

    @if(str_contains(Auth::user()->role->permissions['dashboard'], "CRUD"))
    {{-- Overall Earnings --}}
    <div class="ui raised segment">
      <div class="ui dividing header">
        <i class="money icon"></i>
        <div class="content">
          Overall Earnings
          <div class="sub header">
            Last 7 Days
          </div>
        </div>
      </div>
      <div>
        <canvas height="200" id="earningsChart"></canvas>
      </div>
    </div>
    @endif

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "R"))
    {{-- Calendar --}}
    <div class="ui raised segment">
      <div class="ui two column grid">
        <div class="column">
          <div class="ui dividing header">
            <i class="calendar alternate icon"></i>
            <div class="content">
              Calendar
              <div class="sub header" id="calendar-title"></div>
            </div>
          </div>
        </div>
        <div class="column">
          <div class="ui secondary right floated dropdown labeled icon button">
            <i class="calendar alternate outline icon"></i>
            <span class="text">Sales</span>
            <div class="menu">
              <div onclick="toggleCalendar('events')" class="item">Events</div>
              <div onclick="toggleCalendar('sales')" class="active item">Sales</div>
            </div>
          </div>
          <div class="ui black right floated icon buttons" style="margin-bottom:0.5rem">
            <div onclick="$('#calendars').fullCalendar('prev'); setTitle()" class="ui button"><i class="left chevron icon"></i></div>
            <div onclick="$('#calendars').fullCalendar('today'); setTitle()" class="ui button"><i class="checked calendar icon"></i></div>
            <div onclick="$('#calendars').fullCalendar('next'); setTitle()" class="ui button"><i class="right chevron icon"></i></div>
          </div>
        </div>
      </div>
      <div id="calendars"></div>
    </div>
    @endif

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "CRUD"))
    {{-- Overview --}}
    <div class="ui horizontal raised segments">
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="film icon"></i>
            {{ App\Show::all()->count() - 1 }}
          </div>
          <div class="label">
            Shows
          </div>
        </div>
      </div>
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="users icon"></i>
            {{ App\User::all()->count() - 1 }}
          </div>
          <div class="label">
            Users
          </div>
        </div>
      </div>
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="university icon"></i>
            {{ App\Organization::all()->count() - 1 }}
          </div>
          <div class="label">
            Organizations
          </div>
        </div>
      </div>
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="address card icon"></i>
            {{ App\Member::all()->count() - 1 }}
          </div>
          <div class="label">
            Members
          </div>
        </div>
      </div>
      <div class="ui center aligned segment">
        <div class="ui small statistic">
          <div class="value">
            <i class="box icon"></i>
            {{ App\Product::all()->count() }}
          </div>
          <div class="label">
            Products
          </div>
        </div>
      </div>
    </div>
    @endif

    <?php

    $products = App\Product::where('inventory', true)->where('stock', '<=', 10)->get();

    ?>

    @if (str_contains(Auth::user()->role->permissions['products'], "CRUD"))
    {{-- Products --}}
    <div class="ui raised segment">
      <div class="ui dividing header">
        <i class="box icon"></i>
        <div class="content">
          Products
          <div class="sub header">
            Stock
          </div>
        </div>
      </div>
      <div class="ui list">
        @if ($products->count() > 0)
          @foreach ($products as $product)
          <div class="item">
            <img src="{{ $product->cover == '/default.png' ? $product->cover : Storage::url($product->cover) }}" class="ui avatar image">
            <div class="content">
              <a href="{{ route('admin.products.edit', $product) }}" target="_blank" class="header">
                {{ $product->name }}
                <div class="ui red label" data-tooltip="Only {{ $product->stock }} in stock!" style="margin-right:0">
                  <i class="box icon"></i>
                  <div class="detail">{{ $product->stock }}</div>
                </div>
              </a>
              <div class="description">{{ $product->description }}</div>
            </div>
          </div>
          @endforeach
        @else
        <div class="ui info icon message">
          <i class="info circle icon"></i>
          <div class="content">
            <div class="header">All products are on stock of 10 or more!</div>
            All products are on stock! Keep it up!
          </div>
        </div>
        @endif

      </div>
    </div>
    @endif

  </div>

  <div class="eight wide computer sixteen wide mobile column">

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "CRUD"))
    {{-- Attendance --}}
    <div class="ui raised segment">
      <div class="ui dividing header">
        <i class="child icon"></i>
        <div class="content">
          Attendance
          <div class="sub header">
            Last 7 Days
          </div>
        </div>
      </div>
      <div class="ui two column grid">
        <div class="column">
          <canvas height="200" id="attendanceChart"></canvas>
        </div>
        <div class="column">
          <canvas height="200" id="secondAttendanceChart"></canvas>
        </div>
      </div>
    </div>
    @endif

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "CRUD"))
    {{-- Feed --}}
    <div class="ui raised segment">
      <div class="ui small dividing header">
        <i class="feed icon"></i>
        <div class="content">
          Feed
          <div class="sub header">
            Latest Sales
          </div>
        </div>
      </div>
      <div class="ui relaxed list">
        <?php $lastSales = App\Sale::where('status', 'complete')->latest()->take(5)->get() ?>
        @foreach ($lastSales as $lastSale)
          {{-- MEMBERSHIP SALES HAVE NO TICKETS UNDER THEM!!! --}}
          @if ($lastSale->tickets->count() > 0)
          <div class="item">
            <i class="big user circle icon"></i>
            <div class="content">
              <div class="header">
                <a target="_blank" href="{{ route('admin.users.show', $lastSale->creator) }}" class="user">
                  {{ $lastSale->creator->firstname }}</a>
                  sold <a target="_blank" href="{{ route('admin.sales.show', $lastSale) }}"> {{ $lastSale->tickets->count() }}
                  @if ($lastSale->tickets->count() == 1)
                    ticket</a> to <a target="_blank" href="{{ route('admin.shows.show', $lastSale->events[0]->show) }}">{{ $lastSale->tickets[0]->event->show->name }}</a> <div class="ui black circular label">{{ $lastSale->tickets[0]->event->type->name }}</div>
                  @else
                    tickets</a> to <a target="_blank" href="{{ route('admin.shows.show', $lastSale->events[0]->show) }}">{{ $lastSale->tickets[0]->event->show->name }}</a> <div class="ui black circular label">{{ $lastSale->tickets[0]->event->type->name }}</div>
                  @endif
              </div>
              <div class="description">
                {{ Date::parse($lastSale->created_at)->ago() }}
              </div>
            </div>
          </div>
        @elseif ($lastSale->customer->role->name == "Member")
            <div class="item">
              <i class="big user circle icon"></i>
              <div class="content">
                <div class="header">
                  <a target="_blank" href="{{ route('admin.users.show', $lastSale->creator) }}">
                    {{ $lastSale->creator->firstname }}</a>
                    sold a
                    <a target="_blank" href="{{ route('admin.members.show', $lastSale->customer->member) }}">{{ $lastSale->customer->member->type->name }}</a>
                    to <a target="_blank" href="{{ route('admin.users.show', $lastSale->customer) }}">{{ $lastSale->customer->fullname }}</a>
                </div>
                <div class="description">
                  {{ Date::parse($lastSale->created_at)->ago() }}
                </div>
              </div>
            </div>
          @endif
        @endforeach
      </div>
    </div>
    @endif

    @if (str_contains(Auth::user()->role->permissions['dashboard'], "C"))
    {{-- Bulletin --}}
    <div class="ui raised segment">
      <div class="ui dividing header">
        <i class="comments outline icon"></i>
        <div class="content">
          Bulletin
          <div class="sub header">
          Open posts
          </div>
        </div>
      </div>
      <div class="ui relaxed divided list">
        @foreach (\App\Post::where('open', true)->latest()->take(5)->get() as $post)
          <div class="item">
            <i class="big user circle icon"></i>
            <div class="content">
              <div class="header">
                <a href="{{ route('admin.users.show', $post->author) }}" target="_blank">{{ $post->author->firstname }}</a>
                created a post <a href="{{ route('admin.posts.show', $post->id) }}" target="_blank">{{ $post->title }}</a>
                <div class="ui black label"><i class="tag icon"></i>{{ $post->category->name }}</div>
                @if ($post->sticky)
                  <div class="ui red label"><i class="info circle icon"></i> important</div>
                @endif
              </div>
              <div class="description"><i class="calendar outline alternate icon"></i>{{ Date::parse($post->created_at)->ago() }} | <i class="comments icon"></i>{{ $post->replies->count() }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
    @endif

  </div>
</div>

<div class="ui fullscreen modal" id="details"></div>

<script>

function fetchSales(calEvent, jsEvent, view) {
  fetch(`/api/sale/${calEvent.id}`)
    .then(response => response.json())
    .then(sale => {

      document.querySelector('#details').innerHTML = null

      var memos = ''

      if (sale.memos.length > 0) {
        sale.memos.forEach(function (memo)
        {
          memos +=
          `
          <div class="comment">
            <div class="avatar"><i class="user circle big icon"></i></div>
            <div class="content">
              <div class="author">
                ${memo.author.name}
                <div class="ui tiny black label">${memo.author.role}</div>
                <div class="metadata">
                  <span class="date">${moment(memo.created_at).calendar()}</span>
                </div>
              </div>
              <div class="text">
                ${memo.message}
              </div>
            </div>
          </div>
          `
        }
      )
    } else {
      memos =
      `
      <div class="ui info icon message">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">
            No Memos
          </div>
          <p>No one has left a memo for this event yet.</p>
        </div>
      </div>
      `
    }

      var dateFormat = 'dddd, MMMM D, YYYY [at] h:mm A'

      var getStatus = function() {

        switch(sale.status) {
          case `open`: return `<div class="ui violet label"><i class="unlock icon"></i>${sale.status}</div>`
        }

      }

      var header =
      `
      <i class="close icon"></i>
      <div class="ui header">
        <i class="dollar icon"></i>
        <div class="content">
          Sale #${sale.id} ${getStatus()}
          <div class="sub header">
            <a href="/admin/users/${sale.creator.id}" target="_blank" style="color:rgba(0,0,0,.4)">
              <i class="user circle icon"></i>
              <span class="detail">${sale.creator.name}</span>
            </a> |
            <i class="inbox icon"></i> ${sale.source} |
            <i class="pencil icon"></i> ${ moment(sale.created_at).format(dateFormat) }
            (${ moment(sale.updated_at).fromNow() }) |
            <i class="edit icon"></i> ${ moment(sale.updated_at).format(dateFormat) }
            (${ moment(sale.updated_at).fromNow() })
          </div>
        </div>
      </div>
      `

      var customer =
      `
      {{-- Customer Information Card --}}
      <div class="ui raised card">
        <div class="content">
          <div class="ui top attached black center aligned large label">
            <i class="user icon"></i> Customer Information
          </div>
          <a href="/admin/users/${sale.customer.id}" class="header" target="_blank">
            ${sale.customer.name}
          </a>
          ${sale.customer.organization.id != 1 ? `<div class="meta"><i class="university icon"></i> ${sale.customer.organization.name}</div>` : ``}
          <div class="meta"><i class="user icon"></i> ${sale.customer.role.name}</div>
          <div class="description"><i class="map marker alternate icon"></i> ${sale.customer.address}</div>
          <div class="description"><i class="phone icon"></i> ${sale.customer.phone}</div>
          <div class="description"><i class="at icon"></i> ${sale.customer.email}</div>
        </div>
      </div>
      `

      {{-- Organization --}}
      var organization =
      `
      {{-- Organization Information Card --}}
      <div class="ui raised card">
        <div class="content">
          <div class="ui top attached black center aligned large label">
            <i class="university icon"></i> Organization Information
          </div>
          <a href="/admin/organizations/${sale.organization.id}" class="header" target="_blank">
            ${sale.organization.name}
          </a>

          <div class="meta"><i class="user icon"></i> ${sale.organization.type}</div>
          <div class="description"><i class="map marker alternate icon"></i> ${sale.organization.address}</div>
          <div class="description"><i class="phone icon"></i> ${sale.organization.phone}</div>
        </div>
      </div>
      `
      {{-- Events --}}
      var events = ''

      if (sale.events.length > 0) {
        sale.events.forEach(function (ev)
        {
            var tickets = ''
            ev.tickets.forEach(function (ticket) {
              tickets +=
              `
              <div class="ui black label" style="margin-left:0">
                <i class="ticket icon"></i> ${ticket.quantity}
                <div class="detail">${ticket.name}</div>
              </div>
              `
            })

            events +=
              `
              <div class="item">
                <h3 class="ui header">
                  <img src="${ev.show.cover}" alt="" />
                  <div class="content">
                    <div class="sub header">
                      ${moment(ev.start).format(dateFormat)}
                      <div class="ui inverted circular label" style="background-color:${ev.color}">
                        ${ev.type}
                      </div>
                    </div>
                    <a href="/admin/events/${ev.id}" target="_blank">${ev.show.name}</a>
                    <div class="sub header">
                      ${tickets}
                    </div>
                  </div>
                </h3>
              </div>
              `
          }
        )
      }

      {{-- Products --}}
      var products = ''


      if (sale.products.length > 0) {
        sale.products.forEach(function (product) {
          products +=
          `
          <div class="item">
            <h3 class="ui header">
              <img src="${product.cover}" alt="" />
              <div class="content">
                <div class="sub header">
                  <div class="ui black label">
                    <i class="box icon"></i>${product.quantity}
                  </div>
                  <div class="ui black label">
                    <i class="dollar icon"></i>${parseFloat(product.price).toFixed(2)} each
                  </div>
                  <div class="ui circular blue label">
                    ${product.type}
                  </div>
                </div>
                <a href="/admin/products/${product.id}/edit" target="_blank">${product.name}</a>
              </div>
            </h3>
          </div>
          `
        })
      }

      var productsBox =
      `
      <div class="ui raised card">
        <div class="content">
        <div class="ui top attached black center aligned large label">
            <i class="box icon"></i> Extras
        </div>
        <div class="ui divided list">
            ${products}
        </div>
        </div>
      </div>

      `

      {{-- Grades --}}
      var grades = ''

      if (sale.grades.length > 0) {
        sale.grades.forEach(function (grade) {
          grades +=
          `
            <div class="ui black label">${grade.name}</div>
          `
        })
      }

      var gradesBox =
      `
      <div class="ui raised card">
        <div class="ui top attached black center aligned large label">
          <i class="book icon"></i> Grades
        </div>
        <div class="content">
          ${grades}
        </div>
      </div>
      `

      {{-- Payments --}}
      var payments = ''

      if (sale.payments.length > 0) {
        sale.payments.forEach(function (payment) {
          payments +=
          `
          <tr>
            <td><div class="ui header">${payment.id}</div></td>
            <td>${payment.method}</td>
            <td>${payment.paid}</td>
            <td>${payment.tendered}</td>
            <td>${moment(payment.date).format(dateFormat)}</td>
            <td>${payment.cashier.name}</td>
          </tr>
          `
        })
      } else {
        payments +=
        `
        <tr class="warning center aligned">
          <td colspan="6"><i class="info circle icon"></i> No payments have been received so far</td>
        </tr>
        `
      }

      var body = `
      <div class="scrolling content">
        <div class="ui three doubling stackable cards">
          {{-- Customer Information Card --}}
          ${ sale.customer.id != 1 ? customer : `` }
          ${ (sale.sell_to_organization && sale.organization.id != 1) ? organization : `` }
          ${sale.grades.length > 0 ? gradesBox : ``}
          <div class="ui raised card">
            <div class="content">
              <div class="ui top attached black center aligned large label">
                <i class="calendar check icon"></i> Events and Tickets
              </div>
              <div class="ui list">
                ${events}
              </div>
            </div>
          </div>
          ${sale.products.length > 0 ? productsBox : ``}
        </div>

        <h4 class="ui horizontal divider header">
          <i class="money icon"></i> Payments
        </h4>
        <table class="ui selectable single line table">
          <thead>
            <tr>
              <th>#</th>
              <th>Method</th>
              <th>Paid</th>
              <th>Tendered</th>
              <th>Date</th>
              <th>Cashier</th>
            </tr>
          </thead>
          <tbody>
            ${payments}
          </tbody>
        </table>
        <h4 class="ui horizontal divider header">
          <i class="dollar sign icon"></i> Totals
        </h4>
        <div class="ui tiny five statistics">
          <div class="statistic">
            <div class="label">Subtotal</div>
            <div class="value"><i class="dollar sign icon"></i>${sale.subtotal}</div>
          </div>
          <div class="statistic">
            <div class="label">Tax</div>
            <div class="value"><i class="dollar sign icon"></i>${sale.tax}</div>
          </div>
          <div class="statistic">
            <div class="label">Total</div>
            <div class="value"><i class="dollar sign icon"></i>${sale.total}</div>
          </div>
          <div class="${sale.paid <= 0 ? `yellow` : `green`} statistic">
            <div class="label">Paid</div>
            <div class="value"><i class="dollar sign icon"></i>${sale.paid}</div>
          </div>
          <div class="${sale.balance > 0 ? `red` : `green`} statistic">
            <div class="label">Balance</div>
            <div class="value"><i class="dollar sign icon"></i>${sale.balance}</div>
          </div>
        </div>
        <h4 class="ui horizontal divider header">
          <i class="comment alternate outline icon"></i> Memos
        </h4>
        ${sale.memos.length > 0 ? `<div class="ui comments">${memos}</div>` : memos}
      </div>
      `
      var footer = `
      <div class="actions">
        <a href="/admin/sales/${sale.id}/edit" class="ui yellow right labeled icon button">
          Edit
          <i class="edit icon"></i>
        </a>
        <div class="ui black deny button">
          Close
        </div>
      </div>
      </div>
      `

    document.querySelector('#details').innerHTML = header + body + footer
    $('#details').modal('show')
  });
}

function  fetchEvents(calEvent, jsEvent, view) {
  fetch(`/api/event/${calEvent.id}`)
    .then(response => response.json())
    .then(response => {

      document.querySelector('#details').innerHTML = null

      var memos = ''

      if (response.memos.length > 0) {
        response.memos.forEach(function (memo)
        {
          memos +=
          `
          <div class="comment">
            <div class="avatar"><i class="user circle big icon"></i></div>
            <div class="content">
              <div class="author">
                ${memo.author.name}
                <div class="ui tiny black label">${memo.author.role}</div>
                <div class="metadata">
                  <span class="date">${moment(memo.created_at).calendar()}</span>
                </div>
              </div>
              <div class="text">
                ${memo.message}
              </div>
            </div>
          </div>
          `
        }
      )
    } else {
      memos =
      `
      <div class="ui info icon message">
        <i class="info circle icon"></i>
        <div class="content">
          <div class="header">
            No Memos
          </div>
          <p>No one has left a memo for this event yet.</p>
        </div>
      </div>
      `
    }

      var dateFormat = response.allDay ? 'dddd, MMMM D, YYYY' : 'dddd, MMMM D, YYYY [at] h:mm A'

      // Start this variable with a message box saying that there are no sales for this event
      var sales = ''

      if (response.sales.length > 0) {
        response.sales.forEach(function (sale)
        {
          var tickets = ``
          sale.tickets.forEach(function (ticket) {
            tickets +=
            `
            <div class="ui black label" style="margin-left:0">
            <i class="ticket icon"></i>
            ${ticket.quantity} <div class="detail">${ticket.type}</div>
            </div>
            `
          })

          var products = ``
          sale.products.forEach(function (product) {
            products +=
            `
            <div class="ui black label" style="margin-left:0">
              <i class="box icon"></i>
              ${product.quantity} <div class="detail">${product.name}</div>
            </div>
            `
          })

          {{-- This function gets the sale status and returns it prettified in the modal --}}
          function getSaleStatus(status) {
            switch(status) {
              case 'complete'  : return `<div class="ui green label"><i class="checkmark icon"></i>${status}</div>`
              case 'no show'   : return `<div class="ui orange label"><i class="thumbs outline down icon"></i>${status}</div>`
              case 'open'      : return `<div class="ui violet label"><i class="unlock icon"></i>${status}</div>`
              case 'tentative' : return `<div class="ui yellow label"><i class="help icon"></i>${status}</div>`
              case 'canceled'  : return `<div class="ui red label"><i class="remove icon"></i>${status}</div>`
            }
          }

          sales +=
          `
          <div class="ui ${sale.status == 'canceled' ? `red raised` : `raised`} card">
            <div class="content">
              <div class="header">
                <a href="/admin/sales/${sale.id}" target="_blank" style="padding: 0 0 0 0">Sale # ${sale.id}</a>
                <div class="right floated">
                  <div class="ui black tag label"><i class="dollar icon"></i> ${parseFloat(sale.total).toFixed(2)}</div>
                  ${getSaleStatus(sale.status)}
                </div>
              </div>
              <a class="meta" href="/admin/users/${sale.creator.id}" target="_blank">
                <i class="user circle icon"></i> ${sale.creator.name}
              </a>
              <div class="meta">
                <i class="pencil icon"></i> ${moment(sale.created_at).format('dddd, MMMM D, YYYY [at] h:mm:ss A')} (${moment(sale.created_at).fromNow()})
              </div>
                ${sale.organization.name == sale.customer.name ? `` : `<a class="meta" href="/admin/users/${sale.customer.id}" target="_blank"><i class="user icon"></i> ${sale.customer.name}</a>`}
                ${sale.organization.id == 1 || !sale.sell_to_organization ? `` : ` | <a class="meta" href="/admin/organizations/${sale.organization.id}" target="_blank"><i class="university icon"></i> ${sale.organization.name}</a>` }
                <br><br>
              <div class="description">${tickets} ${products}</div>
            </div>
          </div>
          `
        }
      )
      } else {
        sales =
        `
        <div class="ui info icon message">
          <i class="info circle icon"></i>
          <div class="content">
            <div class="header">
              No Group Sales!
            </div>
            <p>There are no group sales for this show.</p>
          </div>
        </div>
        `
      }

      var header =
      `
      <i class="close icon"></i>
      <div class="ui header">
        <i class="calendar alternate icon"></i>
        <div class="content">
          Event #${response.id}
        </div>
      </div>
      `
      var body = `
      <div class="scrolling content">
        <div class="ui items">
          <div class="ui item">
            ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui rounded small image"><img src="${response.show.cover}"></div>`}
            <div class="content">
              <div class="meta">
                <div class="ui label" style="background-color: ${response.color}; color: rgba(255, 255, 255, 0.8)"><i class="calendar alternate icon"></i> <div class="detail">${response.type}</div></div>
                  ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui black label"><i class="clock outline icon"></i><div class="detail">${response.show.duration} minutes</div></div>`}
                  ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui black label"><i class="ticket icon"></i><div class="detail">${response.tickets_sold} tickets sold</div></div>`}
                  <div class="ui black label"><i class="${response.public ? `users` : `user`} icon"></i><div class="detail">${response.public ? `Public` : `Private`}</div></div>
                </div>
                <div class="ui large header">
                  ${ (response.allDay || response.show.id == 1) ? response.memo : response.show.name}
                  <div class="sub header">
                    <i class="calendar alternate icon"></i>${moment(response.start).format(dateFormat)}
                    (${moment(response.start).fromNow()})
                    </div>
                </div>
                <div class="extra">
                  <p>
                    <i class="user circle icon"></i> ${response.creator.name} |
                    <i class="pencil icon"></i> ${moment(response.created_at).format(dateFormat)} (${moment(response.created_at).fromNow()}) |
                    <i class="edit icon"></i> ${moment(response.updated_at).format(dateFormat)} (${moment(response.updated_at).fromNow()})
                  </p>
                </div>
                <div class="description">
                  {{-- Sales --}}
                  ${ (response.allDay || response.show.id == 1) ? `` :
                    `
                    <h4 class="ui horizontal divider header">
                      <i class="dollar icon"></i> Sales
                    </h4>
                    <div class="ui two doubling stackable cards">
                      ${sales}
                    </div>
                    `
                  }
                  {{-- Memos --}}
                  <h4 class="ui horizontal divider header">
                    <i class="comment alternate outline icon"></i> Memos
                  </h4>
                  ${response.memos.length > 0 ? `<div class="ui comments">${memos}</div>` : memos}
                  {{-- Show Description --}}
                  <h4 class="ui horizontal divider header">
                    <i class="film icon"></i> Show Description
                  </h4>
                  ${ (response.allDay || response.show.id == 1) ? `` : response.show.description }
                  <br><br>
                  Duration: ${response.show.duration} minutes
                </div>
            </div>
          </div>
        </div>
      </div>
      `
      var deleteButton = ''

      if (response.sales.length <= 0) {
        deleteButton =
        `
        <form action="/admin/events/${response.id}" method="POST" style="display:contents">
          <input type="hidden" name="_method" value="DELETE">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button class="ui red right labeled icon button" type="submit">
            Delete
            <i class="trash icon"></i>
          </button>
        </form>
        `
      }

      var footer = `
      <div class="actions">
        ${deleteButton}
        <a href="/admin/events/${response.id}/edit" class="ui yellow right labeled icon button">
          Edit
          <i class="edit icon"></i>
        </a>
        <div class="ui black deny button">
          Close
        </div>
      </div>
      </div>
      `

    document.querySelector('#details').innerHTML = header + body + footer
    $('#details').modal('show')
  });
}

function loadCalendars() {
  $('#calendars').fullCalendar({
    header: false,
    defaultView: 'listDay',
    defaultDate: moment().format('YYYY-MM-DD'),
    contentHeight: 150,
    hiddenDays: [0],
    navLinks: true,
    editable: false,
    eventLimit: true,
    minTime: '08:00:00',
    events: '/api/calendar/sales',
    titleFormat: 'dddd, MMMM D, YYYY',
    eventClick: function(calEvent, jsEvent, view) {
      var eventSource = $('#calendars').fullCalendar('option', 'events')
      if (eventSource == '/api/calendar/sales') {
        fetchSales(calEvent, jsEvent, view)
      } else {
        fetchEvents(calEvent, jsEvent, view)
      }
    }
  })
  setTitle()
}

function refetchEvents() {
  $('#calendars').fullCalendar('refetchEvents')
}

function setTitle() {
  var title = $('#calendars').fullCalendar('getView').title
  $('#calendar-title').html(title)
}

function toggleCalendar(type) {
  $('#calendars').fullCalendar('removeEventSources')
  $('#calendars').fullCalendar('option', 'events', `/api/calendar/${type}`)
  $('#calendars').fullCalendar('addEventSource', `/api/calendar/${type}`)
}

$(document).ready(function() {
  loadCalendars()
})

window.onload = function() {
  var earningsCanvas = document.getElementById("earningsChart").getContext("2d");
  var earningsChart = new Chart(earningsCanvas, {
    type: 'line',
    data: {
      labels: [
               '{{ Date::today()->subDays(6)->format('l, F j') }}',
               '{{ Date::today()->subDays(5)->format('l, F j') }}',
               '{{ Date::today()->subDays(4)->format('l, F j') }}',
               '{{ Date::today()->subDays(3)->format('l, F j') }}',
               '{{ Date::today()->subDays(2)->format('l, F j') }}',
               '{{ Date::today()->subDays(1)->format('l, F j') }}',
               '{{ Date::today()->format('l, F j') }}'
             ],
      datasets: [{
        label: 'Earnings ',
        data: [
          {{ getSalesTotals(Date::today()->subDays(6)) }},
          {{ getSalesTotals(Date::today()->subDays(5)) }},
          {{ getSalesTotals(Date::today()->subDays(4)) }},
          {{ getSalesTotals(Date::today()->subDays(3)) }},
          {{ getSalesTotals(Date::today()->subDays(2)) }},
          {{ getSalesTotals(Date::today()->subDays(1)) }},
          {{ getSalesTotals(Date::today()) }},
        ],
        backgroundColor: "rgba(27, 28, 29, 0.5)",
        borderColor: "rgba(21, 28, 29, 1)",
        borderWidth: 2
      }]
    },
    options: {
        responsive: true,
        legend: { display: true },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              return '$ ' + tooltipItem.yLabel.toFixed(2)
            }
          }
        },
        title: { display: false },
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function(value, index, values) {
                      return '$ ' + value
                    }
                }
            }],
            xAxes: [{
              display: false
            }]
        }
      }
  });

  var attendanceCanvas = document.getElementById("attendanceChart").getContext("2d");
  var attendanceChart = new Chart(attendanceCanvas, {
    type: 'doughnut',
    data: {
      labels: [
              '{{ Date::today()->subDays(6)->format('l, F j') }}',
              '{{ Date::today()->subDays(5)->format('l, F j') }}',
              '{{ Date::today()->subDays(4)->format('l, F j') }}',
              '{{ Date::today()->subDays(3)->format('l, F j') }}',
              '{{ Date::today()->subDays(2)->format('l, F j') }}',
              'Yesterday',
              'Today'
             ],
      datasets: [{
        label: 'Attendance ',
        data: [
          {{ getAttendance(Date::today()->subDays(6)) }},
          {{ getAttendance(Date::today()->subDays(5)) }},
          {{ getAttendance(Date::today()->subDays(4)) }},
          {{ getAttendance(Date::today()->subDays(3)) }},
          {{ getAttendance(Date::today()->subDays(2)) }},
          {{ getAttendance(Date::today()->subDays(1)) }},
          {{ getAttendance(Date::today()) }},
        ],
        backgroundColor: [
          '#fea142',
          '#fdce57',
          '#4bbebf',
          '#e03997',
          '#cf3534',
          '#002e5d',
          '#1b1c1d',
        ]
      }]
    },
    options: {
        animation: { animateScale: true, animateRotate: true },
        responsive: true,
        legend: { display: false, position: 'right' },
        title: { display: true, text: 'by Tickets Sold' },
        maintainAspectRatio: false
      }
  });

  var secondAttendanceCanvas = document.getElementById("secondAttendanceChart").getContext("2d");
  var secondAttendanceChart = new Chart(secondAttendanceCanvas, {
    type: 'polarArea',
    data: {
      labels: [
              <?php
                foreach (App\TicketType::all() as $ticketType) {
                  echo "'" . $ticketType->name . "',";
                }
              ?>
             ],
      datasets: [{
        label: 'Attendance ',
        data: [
          <?php
            foreach (App\TicketType::all() as $ticketType) {
              echo getAttendanceByType($ticketType->id) . ",";
            }
          ?>
        ],
        backgroundColor: [
          '#fea142',
          '#fdce57',
          '#4bbebf',
          '#e03997',
          '#cf3534',
          '#002e5d',
          '#1b1c1d',
        ]
      }]
    },
    options: {
        animation: { animateScale: true, animateRotate: true },
        responsive: true,
        legend: { display: false, position: 'right' },
        title: { display: true, text: 'by Demographics' },
        maintainAspectRatio: false
      }
  });
}

</script>

@endsection
