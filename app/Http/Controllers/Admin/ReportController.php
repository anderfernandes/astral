<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use App\{ Event, Sale, Ticket, Payment, PaymentMethod, User, Show, Product, ProductType };
use App\{ TicketType, Member, Organization, EventType, OrganizationType };
use Jenssegers\Date\Date;

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
        $users = User::where('id', '!=', 1)->orderBy('firstname', 'asc')->where('staff', true)->pluck('firstname', 'id');
        $users->prepend('All Users', 0);
        $shows = Show::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $organizations = Organization::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $organizations->prepend('All Organizations', 0);
        $organization_types = OrganizationType::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $organization_types->prepend('All Organization Types', 0);
        $event_types = EventType::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $event_types->prepend('All Event Types', 0);
        $ticket_types = TicketType::where('id', '!=', 1)->orderBy('name', 'asc')->pluck('name', 'id');
        $ticket_types->prepend('All Ticket Types', 0);
        $products = Product::orderBy('name', 'asc')->pluck('name', 'id')->prepend('All Products', 0);
        $productTypes = ProductType::orderBy('name', 'asc')->pluck('name', 'id')->prepend('All Product Types', 0);

        return view('admin.reports.index')
                ->withUsers($users)
                ->withOrganizations($organizations)
                ->with('organization_types', $organization_types)
                ->with('ticket_types'      , $ticket_types)
                ->with('event_types'      , $event_types)
                ->with('shows'            , $shows)
                ->with('products'         , $products)
                ->with('productTypes'     , $productTypes);
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

    public function closeout(Request $request)
    {
        $start = Date::createFromTimestamp($request->start)->toDateTimeString();
        $end = Date::createFromTimestamp($request->end)->toDateTimeString();
        $payments = Payment::where([
          ['updated_at', '>=', $start],
          ['updated_at', '<', $end],
          ]);


        // If payment user is not "all users", get the payments for a particular user
        if ($request->user != 0) $payment = $payments->where('cashier_id', $request->user);

        // Get the ids of all the users from the payments collection
        $userIds = $payments->pluck('cashier_id')->unique()->values()->all();

        $payments = $payments->get();
        // Get information on all the users in the payments collecton
        // THIS VARIABLE HAS A COLLECTION WITH ONE OR MORE USERS,
        // DEPENDING ON HOW MANY DIFFERENT USERS ARE IN THE PAYMENT COLLECTION!
        $user = User::whereIn('id', $userIds)->get();

        $cashPayments  = collect([]);
        $cashRefunds   = collect([]);
        $cardPayments  = collect([]);
        $cardRefunds   = collect([]);
        $checkPayments = collect([]);
        $checkRefunds  = collect([]);
        $otherPayments = collect([]);
        $otherRefunds  = collect([]);

        // Get payments of a particular payment_method type
        foreach ($payments as $payment) {
          if ($payment->method->type == 'cash' and $payment->tendered > 0)
            $cashPayments->prepend($payment);
          elseif ($payment->method->type == 'cash' and $payment->tendered < 0)
              $cashRefunds->prepend($payment);
          else if ($payment->method->type == 'card' and $payment->tendered > 0)
            $cardPayments->prepend($payment);
          elseif ($payment->method->type == 'card' and $payment->tendered < 0)
            $cardRefunds->prepend($payment);
          else if ($payment->method->type == 'check' and $payment->tendered > 0)
            $checkPayments->prepend($payment);
          elseif ($payment->method->type == 'check' and $payment->tendered < 0)
            $checkRefunds->prepend($payment);
          else
            if ($payment->tendered > 0)
              $otherPayments->prepend($payment);
            else
              $otherRefunds->prepend($payment);
        }

        $totals = number_format($payments->sum('tendered') - $payments->sum('change_due'), 2);

        return view('admin.reports.closeout')->with('cashPayments', $cashPayments)
                                             ->with('cashRefunds', $cashRefunds)
                                             ->with('cardPayments', $cardPayments)
                                             ->with('cardRefunds', $cardRefunds)
                                             ->with('checkPayments', $checkPayments)
                                             ->with('checkRefunds', $checkRefunds)
                                             ->with('otherPayments', $otherPayments)
                                             ->with('otherRefunds', $otherRefunds)
                                             ->with('paymentUser', $user)
                                             ->with('totals', $totals)
                                             ->withDate($start);
    }

    public function transactionDetail(Request $request)
    {
      $start = Date::createFromTimestamp($request->start)->toDateTimeString();
      $end = Date::createFromTimestamp($request->end)->toDateTimeString();
      $payments = Payment::where([
        ['updated_at', '>=', $start],
        ['updated_at', '<', $end],
        ]);


      // If payment user is not "all users", get the payments for a particular user
      if ($request->user != 0) $payment = $payments->where('cashier_id', $request->user);

      // Get the ids of all the users from the payments collection
      $userIds = $payments->pluck('cashier_id')->unique()->values()->all();

      $payments = $payments->get();
      // Get information on all the users in the payments collecton
      // THIS VARIABLE HAS A COLLECTION WITH ONE OR MORE USERS,
      // DEPENDING ON HOW MANY DIFFERENT USERS ARE IN THE PAYMENT COLLECTION!
      $user = User::whereIn('id', $userIds)->get();

      $totals = number_format($payments->sum('tendered') - $payments->sum('change_due'), 2);

      return view('admin.reports.transaction-detail')->withPayments($payments)
                                                     ->withTotals($totals)
                                                     ->withPaymentUser($user)
                                                     ->withDate($start);
    }

    public function reports(Request $request)
    {
      $user = User::find($request->user);
      $start = Date::createFromTimestamp($request->start)->toDateTimeString();
      $end = Date::createFromTimestamp($request->end)->toDateTimeString();
      $today = Date::now()->startOfDay();

      $sales = Sale::where([
        ['updated_at', '>=', $start],
        ['updated_at', '<', $end]
      ])->orderBy('created_at', 'asc')->get();

      // Get Card Sales IDs
      // $salesIds = array_pluck($sales, 'id');
      // Find all payments for the IDs we retrieved
      //$payments = Payment::where('cashier_id', $id)->whereIn('sale_id', $salesIds)->get();
      $payments = Payment::where([
        ['cashier_id', $id],
        ['updated_at', '>=', $start],
        ['updated_at', '<', $end],
        ])->get();

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

    public function newMembers(Request $request)
    {
      $start = Date::createFromTimestamp($request->start)->toDateTimeString();
      $end = Date::createFromTimestamp($request->end)->toDateTimeString();

      $memberships = Member::where('start', '>=', $start)->where('start', '<=', $end)->get();

      return view('admin.reports.new-members')->withMemberships($memberships)->withStart($start)->withEnd($end);
    }

    public function overall(Request $request)
    {
      $payments = \App\Payment::all();
      $users = \App\User::all();
      $organizations = \App\Organization::all();
      $events = \App\Event::all();
      $sales = \App\Sale::all();
      $tickets = \App\Ticket::all();
      $members = \App\Member::all();
      $shows = \App\Show::all();

      return view('admin.reports.overall')->withPayments($payments)
                                          ->withShows($shows)
                                          ->withMembers($members)
                                          ->withTickets($tickets)
                                          ->withEvents($events)
                                          ->withSales($sales)
                                          ->withOrganizations($organizations)
                                          ->withUsers($users);
    }

    public function attendance(Request $request)
    {
      $start = Date::createFromTimestamp($request->start)->startOfDay()->toDateTimeString();
      $end = Date::createFromTimestamp($request->end)->endOfDay()->toDateTimeString();
      $with_charts = $request->charts == "true";
      $events = null;
      $sales = collect();

      if ($request->data == 0)
      {
        // Varible that will have total tickets
        $tickets_purchased = 0;
        // Collection that will hold all events
        $events = collect();
        // Collection that will hold all sales
        $sales = collect();
        // Event Types
        $event_types = EventType::where('id', '!=', 1)->get();
        // Organizations
        $organizations = Organization::where('id', '!=', 1)->where('type_id', '!=', 1)->get();
        // Get all organization types
        $organization_types = OrganizationType::where('id', '!=', 1)->orderBy('name', 'asc')->get();
        // Loop through all organizations...
        foreach ($organizations as $organization)
        {
          // Loop through organization sales
          foreach ($organization->sales->where('status', 'complete') as $sale)
          {

            foreach ($sale->events->where('start', '>=', $start)->where('end', '<=', $end) as $event)
            {
              $events->push($event);
            }
          }
        }
        $events = $events->pluck('id')->all();
        $events = Event::whereIn('id', $events)->get();
        foreach ($events as $event)
        {

          // Getting the sales for the events whithin the given timeframe
          foreach ($event->sales->where('status', 'complete') as $sale)
          {
            $sales->push($sale);
          }
        }
        // Loop through all the sales that belong to the events filtered above
        $sales = $sales->pluck('id')->unique()->all();
        $sales = Sale::whereIn('id', $sales)->get();
        $revenue = $sales->sum('total');

        foreach ($sales as $sale)
        {
          $tickets_purchased += $sale->tickets->count();
        }

        $view = "";

        if ($request->type == 'attendance_organization')
        {
          $view = 'admin.reports.attendance.organizations';
        }
        else if ($request->type == 'attendance_organization_type')
        {
          $view = 'admin.reports.attendance.organization-types';
        }
        else if ($request->type == 'attendance_event_type')
        {
          $view = 'admin.reports.attendance.event-types';
        }
        else if ($request->type == 'attendance_ticket-type')
        {
          $view = 'admin.reports.attendance.ticket-types';
        }
        // This is a different view from the previous report data

        return view($view)
                  ->withStart($start)
                  ->withEnd($end)
                  ->with('sales', $sales)
                  ->with('events', $events)
                  ->with('tickets_purchased', $tickets_purchased)
                  ->with('revenue', $revenue)
                  ->with('organization_types', $organization_types)
                  ->with('with_charts', $with_charts)
                  ->with('event_types', $event_types)
                  ->withOrganizations($organizations);
      }
      else
      {
        if ($request->type == 'attendance_organization')
        {
          $events = collect();
          $sales = collect();
          $tickets_purchased = 0;
          // Get organization
          $organization = Organization::find($request->data);
          foreach ($organization->events->where('start', '>=', $start)->where('end', '<=', $end) as $event)
          {
            $events->push($event);
            $tickets_purchased += $event->tickets->where('organization_id', $organization->id)->count();

            foreach ($event->sales->where('status', 'complete') as $sale)
            {
              $sales->push($sale);
            }
          }

          return view('admin.reports.attendance.organization')
                  ->withStart($start)
                  ->withEvents($events)
                  ->withSales($sales)
                  ->withEnd($end)
                  ->with('tickets_purchased', $tickets_purchased)
                  ->with('with_charts', $with_charts)
                  ->withOrganization($organization);
        }
        else if ($request->type == 'attendance_organization_type')
        {
            $events = collect();
            $sales = collect();
            $tickets_purchased = 0;
            $organization_type = OrganizationType::find($request->data);
            foreach ($organization_type->organizations as $organization)
            {
              foreach ($organization->events->where('start', '>=', $start)->where('end', '<=', $end) as $event)
              {
                $events->push($event);
              }
            }

            $events = $events->unique('id');

            foreach ($events as $event)
            {
              foreach ($event->sales->where('status', 'complete') as $sale)
              {
                $sales->push($sale);
              }
            }

            $sales = $sales->unique('id');

            foreach ($sales as $sale)
            {
              $tickets_purchased += $sale->tickets->count();
            }

            // This is a different view from the previous report data
            return view('admin.reports.attendance.organization-type')->withStart($start)
                   ->withEnd($end)
                   ->with('events', $events)
                   ->with('sales', $sales)
                   ->with('tickets_purchased', $tickets_purchased)
                   ->with('organization_type', $organization_type);
        }

        else if ($request->type == 'attendance_event_type')
        {
          $tickets_purchased = 0;
          $event_type = EventType::find($request->data);
          $events = Event::where('start', '>=', $start)
                         ->where('end', '<=', $end)
                         ->where('type_id', $event_type->id)
                         ->get();
          foreach ($events as $event)
          {
            //$tickets_purchased = $event->tickets->count();
            foreach ($event->sales->where('status', 'complete') as $sale)
            {
              $sales->push($sale);
              $tickets_purchased += $sale->tickets->where('event_id', $event->id)->count();
            }
          }

          $sales = $sales->unique('id');

          return view('admin.reports.attendance.event-type')->withStart($start)
                                                            ->withEnd($end)
                                                            ->withEvents($events)
                                                            ->with('event_type', $event_type)
                                                            ->with('tickets_purchased', $tickets_purchased)
                                                            ->withSales($sales);

        }

        else if ($request->type = 'attendance_ticket_type')
        {
          $ticket_type = TicketType::find($request->data);
          $events = Event::where('start', '>=', $start)->where('end', '<=', $end)->get();
          $event_types = EventType::all();
          $event_types = $event_types->unique('id');
          $event_ids = Event::where('start', '>=', $start)->where('end', '<=', $end)->pluck('id');
          $tickets = Ticket::where('ticket_type_id', $ticket_type->id)->whereIn('event_id', $event_ids);

          return view('admin.reports.attendance.ticket-type')->withStart($start)
                                                             ->withEnd($end)
                                                             ->with('event_types', $event_types)
                                                             ->withTickets($tickets)
                                                             ->withEvents($events)
                                                             ->with('ticket_type', $ticket_type);
        }
      }
    }

    public function product(Request $request)
    {
      $start = Date::createFromTimestamp($request->start)->toDateTimeString();
      $end = Date::createFromTimestamp($request->end)->toDateTimeString();

      if ($request->data == '0')
      {

          $products = Product::orderBy('name', 'asc')->get();
          return view('admin.reports.product.products')->withProducts($products)
                                                       ->withStart($start)
                                                       ->withEnd($end);

      }

      else
      {
        // Product
        if ($request->type == 'products')
        {
          $product = Product::find($request->data);
          return view('admin.reports.product.product')->withProduct($product)
                                                      ->withStart($start)
                                                      ->withEnd($end);
        }
        // Product Types
        else
        {
          $productType = ProductType::find($request->data);
          return view('admin.reports.product.product_type')->withProductType($productType)
                                                           ->withStart($start)
                                                           ->withEnd($end);
        }

      }
    }
}
