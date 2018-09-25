<?php

use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;

use App\{ Event, Setting, User, PaymentMethod, Sale, Organization, EventType };
use App\{ MemberType, Show };
use Illuminate\Support\Facades\{ Auth, Storage };

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::get('events', function() {
  // Get today's date for the query that will show today's events
  $today = Date::now('America/Chicago')->addMinutes(-30)->toDateTimeString();
  $events = Event::where('start','>=', $today)
              ->where('start','<=', Date::now('America/Chicago')->endOfDay())
              ->orderBy('start', 'desc')
              ->get();
  $eventsArray = [];
  foreach ($events as $event) {
    $eventsArray = array_prepend($eventsArray, [
      'id'       => $event->id,
      'type'     => $event->type->name,
      'start'    => $event->start,
      'end'      => $event->end,
      'seats'    => $event->seats - App\Ticket::where('event_id', $event->id)->count(),
      'show'     => [
        'name'  => $event->show->name,
        'type'  => $event->show->type,
        'cover' => $event->show->cover
        ],
      'allowedTickets' => $event->type->allowedTickets,
    ]);
  }
  return $eventsArray;
});*/

Route::get('shows', function(Request $request) {
  $shows = Show::where('id', '!=', 1)->orderBy('name', 'asc')->get();
  return $shows;

});

Route::get('shows/{id}', function($id) {
  $show = Show::find($id);
  return $show;
});

// This API is consumed by /admin/calendar/sales in Full Calendar
Route::get('calendar/sales', function(Request $request) {
  $start = Date::parse($request->start)->startOfDay()->toDateTimeString();
  $end = Date::parse($request->end)->endOfDay()->toDateTimeString();
  $sales = Sale::where([
                        ['customer_id',     '!=', 1],
                        //['organization_id', '!=', 1],
                        ['refund', false],
                      ])->get();
  $eventsArray = [];
  foreach ($sales as $sale) {
    $events = $sale->events->where('start', '>=', $start)->where('end', '<', $end)->where('type_id', '!=', 1);
    $customer = ($sale->customer->firstname == $sale->organization->name) ? null : ' - ' . $sale->customer->fullname;
    $organization = ($sale->organization->id == 1)? null : ' - ' . $sale->organization->name;
    $organization = $sale->sell_to_organization ? $organization : null;
    foreach ($events->unique('id') as $event) {
      $seats = $event->seats - App\Ticket::where('event_id', $event->id)->count();
      $startTime = Date::parse($event->start)->format('i') == "00" ? Date::parse($event->start)->format('g') : Date::parse($event->start)->format('g:i');
      $startTime = Date::parse($event->start)->format('a') == 'am' ? $startTime . 'a' : $startTime . 'p';
      $endTime = Date::parse($event->end)->format('i') == "00" ? Date::parse($event->end)->format('g') : Date::parse($event->end)->format('g:i');
      $endTime = Date::parse($event->end)->format('a') == 'am' ? $endTime . 'a' : $endTime . 'p';
      $title = "$startTime-$endTime | Sale #$sale->id ($sale->status) \n" . $event->show->name .  $organization . $customer;
      $eventsArray = array_prepend($eventsArray, [
        'id'       => $sale->id,
        'type'     => $event->type->name,
        'start'    => Date::parse($event->start)->toDateTimeString(),
        'end'      => Date::parse($event->end)->toDateTimeString(),
        'seats'    => $event->seats - App\Ticket::where('event_id', $event->id)->count(),
        'title'    => $title,
        //'url'      => route('admin.events.show', $event),
        'show'     => [
          'name'  => $event->show->name,
          'type'  => $event->show->type,
          'cover' => substr($event->show->cover, 0, 4) == 'http' ? $event->show->cover : Storage::url($event->show->cover),
        ],
        'color' => $sale->status == 'canceled' ? 'red' : $event->type->color,
        'backgroundColor' => $sale->status == 'canceled' ? 'red' : $event->type->color,
        'textColor' => 'rgba(255, 255, 255, 0.8)',
      ]);
    }
  }
  return $eventsArray;
});

