<?php

use Illuminate\Http\Request;

use App\Event;
use App\Setting;
use App\User;
use App\PaymentMethod;
use App\Sale;

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

  $sales = Sale::where('customer_id', '!=', 1)->where('status', '!=', 'canceled')->where('customer_id', '!=', 1)->get();
  $eventsArray = [];
  foreach ($sales as $sale) {
    $events = $sale->events->where('type_id', '!=', 1);
    foreach ($events as $event) {
      $seats = $event->seats - App\Ticket::where('event_id', $event->id)->count();
      $eventsArray = array_prepend($eventsArray, [
        'id'       => $event->id,
        'type'     => $event->type->name,
        'start'    => Date::parse($event->start)->toDateTimeString(),
        'end'      => Date::parse($event->end)->toDateTimeString(),
        'seats'    => $event->seats - App\Ticket::where('event_id', $event->id)->count(),
        'title'    => $event->show->name . ' - ' . $sale->organization->name . ' - Sale #' . $sale->id,
        'url'      => '/admin/sales/' . $sale->id,
      ]);
    }
  }
  return $eventsArray;
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
    ]);
  }
  return $eventsArray;
});

Route::get('events?start={start}&end={end}', function($start, $end) {
  $events = Event::whereDate('start', $start)->whereDate('end', $end)->get();
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
    ]);
  }
  return $eventsArray;
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
