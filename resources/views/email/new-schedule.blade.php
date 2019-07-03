<!DOCTYPE html>
<html lang="en">

<body>

  <style>
    table { width: 100%;}
    td, th { border: 1px solid black}
    td { text-align: center }
  </style>

  <h4 class="ui header">
      {{ now()->format('l, F j, Y') }}
    </h4>
    
    <p>Dear {{ $user->firstname }},</p>
    
    @if (isset($schedule->memo))
      <p>{{ $schedule->memo }}</p>
    @else
      <p>A new work schedule has been posted:</p>
    @endif
    
    <p>Note: This schedule is not final, as it may change to accommodate new, updated or canceled events.</p>

    @foreach ($schedule->shifts as $shift)
    <table>
      <tr>
        <th colspan="3">{{ $shift->start->format('l, F j, Y') }}</th>
      </tr>
      <tr>
        <th>Employee</th>
        <th>Position</th>
        <th>Time</th>
      </tr>
      @foreach ($shift->employees as $employee)
      <tr <?php if ($employee->id == $user->id) echo 'style="background-color:lightgray"'; ?>>
        <td>{{ $employee->firstname }}</td>
        <td>{{ $shift->positions[$loop->index]->name }}</td>
        <td>{{ $shift->start->format('g:i A') }} - {{ $shift->end->format('g:i A') }}</td>
      </tr>
      @endforeach
      @if ($shift->events->count() > 0)
      <tr>
        <th colspan="3">Events</th>
      </tr>
      @foreach ($shift->events as $event)
      <tr>
        <td colspan="3">
          #{{ $event->id }} - {{ $event->show->name }}, {{ $event->show->type }}
          {{ $event->start->format('g:i A') }}, {{ $event->type->name }}, 
          {{ $event->tickets->count() }} {{ $event->tickets->count() == 1 ? "ticket" : "tickets" }} sold,
          {{ $event->tickets->count() }} {{ $event->tickets->count() == 1 ? "sale" : "sales" }}
        </td>
      </tr>
      @endforeach
      @endif
    </table>
    <br>
    @endforeach
    
    <p>
      {{ auth()->user()->fullname }}     <br />
      {{ auth()->user()->role->name }}   <br />
      {{ auth()->user()->organization->name }} <br />
    </p>
    <p></p>
</body>
</html>