Route::get('sales', function() {
  $allSales = Sale::all();

  $sales = [];

  foreach ($allSales as $sale) {
    $sales = array_prepend($sales, [
      'id'       => $sale->id,
      'creator'  => $sale->creator->firstname,
      'status'   => $sale->status,
      'source'   => $sale->source,
      'taxable'  => boolval($sale->taxable),
      'subtotal' => $sale->subtotal,
      'tax'      => $sale->tax,
      'total'    => $sale->total,
      'balance'  => number_format($sale->total - $sale->payments->sum('tendered'), 2),
      'refund'   => $sale->refund,
      'customer' => $sale->customer->fullname,
      'organization' => $sale->organization->name,
      'sellToOrganization' => boolval($sale->sell_to_organization),
      'payments' => $sale->payments
    ]);
  };

  return $sales;
});

Route::get('calendar-events', function() {
  $today = Date::parse()->format('Y-m-d');
  $todaysEvents = Event::whereDate('start', '>=', $today)->get();
  $todaysEventsIds = [];
  $salesIds = [];

  foreach ($todaysEvents as $todaysEvent) {
    foreach ($todaysEvent->sales as $todaysEventSale) {
      array_push($salesIds, $todaysEventSale->id);
    }
  }

  $salesIds = array_unique($salesIds);

  $salesArray = [];
  $eventsArray = [];
  $ticketsArray = [];

  // Get all sales not assigned to walkups
  $sales = Sale::where('customer_id', '!=', 1)->whereIn('id', $salesIds)->get();

  foreach ($sales as $sale) {
    // Get id of today's events based on today's sales
    $eventIds = array_pluck($sale->events, 'id');
    // Get all events that are not "no events"
    $events = Event::where('id', '!=', 1)->whereIn('id', $eventIds)->get();
    foreach ($events as $event) {
      $eventsArray = array_prepend($eventsArray, [
        'id'      => $event->id,
        'start'   => $event->start,
        'end'     => $event->end,
        'seats'   => $event->seats,
        'type'    => $event->type->name,
        'creator' => $event->creator->fullname,
        'show' => [
          'id'       => $event->show->id,
          'name'     => $event->show->name,
          'type'     => $event->show->type,
          'duration' => $event->show->duration,
          'cover'    => substr($event->show->cover, 0, 4) == 'http' ? $event->show->cover : Storage::url($event->show->cover),
        ],
      ]);
    }

    // Loop through tickets for this sale, get type and quantity for each type
    $tickets = $sale->tickets->unique('ticket_type_id');
    foreach ($tickets as $ticket) {
      $q = $sale->tickets->where('ticket_type_id', $ticket->type->id)->count();
      $quantity = $sale->events[1]->show_id == 1 ? $q : $q/2;
      $ticketsArray = array_prepend($ticketsArray, [
        'type'     => $ticket->type->name,
        'price'    => $ticket->type->price,
        'quantity' => $quantity,
      ]);
    }

    $salesArray = array_prepend($salesArray, [
      'id'         => $sale->id,
      'creator'    => $sale->creator->fullname,
      'created_at' => Date::parse($sale->created_at)->toDateTimeString(),
      'start'      => $sale->events[0]->start,
      'status'     => $sale->status,
      'source'     => $sale->source,
      'total'      => $sale->total,
      'memo'       => $sale->memo,
      'customer'   => [
        'name'         => $sale->customer->fullname,
        'organization' => $sale->customer->organization->name,
        'phone'        => $sale->customer->phone,
        'email'        => $sale->customer->email,
      ],
      'events'    => $eventsArray,
      'tickets'   => $ticketsArray,
    ]);
    $eventsArray = [];
    $ticketsArray = [];
  }

  $salesCollect = collect($salesArray);

  $sorted = $salesCollect->sortBy('start');

  $sorted = $sorted->values()->all();

  return $sorted;
});

