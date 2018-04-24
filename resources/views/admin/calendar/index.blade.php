@extends('layout.admin')

@section('title', 'Calendar')

@section('subtitle', null)

@section('icon', 'calendar')

@section('content')

  <div class="ui black icon buttons">
    <div onclick="$('#admin-calendar').fullCalendar('prev')" class="ui button"><i class="left chevron icon"></i></div>
    <div onclick="$('#admin-calendar').fullCalendar('today')" class="ui button"><i class="checked calendar icon"></i></div>
    <div onclick="$('#admin-calendar').fullCalendar('next')" class="ui button"><i class="right chevron icon"></i></div>
  </div>

  <a class="ui secondary button" href="javascript:$('#create-event').modal('show')">
    <i class="calendar plus icon"></i> Create Event
  </a>

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
    <i class="calendar outline icon"></i>
    <span class="text">{{ $request->type == 'events' ? 'Events' : 'Reservations' }}</span>
    <div class="menu">
      @if (isSet($request))
        <div onclick="toggleCalendar('events')" class="{{ $request->type == 'events' ? 'active' : null }} item">Events</div>
        <div onclick="toggleCalendar('calendar')" class="{{ $request->type == 'calendar' ? 'active' : null }} item">Reservations</div>
      @else
        <div onclick="toggleCalendar('events')" class="item">Events</div>
        <div onclick="toggleCalendar('calendar')" class="active item">Reservations</div>
      @endif
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
      eventClick: function(calEvent, jsEvent, view) {
        fetch(`/api/event/${calEvent.id}`)
          .then(response => response.json())
          .then(response => {

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
                {{-- This function gets the sale status and returns it prettified in the modal --}}
                function getSaleStatus(status) {
                  switch(status) {
                    case 'complete'  : return `<div class="ui tiny green label"><i class="checkmark icon"></i>${status}</div>`
                    case 'no show'   : return `<div class="ui tiny orange label"><i class="thumbs outline down icon"></i>${status}</div>`
                    case 'open'      : return `<div class="ui tiny violet label"><i class="unlock icon"></i>${status}</div>`
                    case 'tentative' : return `<div class="ui tiny yellow label"><i class="help icon"></i>${status}</div>`
                    case 'canceled'  : return `<div class="ui tiny red label"><i class="remove icon"></i>${status}</div>`
                  }
                }

                sales +=
                `
                <h3 class="ui dividing header">
                  <div class="content">
                    <a class="sub header" href="/admin/sales/${sale.id}" target="_blank" style="padding-bottom: 0">
                      Sale # ${sale.id}
                      ${getSaleStatus(sale.status)}
                    </a>
                    ${sale.organization.id != 1 ? `<a href="/admin/organizations/${sale.organization.id}" target="_blank">${sale.organization.name}</a>`  : `` }
                    ${sale.organization.name == sale.customer.name ? `` : `| <a href="/admin/users/${sale.customer.id}" target="_blank">${sale.customer.name}</a>`}
                    <div class="sub header">
                      <div class="ui green tag label">$ ${parseFloat(sale.total).toFixed(2)}</div>
                      ${tickets}
                    </div>
                  </div>
                </h3>
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
            <i class="close icon" style="color: white"></i>
            <div class="ui header">
              <i class="calendar check icon"></i>
              <div class="content">
                Event Details
                <div class="sub header">Event #${response.id}</div>
              </div>
            </div>
            `
            var body = `
            <div class="content">
              <div class="ui items">
                <div class="ui item">
                  <div class="ui small rounded image"><img src="${response.show.cover}"></div>
                  <div class="content">
                    <div class="meta">
                    <div class="ui label" style="background-color: ${response.color}; color: rgba(255, 255, 255, 0.8)">${response.type}</div>
                      <div class="ui label">${response.show.duration} ${response.show.duration > 1 ? `minutes` : `minute`}</div>
                      <div class="ui label">${response.tickets_sold} tickets sold</div>
                      <div class="ui basic label">${response.public ? `Public` : `Private`}</div>
                    </div>
                    <div class="ui large header">
                      ${response.show.name}
                      <div class="sub header">
                        <i class="calendar alternate icon"></i>
                        ${moment(response.start).calendar()}
                      </div>
                    </div>
                    <div class="extra">
                      <p>Created by ${response.creator.name} on ${moment(response.created_at).format('dddd, MMMM D, YYYY [at] h:mm:ss A')}</p>
                      <p>Updated on ${moment(response.updated_at).format('dddd, MMMM D, YYYY [at] h:mm:ss A')}</p>
                    </div>
                  </div>
                </div>
                <div class="ui item">
                  <div class="content">
                    <div class="extra">
                    <h4 class="ui horizontal divider header">
                      <i class="dollar icon"></i> Sales
                    </h4>
                    ${sales}
                    </div>
                  </div>
                </div>
                <h4 class="ui horizontal divider header">
                  <i class="comment alternate outline icon"></i> Memos
                </h4>
                ${response.memos.length > 0 ? `<div class="ui comments">${memos}</div>` : memos}
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

  function toggleCalendar(type) {
    $('#admin-calendar').fullCalendar('removeEventSources')
    $('#admin-calendar').fullCalendar('addEventSource', '/api/' + type)
  }

  function refetchEvents() {
    $('#admin-calendar').fullCalendar('refetchEvents')
  }

  function setTitle() {
    var title = $('#admin-calendar').fullCalendar('getView').title
    $('.header.active.item.hide-on-mobile').html('<i class="calendar icon"></i> Calendar | <strong>' + title + '</strong>')
  }

  //$(document).ready(loadCalendar)

  $(document).ready(function() {
    loadCalendar()
    $('#admin-calendar').fullCalendar('addEventSource', '/api/{{ $request->type }}')
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
