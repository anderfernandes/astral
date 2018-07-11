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

  <div class="ui large modal" id="sale-detail"></div>

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

            var header =
            `
            <i class="close icon"></i>
            <div class="ui header">
              <i class="dollar icon"></i>
              <div class="content">
                Sale #${sale.id}
              </div>
            </div>
            `
            var status = function() {

              switch(sale.status) {
                case `open`: return `<div class="ui violet label"><i class="unlock icon"></i>${sale.status}</div>`
              }

            }
            var body = `
            <div class="scrolling content">
              <div class="ui three doubling stackable cards">
                <div class="ui raised card">
                  <div class="content">
                    <div class="ui top attached black center aligned large label">
                      <i class="dollar icon"></i> Sale Information
                    </div>
                    <div class="header">
                      Sale #${sale.id} ${status()}
                    </div>
                  </div>
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