// This API is consumed by the MODAL that shows event information in /admin/calendar
Route::get('event/{event}', function(Event $event) {

  // Get all Sales for this event
  $salesArray    = [];
  $ticketsArray  = [];
  $productsArray = [];
  $ticketsSold   = 0;
  foreach ($event->sales as $sale) {
    $ticketsSold += $sale->status != 'canceled' ? $sale->tickets->count() : 0;
    if ($sale->tickets->count() > 1) {
      // Loop through tickets for this sale, get type and quantity for each type
      $tickets = $sale->tickets->where('event_id', $event->id)->unique('ticket_type_id')->all();
      foreach ($tickets as $ticket) {
        $quantity = $sale->tickets->where('ticket_type_id', $ticket->ticket_type_id)->where('event_id', $event->id)->count();
        //$quantity = $sale->events[0]->show_id == 1 ? $q : $q/2;
        $ticketsArray = array_prepend($ticketsArray, [
          'type'     => $ticket->type->name,
          'price'    => $ticket->type->price,
          'quantity' => $quantity,
        ]);
      }
    }

    // Taking out non-refunded and walkup sales
    if ($sale->customer_id != 1) {
      if (!$sale->refund) {
        foreach ($sale->products->unique('id') as $product) {
          $productsArray = array_prepend($productsArray, [
            'id'       => $product->id,
            'name'     => $product->name,
            'price'    => number_format($product->price, 2),
            'quantity' => $sale->products->where('id', $product->id)->count(),
          ]);
        }
        $salesArray = array_prepend($salesArray, [
          'id' => $sale->id,
          'customer'        => [
            'id'   => $sale->customer_id,
            // check if last name has a space in the end for organization accounts
            'name' => $sale->customer->lastname == null ? $sale->customer->firstname : $sale->customer->fullname,
          ],
          'organization'    => [
            'id'   => $sale->organization_id,
            'name' => $sale->organization->name,
          ],
          'creator' => [
            'id' => $sale->creator_id,
            'name' => $sale->creator->fullname,
          ],
          'total'                => $sale->total,
          'tickets'              => $ticketsArray,
          'products'             => $productsArray,
          'status'               => $sale->status,
          'sell_to_organization' => (bool)$sale->sell_to_organization,
          'created_at'           => Date::parse($sale->created_at)->toDateTimeString(),
          'updated_at'           => Date::parse($sale->updated_at)->toDateTimeString(),
        ]);
      }
    }

    // clear ticket array after we loop through this event
    $ticketsArray  = [];
    $productsArray = [];
  }

  $memos = [];
  $memosArray = [];
  foreach ($event->memos as $memo) {
    $memosArray = array_prepend($memosArray, [
      'id'         => $memo->id,
      'message'    => $memo->message,
      'author'     => [
        'name' => $memo->author->fullname,
        'role' => $memo->author->role->name,
      ],
      'created_at' => Date::parse($memo->created_at)->toDateTimeString(),
      'updated_at' => Date::parse($memo->updated_at)->toDateTimeString(),
    ]);
  }
  $isAllDay = (Date::parse($event->start)->isStartOfDay() && Date::parse($event->end)->isEndOfDay());
  return [
    'id'       => $event->id,
    'type'     => $event->type->name,
    'start'    => Date::parse($event->start)->toDateTimeString(),
    'end'      => Date::parse($event->end)->toDateTimeString(),
    'color'    => $event->type->color,
    'seats'    => $event->seats - App\Ticket::where('event_id', $event->id)->count(),
    //'url'      => '#' . $event->id,
    'creator' => [
      'name' => $event->creator->fullname,
      'role' => $event->creator->role->name,
    ],
    'show'     => [
      'id'          => $event->show->id,
      'name'        => $event->show->name,
      'description' => $event->show->description,
      'type'        => $event->show->type,
      'duration'    => $event->show->duration,
      'cover'       => substr($event->show->cover, 0, 4) == 'http' ? $event->show->cover : Storage::url($event->show->cover),
    ],
    'sales'   => $salesArray,
    'tickets_sold' => $ticketsSold,
    'memo'       => $event->memo,
    'created_at' => Date::parse($event->created_at)->toDateTimeString(),
    'updated_at' => Date::parse($event->updated_at)->toDateTimeString(),
    'memos'      => $memosArray,
    'allDay'     => $isAllDay,
  ];
});

