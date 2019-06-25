<form action="{{ isset($shift) ? route('admin.shifts.update', $shift) : route('admin.shifts.store') }}"  
      method="post"
      class="ui form">
    
    @isset($shift)
      {{ method_field('PUT') }}
    @endisset

    {{ csrf_field() }}

    <div class="two fields">
      <div class="field">
        <label>Date Time</label>
        <input type="date" id="start" name="start[date]" value="{{ isset($shift) ? $shift->start->toDateString() : old('start.date') ?? now()->toDateString() }}">
      </div>
      <div class="field">
        <label>Start Time</label>
        <input type="time" name="start[time]" value="{{ isset($shift) ? $shift->start->toTimeString() : old('start.time') ?? '08:00' }}">
      </div>
    </div>

    <div class="two fields">
      <div class="field">
        <label>End Date</label>
        <input type="date" id="end" name="end[date]" value="{{ isset($shift) ? $shift->end->toDateString() : old('end.date') ?? now()->toDateString() }}">
      </div>
      <div class="field">
        <label>End Time</label>
        <input type="time" name="end[time]" value="{{ isset($shift) ? $shift->end->toTimeString() : old('end.time') ?? '13:00' }}">
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
                                                    ? route('admin.shifts.edit',   [ 'employees' => $employees + 1 ])
                                                    : route('admin.shifts.create', [ 'employees' => $employees + 1 ]) }}">
          <i class="plus icon"></i> Add Another Employee
        </a>
      </div>
      <div class="field" style="text-align: right">
        <button type="submit" class="ui labeled icon green button">
          <i class="save icon"></i> Save
        </button>
        <button type="reset" class="ui labeled icon yellow button">
          <i class="erase icon"></i> Star Over
        </button>
      </div>

    </div>

</form>

<script>

  document.querySelector('#start').addEventListener('change', function() {
    document.querySelector('#end').value = this.value
  })

</script>