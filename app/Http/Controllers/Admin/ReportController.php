<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\Event;
use Jenssegers\Date\Date;
use App\Sale;
use App\Ticket;
use App\Payment;
use App\PaymentMethod;
use App\User;
use App\Show;
use App\TicketType;
use Session;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('id', '!=', 1)->where('staff', true)->pluck('firstname', 'id');
        $shows = Show::where('id', '!=', 1)->pluck('name', 'id');
        return view('admin.reports.index')->withUsers($users)->withShows($shows);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reports($type, $id, $date)
    {
      $user = User::find($id);
      $date = new Date($date);
      $date = $date->toDateTimeString();
      $today = Date::now()->startOfDay();

      $sales = Sale::where([
        ['updated_at', '>=', $date],
      ])->orderBy('created_at', 'asc')->get();

      // Get Card Sales IDs
      $salesIds = array_pluck($sales, 'id');
      // Find all payments for the IDs we retrieved
      $payments = Payment::where('cashier_id', $id)->whereIn('sale_id', $salesIds)->get();

      if ($type == 'closeout')
      {

        $cashPayments  = [];
        $cashRefunds   = [];
        $cardPayments  = [];
        $cardRefunds   = [];
        $checkPayments = [];
        $checkRefunds  = [];
        $otherPayments = [];
        $otherRefunds  = [];

        // Get payments of a particular payment_method type
        foreach ($payments as $payment) {
          if ($payment->method->type == 'cash' and $payment->tendered > 0)
            array_unshift($cashPayments, $payment);
          elseif ($payment->method->type == 'cash' and $payment->tendered < 0)
              array_unshift($cashRefunds, $payment);
          else if ($payment->method->type == 'card' and $payment->tendered > 0)
            array_unshift($cardPayments, $payment);
          elseif ($payment->method->type == 'card' and $payment->tendered < 0)
              array_unshift($cardRefunds, $payment);
          else if ($payment->method->type == 'check' and $payment->tendered > 0)
            array_unshift($checkPayments, $payment);
          elseif ($payment->method->type == 'check' and $payment->tendered < 0)
              array_unshift($checkRefunds, $payment);
          else
            if ($payment->tendered > 0)
              array_unshift($otherPayments, $payment);
            else
              array_unshift($otherRefunds, $payment);
        }

        return view('admin.reports.closeout')->with('cashPayments', $cashPayments)
                                             ->with('cashRefunds', $cashRefunds)
                                             ->with('cardPayments', $cardPayments)
                                             ->with('cardRefunds', $cardRefunds)
                                             ->with('checkPayments', $checkPayments)
                                             ->with('checkRefunds', $checkRefunds)
                                             ->with('otherPayments', $otherPayments)
                                             ->with('otherRefunds', $otherRefunds)
                                             ->with('paymentUser', $user)
                                             ->withDate($date);
      }
      if ($type == 'transaction-detail')
      {

        $totals = 0;
        foreach ($payments as $payment) {
          if ($payment->sale->refund == false)
            $totals += $payment['tendered'] - $payment['change_due'];
        }

        $totals = number_format($totals, 2);

        return view('admin.reports.transaction-detail')->withPayments($payments)
                                                       ->withTotals($totals)
                                                       ->withPaymentUser($user)
                                                       ->withDate($date);
      }
    }

    public function royalty(Request $request)
    {
      $show = Show::find($request->show);
      $start = Date::createFromTimestamp($request->start)->toDateTimeString();
      $end = Date::createFromTimestamp($request->end)->toDateTimeString();

      $events = Event::where('show_id', $show->id)
                              ->where('start', '>=', $start)
                              ->where('end', '<=', $end)
                              ->orderBy('start', 'asc')
                              ->get();

      $show->eventsIds = array_pluck($events, 'id');

      $show->screenings = $events->count();

      $show->totalAttendance = Ticket::whereIn('event_id', $show->eventsIds);

      $allTicketTypes = TicketType::all();

      // Should free tickets be included in the report?
      $nonFreeTickets = [];
      if (!$request->free) {
        // Find non free tickets
        $nonFreeTickets = TicketType::where('price', '!=', 0)->pluck('id');
        $allTicketTypes = TicketType::whereIn('id', $nonFreeTickets)->get();
        $show->totalAttendance = $show->totalAttendance->whereIn('ticket_type_id', $nonFreeTickets);
      }

      $show->totalAttendance = $show->totalAttendance->count();

      $show->subtotalRevenue = 0;
      $show->totalRevenue = 0;
      $allowedTicketsIds = [];

      // Loop through each event, find how much money it made, sum it
      foreach ($events as $event) {

        $show->subtotalRevenue += round($event->sales->sum('subtotal'), 2);
        $show->totalRevenue += round($event->sales->sum('total'), 2);

        // If we don't want free tickets in the report, take them out
        if (!$request->free) {
          $event->type->allowedTickets = $event->type->allowedTickets->where('price', '!=', 0);
        }

      }

      return view('admin.reports.royalty')->withShow($show)
                                          ->withStart($start)
                                          ->withEnd($end)
                                          ->with('nonFreeTicketsIds', $nonFreeTickets)
                                          ->with('allTicketTypes', $allTicketTypes)
                                          ->withEvents($events);

    }
}