// This API is consumed by Full Calendar in /admin/calendar/events
Route::get('/calendar/events', function(Request $request) {
  $start = Date::parse($request->start)->startOfDay()->toDateTimeString();
  $end = Date::parse($request->end)->endOfDay()->addMinute()->toDateTimeString();
  $type = isSet($request->type) ? $request->type : null;
  $events = Event::where([
                          ['start'  , '>=', $start],
                          ['end'    , '<=', $end  ],
                        ]);
  $events = isSet($request->type) ? $events->where('type_id', $request->type)->get() : $events->get();
  $eventsArray = [];
  foreach ($events as $event) {
    $ticketsSold = 0;
    foreach ($event->sales as $sale) {
        $ticketsSold += $sale->status != 'canceled' ? $sale->tickets->count() : 0;
    }
    $seats = $event->seats - $ticketsSold;
    $isAllDay = (Date::parse($event->start)->isStartOfDay() && Date::parse($event->end)->isEndOfDay());
    $startTime = Date::parse($event->start)->format('i') == "00" ? Date::parse($event->start)->format('g') : Date::parse($event->start)->format('g:i');
    $startTime = Date::parse($event->start)->format('a') == 'am' ? $startTime . 'a' : $startTime . 'p';
    $endTime = Date::parse($event->end)->format('i') == "00" ? Date::parse($event->end)->format('g') : Date::parse($event->end)->format('g:i');
    $endTime = Date::parse($event->end)->format('a') == 'am' ? $endTime . 'a' : $endTime . 'p';
    $eventsArray = array_prepend($eventsArray, [
      'id'       => $event->id,
      'type'     => $event->type->name,
      'start'    => $isAllDay ? Date::parse($event->start)->format('Y-m-d') : Date::parse($event->start)->toDateTimeString(),
      'end'      => $isAllDay ? '' : Date::parse($event->end)->toDateTimeString(),
      // Take out tickets from shows that have been canceled!!!
      'seats'    => $seats, // $event->seats - App\Ticket::where('event_id', $event->id)->count(),
      'title'    => $event->show_id !=1 ? "$startTime-$endTime | Event #$event->id ($seats seats left) \n {$event->show->name}" : (isSet($event->memo) ? $event->memo : $event->type->name),
      //'url'      => '/admin/events/' . $event->id,
      'show'     => [
        'name'        => $event->show->name,
        'type'        => $event->show->type,
        'cover'       => substr($event->show->cover, 0, 4) == 'http' ? $event->show->cover : Storage::url($event->show->cover),
        'duration'    => $event->show->duration,
        'description' => $event->show->description,
        ],
      'allowedTickets' => $event->type->allowedTickets,
      'date'            => $start,
      'color'           => $event->type->color,
      'backgroundColor' => $event->type->color,
      'textColor'       => 'rgba(255, 255, 255, 0.8)',
      'public'          => $event->public,
      'allDay'          => $isAllDay,
    ]);
  }
  $eventsCollect = collect($eventsArray);

  $eventsCollect = $eventsCollect->sortBy('start');

  $eventsCollect = $eventsCollect->values()->all();
  return response($eventsCollect)->withHeaders(['Access-Control-Allow-Origin' => '*']);
});

