<x-mail::message>
## Receipt #{{$sale->id}}

Dear {{ $sale->customer->firstname  }},

Receipt #{{ $sale->id }} has been attached to this email.

Sincerely,<br>
Visitor Services,<br><br>
{{ $organization }}
</x-mail::message>
