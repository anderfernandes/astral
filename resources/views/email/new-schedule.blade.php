<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <title>Astral - Schedule #{{ $schedule->id }} - {{ auth()->user()->organization->name }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

  <table style="width:100%">
    <tr>
      <td>{{ now()->format('l, F j, Y') }}</td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td>Dear {{ $user->firstname }},</td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td>
        @if (isset($schedule->memo))
        {{ $schedule->memo }}
        @else
          A new work schedule has been posted.
        @endif
      </td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <tr>
      <td>
          Note: This schedule is not final, as it may change to accommodate new, updated or canceled events.
      </td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </table>

    @foreach ($schedule->shifts as $shift)
    <table style="width:100%">
      <tr>
        <th style="border:1px solid black;text-align:center">{{ $shift->start->format('l, F j, Y') }}</th>
      </tr>
    </table>
    <table style="width:100%">
      <tr>
        <th style="border:1px solid black;text-align:center">Employee</th>
        <th style="border:1px solid black;text-align:center">Position</th>
        <th style="border:1px solid black;text-align:center">Time</th>
      </tr>
      @foreach ($shift->employees as $employee)
      <tr <?php if ($employee->id == $user->id) echo 'bgcolor="#d3d3d3"'; ?>>
        <td style="border:1px solid black;text-align:center">{{ $employee->firstname }}</td>
        <td style="border:1px solid black;text-align:center">{{ $shift->positions[$loop->index]->name }}</td>
        <td style="border:1px solid black;text-align:center">{{ $shift->start->format('g:i A') }} - {{ $shift->end->format('g:i A') }}</td>
      </tr>
      @endforeach
      </table>
      @if ($shift->events->count() > 0)
      <table style="width:100%">
        <tr>
          <th style="border:1px solid black;text-align:center">Events</th>
        </tr>
        @foreach ($shift->events as $event)
        <tr>
          <td style="border:1px solid black;text-align:center">
            #{{ $event->id }} - {{ $event->show->name }}, {{ $event->show->type }},
            {{ $event->start->format('g:i A') }}, {{ $event->type->name }}, 
            {{ $event->tickets->count() }} {{ $event->tickets->count() == 1 ? "ticket" : "tickets" }} sold,
            {{ $event->tickets->count() }} {{ $event->tickets->count() == 1 ? "sale" : "sales" }}
          </td>
        </tr>
        @endforeach
      </table>
      @endif
    </table>
    <br>
    @endforeach
    
    <table style="width: 100%">
      <tr>
        <td>{{ auth()->user()->fullname }}</td>
      </tr>
      <tr>
        <td>{{ auth()->user()->role->name }}</td>
      </tr>
      <tr>
        <td>{{ auth()->user()->organization->name }} </td>
      </tr>
    </table>
</body>
</html>