Route::get('staff', function() {
  $staff = User::where('staff', true)->orderBy('name', 'asc')->get();
  return $staff;
});

// This URL is consumed in the new Sales interface
// This API is consumed by Full Calendar in /admin/calendar?type=events
Route::get('events', function(Request $request) {
  $start = Date::parse($request->start)->startOfDay()->toDateTimeString();

  $end = $request->has('end')
          ? Date::parse($request->end)->endOfDay()->toDateTimeString()
          : Date::parse($request->start)->endOfDay()->toDateTimeString();

  $q = [
    ['show_id', '!=', 1],
  ];
  array_push($q, ['start', '>=', $start], ['end', '<=', $end]);

  if ($request->has('type')) array_push($q, ['type_id', $request->type]);
  $type = isSet($request->type) ? $request->type : null;
  $events = Event::where($q)->get();
  $eventsArray = [];
  foreach ($events as $event) {
    $ticketsSold = 0;
    foreach ($event->sales as $sale) {
        $ticketsSold += $sale->status != 'canceled' ? $sale->tickets->count() : 0;
    }
    $seats = $event->seats - $ticketsSold;
    $isAllDay = (($event->start->isStartOfDay()) && ($event->end->isEndOfDay()));
    $eventsArray = array_prepend($eventsArray, [
      'id'       => $event->id,
      'type'     => $event->type->name,
      'start'    => $isAllDay ? $event->start->format('Y-m-d') : $event->start->toDateTimeString(),
      'end'      => $isAllDay ? '' : $event->end->toDateTimeString(),
      // Take out tickets from shows that have been canceled!!!
      'seats'    => $seats, // $event->seats - App\Ticket::where('event_id', $event->id)->count(),
      'title'    => $event->show_id !=1 ? "{$event->show->name}, $seats seats left" : (isSet($event->memo) ? $event->memo : $event->type->name),
      //'url'      => '/admin/events/' . $event->id,
      'show'     => [
        'name'        => $event->show->name,
        'type'        => $event->show->type,
        'cover'       => $event->show->cover,
        'description' => $event->show->description,
        ],
      'allowedTickets' => $event->type->allowedTickets,
      'date'            => $start,
      'color'           => $event->type->color,
      'backgroundColor' => $event->type->color,
      'textColor'       => 'rgba(255, 255, 255, 0.8)',
      'public'          => $event->public,
      'allDay'          => $isAllDay,
    ]);
  }
  $eventsCollect = collect($eventsArray);
  $eventsCollect = $eventsCollect->sortBy('start');
  $eventsCollect = $eventsCollect->values()->all();
  return response($eventsCollect)->withHeaders(['Access-Control-Allow-Origin' => '*']);
});

// This is the URL for the /events slide show
Route::get('events/{start}/{end}', function($start, $end) {
  $start = Date::parse($start)->startOfDay()->toDateTimeString();
  $end = Date::parse($end)->endOfDay()->toDateTimeString();
  $events = Event::where('start', '>=', $start)->where('end', '<', $end)->where('public', true)->get();
  $eventsArray = [];
  foreach ($events as $event) {
    $seats = $event->seats - App\Ticket::where('event_id', $event->id)->count();
    $eventsArray = array_prepend($eventsArray, [
      'id'       => $event->id,
      'type'     => $event->type->name,
      'start'    => Date::parse($event->start)->toDateTimeString(),
      'end'      => Date::parse($event->end)->toDateTimeString(),
      'seats'    => $event->seats - App\Ticket::where('event_id', $event->id)->count(),
      'title'    => $event->show->name .' - ' . $event->type->name . ' - ' . $seats . ' seats left',
      'url'      => '/admin/events/' . $event->id,
      'show'     => [
        'name'  => $event->show->name,
        'type'  => $event->show->type,
        'cover' => substr($event->show->cover, 0, 4) == 'http' ? $event->show->cover : Storage::url($event->show->cover),
        ],
      'allowedTickets' => $event->type->allowedTickets->where('in_cashier', true),
      'date' => $start,
    ]);
  }

  $eventsCollect = collect($eventsArray);

  $eventsCollect = $eventsCollect->sortBy('start');

  $eventsCollect = $eventsCollect->values()->all();

  return $eventsCollect;
});

