@extends('layout.admin')

@section('title', 'Calendar')

@section('subtitle', null)

@section('icon', 'calendar alternate')

@section('content')

  <div class="ui black icon buttons">
    <div onclick="$('#admin-calendar').fullCalendar('prev')" class="ui button"><i class="left chevron icon"></i></div>
    <div onclick="$('#admin-calendar').fullCalendar('today')" class="ui button"><i class="checked calendar icon"></i></div>
    <div onclick="$('#admin-calendar').fullCalendar('next')" class="ui button"><i class="right chevron icon"></i></div>
  </div>

  @if (str_contains(Auth::user()->role->permissions['calendar'], "C"))
  <a class="ui secondary button" onclick="$('#create-event').modal('toggle')" href="#">
    <i class="calendar plus icon"></i> Create Event
  </a>
  @endif

  @if (str_contains(Auth::user()->role->permissions['sales'], "C"))
  <div class="ui floating secondary dropdown button">
    <i class="icons"><i class="dollar icon"></i><i class="corner plus inverted icon"></i></i> Create Sale<i class="dropdown icon"></i>
    <div class="menu">
      @foreach (App\EventType::where('id', '!=', 1)->get() as $eventType)
        @if ($eventType->allowedTickets->count() > 0)
        <a href="{{ route('admin.sales.create') }}?eventType={{ $eventType->id }}" class="item">{{ $eventType->name }}</a>
        @endif
      @endforeach
    </div>
  </div>
  @endif

  <div class="ui right floated icon black button" onclick="$('#event-colors').modal('toggle')">
    <i class="help circle icon"></i>
  </div>

  <div class="ui right floated secondary floating dropdown labeled icon button" id="view">
    <i class="eye icon"></i>
    <span class="text">Week</span>
    <div class="menu">
      <div onclick="$('#admin-calendar').fullCalendar('changeView', 'agendaDay')" class="{{ $request->view == 'agendaDay' ? 'active' : null }} item">Single Day</div>
      <div onclick="$('#admin-calendar').fullCalendar('changeView', 'agendaWeek')" class="{{ $request->view == 'agendaWeek' ? 'active' : null }} item">Week</div>
      <div onclick="$('#admin-calendar').fullCalendar('changeView', 'month')" class="{{ $request->view == 'month' ? 'active' : null }} item">Month</div>
    </div>
  </div>

  <div class="ui right floated secondary floating dropdown labeled icon button">
    <i class="calendar alternate outline icon"></i>
    <span class="text">Sales</span>
    <div class="menu">
      <a href="{{ route('admin.calendar.events') }}" class="item">Events</a>
      <a href="{{ route('admin.calendar.sales') }}" class="active item">Sales</a>
    </div>
  </div>

  @if (!isset($events) || $events->count() > 0)
    <br /><br />
    <div class="ui doubling stackable grid">
      <div id="admin-calendar" style="min-width:100%; max-width:100%; padding-bottom: 2rem"></div>
    </div>
  @else
    <div class="ui info icon message">
      <i class="info circle icon"></i>
      <i class="close icon"></i>
      <div class="content">
        <div class="header">
          No events!
        </div>
        <p>It looks like there are no events in the database.</p>
      </div>
    </div>
  @endif

  @include('admin.partial.events._create')

  @include('admin.partial.help._event-colors')

  <div class="ui fullscreen modal" id="sale-detail"></div>

<script>

  var ev = null;

  function loadCalendar() {
    $('#admin-calendar').fullCalendar({
      header: false,
      views: null,
      defaultView: 'agendaWeek',
      defaultDate: moment().format('YYYY-MM-DD'),
      contentHeight: 'auto',
      hiddenDays: [0],
      navLinks: true,
      displayEventTime: false,
      navLinkDayClick: function(date, jsEvent) {
        $('#view').dropdown('set exactly', 'Single Day')
        $('#admin-calendar').fullCalendar('gotoDate', date)
        $('#admin-calendar').fullCalendar('changeView', 'agendaDay')
        setTitle()
      },
      editable: false,
      eventLimit: true,
      minTime: '08:00:00',
      titleFormat: 'dddd, MMMM D, YYYY',
      eventClick: function(calEvent, jsEvent, view) {
        fetch(`/api/sale/${calEvent.id}`)
          .then(response => response.json())
          .then(sale => {

            document.querySelector('#sale-detail').innerHTML = null

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

          document.querySelector('#sale-detail').innerHTML = header + body + footer
          $('#sale-detail').modal('show')
        });
      }
    })
  }

  function refetchEvents() {
    $('#admin-calendar').fullCalendar('refetchEvents')
  }

  function setTitle() {
    var title = $('#admin-calendar').fullCalendar('getView').title
    $('.header.active.item.hide-on-mobile').html(`<i class="calendar alternate icon"></i> Calendar | <strong>${title}</strong>`)
  }

  //$(document).ready(loadCalendar)

  $(document).ready(function() {
    loadCalendar()
    $('#admin-calendar').fullCalendar('addEventSource', '/api/calendar')
    setTitle()
    @if (isSet($request->view))
      $('#admin-calendar').fullCalendar('changeView', '{{ $request->view }}')
    @endif
    @if (isSet($request->date))
      $('#admin-calendar').fullCalendar('gotoDate', $.fullCalendar.moment('{{ $request->date }}'))
    @endif
  })

  $('.ui.button').click(setTitle)


  setInterval(refetchEvents, 5000)


</script>

<style>
  @media print {
    .ui.button, .ui.label {
      display: none !important;
    }
</style>

@endsection
