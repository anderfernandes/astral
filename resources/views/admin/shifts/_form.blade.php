<form action="{{ isset($shift) ? route('admin.shifts.update', $shift) : route('admin.shifts.store') }}"  
      method="post"
      class="ui form">
    
    @isset($shift)
      {{ method_field('PUT') }}
    @endisset

    {{ csrf_field() }}

    <div class="two fields">
      <div class="field">
        <label>Start Date</label>
        <input type="date" id="start-date" name="start[date]" value="{{ isset($shift) ? $shift->start->toDateString() : old('start.date') ?? null }}">
      </div>
      <div class="field">
        <label>Start Time</label>
        <input type="time" id="start-time" name="start[time]" value="{{ isset($shift) ? $shift->start->toTimeString() : old('start.time') ?? '08:00' }}">
      </div>
    </div>

    <div class="two fields">
      <div class="field">
        <label>End Date</label>
        <input type="date" id="end-date" name="end[date]" value="{{ isset($shift) ? $shift->end->toDateString() : old('end.date') ?? null }}">
      </div>
      <div class="field">
        <label>End Time</label>
        <input type="time" id="end-time" name="end[time]" value="{{ isset($shift) ? $shift->end->toTimeString() : old('end.time') ?? '13:00' }}">
      </div>
    </div>

    <div class="field">
      <label for="events">Events</label>
      <div class="ui multiple selection fluid events dropdown">
        @if (isset($shift->events))
        <input type="hidden" name="events" value="{{ $shift->events }}">
        @else
        <input type="hidden" name="events">
        @endif
        <div class="default text">Select no, one or more events</div>
        <i class="dropdown icon"></i>
        <div class="menu">
          @isset($shift->events)
            @foreach($events as $event)
              <div class="item" data-value="{{$event->id}}">
                {{ substr($event->start->format('ga'), 0, 2) }}-{{ substr($event->end->format('ga'), 0, 2) }} |
                Event #{{ $event->id }} ({{ $event->seats }} seats) {{ $event->show->name }} 
                ({{ $event->type->name }})
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>

    @if (isset($shift))
      @foreach($shift->employees as $employee)
      <div class="two fields">
        <div class="field">
          <label>Employee</label>
          <select class="ui fluid search dropdown" name="employees[{{ $loop->index }}][user_id]">
            <option value="">Select an employee</option>
            @foreach ($users as $user)
              @if ($user->id == $employee->id)
              <option selected value="{{ $user->id }}">{{ $user->firstname }}</option>
              @else
              <option value="{{ $user->id }}">{{ $user->firstname }}</option>
              @endif
            @endforeach
          </select>
        </div>
        <div class="field">
          <label>Position</label>
          <select class="ui fluid search dropdown" name="employees[{{ $loop->index }}][position_id]">
            <option value="">Select a position</option>
            @foreach($positions as $position)
            @if ($position->id == $shift->positions[$loop->parent->index]->id)
              <option selected value="{{ $position->id }}">{{ $position->name }}</option>
            @else
              <option value="{{ $position->id }}">{{ $position->name }}</option>
            @endif
            @endforeach
          </select>  
        </div>
      </div>
      @endforeach

      @for ($i = 1; $i <= $employees - $shift->employees->count(); $i++)
      <div class="two fields">
        <div class="field">
          <label>Employee</label>
          <select class="ui fluid dropdown" name="employees[{{ $i + $shift->employees->count() - 1 }}][user_id]">
            <option value="">Select an employee</option>
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->firstname }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label>Position</label>
          <select class="ui fluid dropdown" name="employees[{{ $i + $shift->employees->count() - 1 }}][position_id]">
              <option value="">Select a position</option>
              @foreach($positions as $position)
                <option value="{{ $position->id }}">{{ $position->name }}</option>
              @endforeach
            </select>  
        </div>
      </div>
      @endfor

    @else

      @for ($i = 1; $i <= $employees; $i++)
      <div class="two fields">
        <div class="field">
          <label>Employee</label>
          <select class="ui fluid dropdown" name="employees[{{ $i - 1 }}][user_id]">
            <option value="">Select an employee</option>
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->firstname }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label>Position</label>
          <select class="ui fluid dropdown" name="employees[{{ $i - 1 }}][position_id]">
              <option value="">Select a position</option>
              @foreach($positions as $position)
                <option value="{{ $position->id }}">{{ $position->name }}</option>
              @endforeach
            </select>  
        </div>
      </div>
      @endfor
    
    @endif

    <div class="two fields">
      <div class="field">
      <a class="ui blue labeled icon button" href="{{ isset($shift)
                                                    ? route('admin.shifts.edit', ['shift' => $shift, 'employees' => $employees + 1])
                                                    : route('admin.shifts.create', [ 'employees' => $employees + 1 ]) }}">
          <i class="plus icon"></i> Add Another Employee
        </a>
      </div>
      <div class="field" style="text-align: right">
        <button type="submit" class="ui labeled icon positive button">
          <i class="save icon"></i> Save
        </button>
        <button type="reset" class="ui labeled icon yellow button">
          <i class="erase icon"></i> Star Over
        </button>
      </div>

    </div>

</form>

<script>

  async function fetchEvents() {
    let start = document.querySelector('#start-date').value + 'T' + document.querySelector('#start-time').value
    let end   = document.querySelector('#end-date').value + 'T' + document.querySelector('#end-time').value

    let response = await fetch(`/api/calendar/events?start=${start}&end=${end}&all_day=false`)
    let events   = await response.json()

    if (events.length > 0) {
      events = events.map(event => ({
        value : event.id.toString(),
        name  : `${event.title} (${event.type})`,
      }))
      $('.ui.fluid.events.dropdown')
      .dropdown('clear')
      .dropdown({ useLabels : false })
      .dropdown('setup menu', { values : [] })
      .dropdown('setup menu', { values : events })
    } else {
      $('.ui.fluid.events.dropdown')
      .dropdown('clear')
      .dropdown('setup menu', { values : [] })
    }
  }

  document.querySelector('#start-date').addEventListener('change', function() {
    document.querySelector('#end-date').value = this.value
    fetchEvents()
  })

  document.querySelector('#end-date').addEventListener('change', fetchEvents)
  document.querySelector('#start-time').addEventListener('change', fetchEvents)
  document.querySelector('#end-time').addEventListener('change', fetchEvents)

  @isset($shift)
    $(document).ready(function() {
      $('.ui.fluid.events.dropdown')
      .dropdown({ useLabels : false })
      .dropdown('set exactly', {!! $shift->events->pluck('id')->map(function($id) { return (string)$id; }) !!})
      
    })
  
  @endif

</script>