// This API is consumed on the add members
Route::get('membership-type/{id}', function($id) {
  $membership_type = \App\MemberType::find($id);

  return [
    'id'              => $membership_type->id,
    'name'            => $membership_type->name,
    'price'           => number_format($membership_type->price, 2, '.', ','),
    'duration'        => (float)$membership_type->duration,
    'max_secondaries' => (int)$membership_type->max_secondaries,
    'secondary_price' => (float)$membership_type->secondary_price,
  ];
});

Route::get('settings', function() {
  $settings = \App\Setting::find(1);
  return response($settings)->withHeaders(['Access-Control-Allow-Origin' => '*']);
});

Route::get('customers', function(Request $request) {
  $customerArray = [];
  $customers = User::where('type', 'individual')->where('id', '!=', $request->primary)->where('membership_id', 1)->orderBy('firstname', 'asc')->get();
  foreach ($customers as $customer) {
    array_push($customerArray, [
      'id' => $customer->id,
      'name' => $customer->fullname,
      'role' => $customer->role->name,
      'taxable' => (boolean)$customer->organization->type->taxable,
      'organization' => [
        'id' => $customer->organization->id,
        'name' => $customer->organization->name,
        'type' => $customer->organization->type->name,
      ],
    ]);
  }

  return $customerArray;
});

