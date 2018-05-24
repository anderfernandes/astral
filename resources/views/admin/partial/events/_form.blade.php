@if ($type == 'create')
  {!! Form::open(['route' => 'admin.events.store', 'class' => 'ui form']) !!}
@else
  {!! Form::model($event, ['route' => ['admin.events.update', $event], 'class' => 'ui form', 'method' => 'PUT']) !!}
@endif
<div class="two fields" style="height:60px; margin-bottom;14px">
  <div class="field">
    <div class="field" style="display:none" id="title-field">
      <label for="title">Title</label>
      <input type="text" name="title" placeholder="Enter the title of the event" value="{{ isSet($event) ? $event->memo : old('title') }}">
    </div>
  </div>
  <div class="field">
    <label for=""></label>
    <div class="ui basic segment" style="text-align: right">
      <div class="ui toggle checkbox">
        <input type="checkbox" tabindex="0" name="allday">
        <label for="allday">All Day</label>
      </div>
    </div>
  </div>
</div>
<div class="two required fields">
  <div class="field">
    {!! Form::label('show_id', 'Show') !!}
    {!! Form::select('show_id', $shows, null, ['placeholder' => 'Select a show', 'class' => 'ui search dropdown']) !!}
  </div>
  <div class="field">
    {!! Form::label('type_id', 'Type') !!}
    {!! Form::select('type_id', $eventTypes, null, ['placeholder' => 'Select event type', 'class' => 'ui dropdown']) !!}
  </div>
</div>
<div class="two required fields">
  <div class="field">
    {!! Form::label('public', 'Public') !!}
    @if (isSet($event))
      {!! Form::select('public', [true => 'Yes', false => 'No'], $event->public, ['placeholder' => 'Is this a public event?', 'class' => 'ui dropdown']) !!}
    @else
      {!! Form::select('public', [true => 'Yes', false => 'No'], null, ['placeholder' => 'Is this a public event?', 'class' => 'ui dropdown']) !!}
    @endif

  </div>
  <div class="field">
    {!! Form::label('seats', 'Seats') !!}
    {!! Form::text('seats', App\Setting::find(1)->seats, ['placeholder' => 'Number of seats']) !!}
  </div>
</div>
<div class="two fields">
  <div class="required field">
    <label for="dates[0][start]"><span id="start-word">Start</span> Date and Time</label>
    <div class="ui left icon input">
      <input placeholder="Event Date and Time" data-validate="start_dates" name="dates[0][start]" type="text" readonly="readonly">
      <i class="calendar icon"></i>
    </div>
  </div>
  <div class="required field" id="end-datetime">
    {!! Form::label('end', 'End Date and Time') !!}
    <div class="ui left icon input">
      <input placeholder="Event Date and Time" data-validate="end_dates" name="dates[0][end]" type="text" readonly="readonly">
      <i class="calendar icon"></i>
    </div>
  </div>
</div>
<div id="extra-dates"></div>
@if (!isSet($event))
<div class="field" style="height:60px; margin-bottom;14px">
  <div class="ui button" id="add-another-date"><i class="plus icon"></i>Add Another Date</div>
</div>
@endif
<div class="required field">
  {!! Form::label('memo', 'Memo') !!}
  {!! Form::textarea('memo', null, ['placeholder' => 'Tell us why you are creating this event', 'rows' => 2]) !!}
</div>
<div class="field">
  @if (Request::routeIs('admin.events.create') or Request::routeIs('admin.events.edit'))
  <div class="ui buttons">
    <a href="{{ route('admin.calendar.index') . '?type=events&view=agendaWeek' }}" class="ui default button"><i class="left chevron icon"></i> Back</a>
    <div class="ui positive right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
  </div>
  @else
    <div class="ui positive right floated right labeled submit icon button">Save <i class="checkmark icon"></i></div>
  @endif
</div>
{!! Form::close() !!}

