@extends('layout.admin')

@section('title', 'Calendar')

@section('subtitle', null)

@section('icon', 'calendar alternate')

@section('content')

  <div class="ui black icon buttons">
    <div onclick="$('#admin-calendar').fullCalendar('prev')" class="ui button"><i class="left chevron icon"></i></div>
    <div onclick="$('#admin-calendar').fullCalendar('today')" class="ui button"><i class="calendar outline icon"></i></div>
    <div onclick="$('#admin-calendar').fullCalendar('next')" class="ui button"><i class="right chevron icon"></i></div>
  </div>

  @if (str_contains(Auth::user()->role->permissions['calendar'], "C"))
  <a class="ui secondary button" onclick="$('#create-event').modal('toggle')" href="#">
    <i class="calendar plus icon"></i> Create Event
  </a>
  @endif

  @if (str_contains(Auth::user()->role->permissions['sales'], "C"))
  <div class="ui floating secondary dropdown button">
    <i class="plus icon"></i> Create Sale<i class="dropdown icon"></i>
    <div class="menu">
      @foreach (App\EventType::where('id', '!=', 1)->get() as $eventType)
        @if ($eventType->allowedTickets->count() > 0)
        <a href="{{ route('admin.sales.create') }}?eventType={{ $eventType->id }}" class="item">{{ $eventType->name }}</a>
        @endif
      @endforeach
    </div>
  </div>
  @endif

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
    <span class="text">Events</span>
    <div class="menu">
      <a href="{{ route('admin.calendar.events') }}" class="active item">Events</a>
      <a href="{{ route('admin.calendar.sales') }}" class="item">Sales</a>
    </div>
  </div>

  <div class="ui labels" style="text-align: center; margin-top: 1rem !important">
  @foreach (App\EventType::where('id', '!=', 1)->get() as $eventType)
    <div class="ui label" style="background-color: {{ $eventType->color }}; color: rgba(255, 255, 255, 0.8)">{{ $eventType->name }}</div>
  @endforeach
  </div>

  @if (!isset($events) || $events->count() > 0)
    <br />
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

  <div class="ui large modal" id="event-detail"></div>

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
        fetch(`/api/event/${calEvent.id}`)
          .then(response => response.json())
          .then(response => {

            document.querySelector('#event-detail').innerHTML = null

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
                    <a class="meta" href="/admin/users/${sale.creator.id}" target="_blank"><i class="user circle icon"></i> ${sale.creator.name}</a>
                    <div class="meta"><i class="pencil icon"></i> ${moment(sale.created_at).format('dddd, MMMM D, YYYY [at] h:mm:ss A')} (${moment(sale.created_at).fromNow()})</div>
                    ${sale.organization.name == sale.customer.name ? `` : `<a class="description" href="/admin/users/${sale.customer.id}" target="_blank"><i class="user icon"></i> ${sale.customer.name}</a>`}<br>
                    ${sale.organization.id != 1 ? `<a class="description" href="/admin/organizations/${sale.organization.id}" target="_blank"><i class="university icon"></i> ${sale.organization.name}</a>`  : `` }
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
              <i class="calendar check icon"></i>
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
                      <div class="ui label" style="background-color: ${response.color}; color: rgba(255, 255, 255, 0.8)">${response.type}</div>
                        ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui label">${response.show.duration} minutes</div>`}
                        ${ (response.allDay || response.show.id == 1) ? `` : `<div class="ui label">${response.tickets_sold} tickets sold</div>`}
                        <div class="ui basic label">${response.public ? `Public` : `Private`}</div>
                      </div>
                      <div class="ui large header">
                        ${ (response.allDay || response.show.id == 1) ? response.memo : response.show.name}
                        <div class="sub header">
                          <i class="calendar alternate icon"></i>${moment(response.start).format(dateFormat)}
                          (${moment(response.start).fromNow()})
                          </div>
                      </div>
                      <div class="extra">
                        <p><i class="user circle icon"></i> ${response.creator.name}</p>
                        <p><i class="pencil icon"></i> ${moment(response.created_at).format(dateFormat)} (${moment(response.created_at).fromNow()})</p>
                        <p><i class="edit icon"></i> ${moment(response.updated_at).format(dateFormat)} (${moment(response.updated_at).fromNow()})</p>
                      </div>
                      <div class="description">
                      ${ (response.allDay || response.show.id == 1) ? `` : `<i class="info circle icon"></i> ${ response.show.description}` }
                      </div>
                      <div class="ui basic segment">
                        <h4 class="ui horizontal divider header">
                          <i class="comment alternate outline icon"></i> Memos
                        </h4>
                        ${response.memos.length > 0 ? `<div class="ui comments">${memos}</div>` : memos}
                      </div>
                      <div class="ui basic segment">
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

          document.querySelector('#event-detail').innerHTML = header + body + footer
          $('#event-detail').modal('show')
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
    $('#admin-calendar').fullCalendar('addEventSource', '/api/events')
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

@endsection