Route::get('sale/{sale}', function(Sale $sale) {
  $memosArray    = [];
  $eventsArray   = [];
  $productsArray = [];
  $gradesArray   = [];
  $paymentsArray = [];

  foreach($sale->payments as $payment)
  {
    $paymentsArray = array_prepend($paymentsArray, [
      'id'       => $payment->id,
      'method'   => $payment->method->name,
      'paid'     => number_format($payment->tendered - $payment->change_due, 2),
      'tendered' => number_format($payment->tendered, 2),
      'date'     => Date::parse($payment->created_at)->toDateTimeString(),
      'cashier'  => [
        'id'   => $payment->cashier->id,
        'name' => $payment->cashier->firstname,
      ],
    ]);
  }

  foreach($sale->grades as $grade)
  {
    $gradesArray = array_prepend($gradesArray, [
      'id' => $grade->id,
      'name' => $grade->name,
    ]);
  }

  foreach($sale->products->unique('id') as $product)
  {
    $productsArray = array_prepend($productsArray, [
      'id'       => $product->id,
      'type'     => $product->type->name,
      'name'     => $product->name,
      'price'    => $product->price,
      'cover'    => $product->cover,
      'quantity' => $sale->products->where('id', $product->id)->count(),
    ]);
  }

  foreach($sale->events as $event)
  {
    $ticketsArray = [];
    foreach($event->tickets->unique('ticket_type_id') as $ticket)
    {
      $ticketsArray = array_prepend($ticketsArray, [
        'name' => $ticket->type->name,
        'quantity' => $event->tickets->where('ticket_type_id', $ticket->ticket_type_id)->count(),
      ]);
    }
    $eventsArray = array_prepend($eventsArray, [
      'id'    => $event->id,
      'type'  => $event->type->name,
      'color' => $event->type->color,
      'show' => [
        'id' => $event->show->id,
        'name'  => $event->show->name,
        'cover' => substr($event->show->cover, 0, 4) == 'http' ? $event->show->cover : Storage::url($event->show->cover),
      ],
      'start' => Date::parse($event->start)->toDateTimeString(),
      'end'   => Date::parse($event->end)->toDateTimeString(),
      'tickets' => $ticketsArray,
    ]);

  }

  foreach ($sale->memos as $memo) {
    $memosArray = array_prepend($memosArray, [
      'id'         => $memo->id,
      'message'    => $memo->message,
      'author'     => [
        'name' => $memo->author->fullname,
        'role' => $memo->author->role->name,
      ],
      'created_at' => Date::parse($memo->created_at)->toDateTimeString(),
      'updated_at' => Date::parse($memo->updated_at)->toDateTimeString(),
    ]);
  }
  return [
    'id'      => $sale->id,
    'status'  => $sale->status,
    'source'  => $sale->source,
    'memos'   => $memosArray,
    'creator' => [
      'id' => $sale->creator->id,
      'name' => $sale->creator->fullname,
      'role' => $sale->creator->role->name,
    ],
    'customer' => [
      'id'           => $sale->customer->id,
      'name'         => $sale->customer->fullname,
      'role'         => [
        'id'   => $sale->customer->role->id,
        'name' => $sale->customer->role->name,
      ],
      'organization' => [
        'id' => $sale->customer->organization->id,
        'name' => $sale->customer->organization->name,
      ],
      'address'      => "{$sale->customer->address} {$sale->customer->city}, {$sale->customer->state} {$sale->customer->zip}",
      'phone'        => $sale->customer->phone,
      'email'        => $sale->customer->email,
    ],
    'organization' => [
      'id'    => $sale->organization->id,
      'name'  => $sale->organization->name,
      'type'         => $sale->organization->type->name,
      'address'      => "{$sale->organization->address} {$sale->organization->city}, {$sale->organization->state} {$sale->organization->zip}",
      'phone'        => $sale->customer->phone,
      'email'        => $sale->customer->email,
    ],
    'events'               => $eventsArray,
    'grades'               => $gradesArray,
    'products'             => $productsArray,
    'sell_to_organization' => (bool)$sale->sell_to_organization,
    'subtotal'             => number_format($sale->subtotal, 2),
    'tax'                  => number_format($sale->total - $sale->subtotal, 2),
    'total'                => number_format($sale->total, 2),
    'paid'                 => number_format($sale->payments->sum('tendered') - $sale->payments->sum('change_due'), 2, '.', ''),
    'balance'              => number_format((($sale->payments->sum('tendered') - $sale->payments->sum('change_due')) - $sale->total) * (- 1), 2, '.', ''),
    'payments'             => $paymentsArray,
    'created_at'           => Date::parse($sale->created_at)->toDateTimeString(),
    'updated_at'           => Date::parse($sale->updated_at)->toDateTimeString(),
  ];
});

Route::get('payment-methods', function() {
  $paymentMethods = PaymentMethod::all();
  return $paymentMethods;
});

Route::get('event-types', function() {
  $eventTypes = EventType::where('id', '!=', 1)->orderBy('name', 'asc')->get();
  return $eventTypes;
});

Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user()->id;
});

Route::post('new-sale', function(Request $request) {
  // New Sale
  /*$sale = new Sale;

  $sale->creator_id        = Auth::user()->id;
  $sale->organization_id   = User::find($request->sale->customerId)->organization_id;
  $sale->customer_id       = $request->sale->customer_id;
  $sale->status            = "complete";
  $sale->taxable           = User::find($request->sale->customerId)->organization->type->taxable;
  $sale->subtotal          = number_format($request->sale->subtotal, 2);
  $sale->tax               = number_format($request->sale->tax, 2);
  $sale->total             = number_format($request->sale->total, 2);
  $sale->refund            = false;
  $sale->memo              = "";
  //$sale->first_event_id    = $request->first_event_id;
  //$sale->second_event_id   = $request->second_event_id;



  $sale->source            = "cashier";

  //$sale->save();

  //$sale->events()->attach([$request->first_event_id, $request->second_event_id]);


  // New Payment

  // Store tickets in the database

*/

  return response()->json($request);
});