<script>

  @if (isSet($event))
    document.querySelector('[name="dates[0][start]"]').value = moment("{{ Date::parse($event->start)->format('l, F j, Y \a\t g:i A') }}", 'dddd, MMMM D, YYYY h:mm A').format('dddd, MMMM D, YYYY h:mm A');
    document.querySelector('[name="dates[0][end]"]').value = moment("{{ Date::parse($event->end)->format('l, F j, Y \a\t g:i A') }}", 'dddd, MMMM D, YYYY h:mm A').format('dddd, MMMM D, YYYY h:mm A');
    $('[name="dates[0][start]"]').flatpickr({enableTime:true, minDate: 'today', dateFormat: 'l, F j, Y h:i K', minuteIncrement: 15});
    $('[name="dates[0][end]"]').flatpickr({enableTime:true, minDate: 'today', dateFormat: 'l, F j, Y h:i K', minuteIncrement: 15});
  @else
  $('[name="dates[0][start]"]').flatpickr({enableTime:true, minDate: 'today', dateFormat: 'l, F j, Y h:i K', defaultHour:8, defaultMin:0, minuteIncrement: 15});
  $('[name="dates[0][end]"]').flatpickr({enableTime:true, minDate: 'today', dateFormat: 'l, F j, Y h:i K', minuteIncrement: 15});
  @endif

  $('[name="dates[0][start]"]').change(function() {
    document.querySelector('[name="dates[0][end]"]').value = moment(this.value, 'dddd, MMMM D, YYYY h:mm A').add(1, 'hours').format('dddd, MMMM D, YYYY h:mm A');
  })

  var index = 0

  $('#add-another-date').click(function() {
    if (document.querySelector('[name="dates[' + index + '][start]"]').value == "") {
      alert("Please select a date and time for the event before adding a new one.")
    } else {
      index++
      $('.ui.checkbox').transition('fade')
      $('#extra-dates').append(
      '<div class="two required fields">' +
        '<div class="field">' +
            '{!! Form::label("start", "Start Date and Time") !!}' +
            '<div class="ui left icon input">' +
              '<input placeholder="Event Date and Time" data-validate="start_dates" name="dates['+ index +'][start]" type="text" readonly="readonly">' +
            '<i class="calendar icon"></i>' +
          '</div>' +
        '</div>' +
        '<div class="field">' +
          '{!! Form::label("end", "End Date and Time") !!}' +
          '<div class="ui left icon input">' +
            '<input placeholder="Event Date and Time" data-validate="end_dates" name="dates['+ index +'][end]" type="text" readonly="readonly">' +
            '<i class="calendar icon"></i>' +
          '</div>' +
        '</div>' +
      '</div>'
    )

    $('[name="dates[' + index + '][start]"]').flatpickr({
      enableTime:true,
      minDate: 'today',
      dateFormat: 'l, F j, Y h:i K',
      defaultHour:8,
      defaultMin:0,
      minuteIncrement: 15,
      onChange: function(selectedDates, dateStr, instance) {
        document.querySelector('[name="dates[' + index + '][end]"]').value = moment(dateStr, 'dddd, MMMM D, YYYY h:mm A').add(1, 'hours').format('dddd, MMMM D, YYYY h:mm A')
      }
    })

    $('[name="dates[' + index + '][end]"]').flatpickr({
      enableTime: true,
      minDate:    'today',
      dateFormat: 'l, F j, Y h:i K',
      minuteIncrement: 15
    })
  }
})

{{-- Handling the All Day checkbox --}}
$('[name="allday"]').change(function() {
  $('#add-another-date').transition('fade')
  $('#end-datetime').transition('fade')
  $('#start-word').transition('fade')
  //$('form').form('clear')
  if ($(this).prop('checked')) {
    $('[name="dates[0][start]"]').flatpickr({enableTime: false, minDate: 'today', dateFormat: 'l, F j, Y', defaultDate: '{{ isSet($event->start) ? Date::parse($event->start)->format('l, F j, Y') : null }}'});
    $('[name="dates[0][end]"]').flatpickr({enableTime: false, minDate: 'today', dateFormat: 'l, F j, Y', defaultDate: ''});
  } else {
    $('[name="dates[0][start]"]').flatpickr({enableTime:true, minDate: 'today', dateFormat: 'l, F j, Y h:i K', minuteIncrement: 15, defaultDate: ''});
    $('[name="dates[0][end]"]').flatpickr({enableTime:true, minDate: 'today', dateFormat: 'l, F j, Y h:i K', minuteIncrement: 15, defaultDate: ''});
  }
})

$('[name="show_id"]').change(function() {

  if (this.value == 1) $('#title-field').transition('show')
})

{{-- Client side form validation --}}
$('form').form({
  inline: true,
  on: 'blur',
  fields: {
    public: {
      identifier: 'public',
      rules: [
        { type: 'empty', prompt: 'Is this show for the general public or for a private group/school?' }
      ]
    },
    show_id: {
      identifier: 'show_id',
      rules: [
        { type: 'empty', prompt: 'Do not forget to select a show!' }
      ]
    },
    type_id: {
      identifier: 'type_id',
      rules: [
        { type: 'empty', prompt: 'Do not forget to select a show type!' }
      ]
    },
    seats: {
      identifier: 'seats',
      rules: [
        { type: 'empty', prompt: 'Do not forget to set the number of seats available for this event!' },
        { type: 'integer', prompt: 'The number of seats should be an integer' },
        { type: 'minLength[1]', prompt: 'The number of seats should be at least 1 character long' }
      ]
    },
    start_dates: {
      identifier: 'start_dates',
      rules: [
        { type: 'empty', prompt: 'Do not forget to set a start date and time for this event!' }
      ]
    },
    end_dates: {
      identifier: 'end_dates',
      rules: [
        { type: 'empty', prompt: 'Do not forget to set an end date and time for this event!' }
      ]
    },
    memo: {
      identifier: 'memo',
      rules: [
        @if (Request::routeIs('admin.events.edit'))
        { type: 'empty', prompt: 'Let everyone know why you are editing this event!' }
        @else
        { type: 'empty', prompt: 'Let everyone know why you are creating this event' }
        @endif
      ]
    },
  }
})

@isset($event)
  $('.ui.checkbox').checkbox('{{ Date::parse($event->start)->isStartOfDay() && Date::parse($event->end)->isEndOfDay() ? "check" : "uncheck" }}')
@endif

</script>
