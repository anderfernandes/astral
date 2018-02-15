<?php

use Illuminate\Http\Request;

use App\Event;
use App\Setting;
use App\User;
use App\PaymentMethod;
use App\Sale;
use App\Organization;
use App\EventType;

use Illuminate\Support\Facades\Auth;

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

Route::get('calendar', function() {
  // Gets all events

  $sales = Sale::where('customer_id', '!=', 1)->where('status', '!=', 'canceled')->where('refund', false)->get();
  $eventsArray = [];
  foreach ($sales as $sale) {
    $events = $sale->events->where('type_id', '!=', 1);
    $customer = ($sale->customer->firstname == $sale->organization->name) ? null : ' - ' . $sale->customer->fullname;
    $organization = ($sale->organization->id == 1)? null : ' - ' . $sale->organization->name;
    foreach ($events as $event) {
      $seats = $event->seats - App\Ticket::where('event_id', $event->id)->count();
      $title = $event->show->name .  $organization . $customer . ' - Sale #' . $sale->id;
      $eventsArray = array_prepend($eventsArray, [
        'id'       => $event->id,
        'type'     => $event->type->name,
        'start'    => Date::parse($event->start)->toDateTimeString(),
        'end'      => Date::parse($event->end)->toDateTimeString(),
        'seats'    => $event->seats - App\Ticket::where('event_id', $event->id)->count(),
        'title'    => $title,
        'url'      => '/admin/sales/' . $sale->id,
        'show'     => [
          'name'  => $event->show->name,
          'type'  => $event->show->type,
          'cover' => $event->show->cover
        ],
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
      'id'      => $sale->id,
      'creator' => $sale->creator->firstname,
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
          'cover'    => $event->show->cover,
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

Route::get('events', function() {
  $events = Event::all();
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
        'cover' => $event->show->cover
        ],
    ]);
  }
  return $eventsArray;
});

Route::get('staff', function() {
  $staff = User::where('staff', true)->orderBy('name', 'asc')->get();
  return $staff;
});

Route::get('events/{start}/{end}', function($start, $end) {
  $start = Date::parse($start)->startOfDay()->toDateTimeString();
  $end = Date::parse($end)->endOfDay()->toDateTimeString();
  $events = Event::where('start', '>=', $start)->whereDate('end', '<', $end)->where('public', true)->get();
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
        'cover' => $event->show->cover
        ],
      'allowedTickets' => $event->type->allowedTickets,
      'date' => $start,
    ]);
  }

  $eventsCollect = collect($eventsArray);

  $eventsCollect = $eventsCollect->sortBy('start');

  $eventsCollect = $eventsCollect->values()->all();

  return $eventsCollect;
});

Route::get('organizations/{organization}', function(Organization $organization) {
  $users = [];
  foreach ($organization->users as $user) {
    $users = array_prepend($users, [
      'id'      => $user->id,
      'name'    => $user->fullname,
      'taxable' => $organization->type->taxable,
    ]);
  }

  return $users;
});

Route::get('settings', function() {
  $settings = Setting::find(1)->get();
  return $settings;
});

Route::get('customers', function() {
  $customers = User::all();
  return $customers;
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
