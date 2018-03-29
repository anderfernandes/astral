<?php

namespace App\Http\Controllers\Admin;

use App\Mail\ConfirmationLetter;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Jenssegers\Date\Date;
Use Illuminate\Support\Facades\Auth;

use App\Sale;
use App\User;
use App\Organization;
use App\Event;
use App\Show;
use App\Payment;
use App\PaymentMethod;
use App\Ticket;
use App\TicketType;
use App\EventType;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventTypes = EventType::where('id', '!=', 1)->get();

        if (count($request->all()) > 0)
        {
          $sales = Sale::all();

          // If there's a sale number...
          if ($request->saleNumber) {
            $sales = $sales->where('id', $request->saleNumber);
          }
          // If there's a customer...
          if ($request->saleCustomer) {
            $sales = $sales->where('customer_id', $request->saleCustomer);
          }
          // If there's an organization...
          if ($request->saleOrganization) {
            $sales = $sales->where('organization_id', $request->saleOrganization);
          }
          // if there's a sale total...
          if ($request->saleTotal) {
            $sales = $sales->where('total', $request->saleTotal);
          }
          // If there's a cashier...
          if ($request->paymentUser) {
            $sales = $sales->where('creator_id', $request->paymentUser);
          }
          // If there's a sale status
          if ($request->saleStatus) {
            $sales = $sales->where('status', $request->saleStatus);
          }

          $saleIds = $sales->pluck('id');
          $sales = Sale::whereIn('id', $saleIds)->orderBy('id', 'desc')->paginate(50);
        }
        else
        {
          $sales = Sale::orderBy('id', 'desc')->paginate(10);
          $eventTypes = EventType::where('id', '!=', 1)->get();

        }
        return view('admin.sales.index')->withSales($sales)->withEventTypes($eventTypes)->withRequest($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $organizations  = Organization::pluck('name', 'id');
        $events         = Event::where('type_id', $request->eventType)
                               ->where('start', '>=', Date::now()->subDays(7)->toDateTimeString())
                               ->orderBy('start', 'asc')
                               ->get();
        $paymentMethods = PaymentMethod::all();
        $eventType = EventType::find($request->eventType);
        $ticketTypes    = $eventType->allowedTickets;

        /*$customers = $allCustomers->mapWithKeys(function ($item) {
          return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
        });

        /*$events = $allEvents->mapWithKeys(function($item) {
          $show = Show::find($item['show_id'])->name;
          $date = Date::parse($item['start'])->format('l, F j, Y \a\t g:i A');
          return [ $item['id'] => $show .' on '. $date];
        });*/

        return view('admin.sales.create')
          ->withEvents($events)
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods)
          ->withEventType($eventType)
          ->withOrganizations($organizations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

          $this->validate($request, [
            'organization_id'      => 'required',
            'customer_id'          => 'required',
            'status'               => 'required',
            'first_event_id'       => 'min:1|required|different:second_event_id',
            'second_event_id'      => 'min:1',
            'tendered'             => 'numeric',
            'ticket.*'             => 'numeric',
            'memo'                 => 'max:255',
            'sell_to_organization' => 'required',
          ]);

          // Create new sale
          $sale = new Sale;

          $sale->creator_id           = Auth::user()->id;
          $sale->organization_id      = $request->organization_id;
          $sale->customer_id          = $request->customer_id;
          $sale->status               = $request->status;
          $sale->taxable              = $request->taxable;
          $sale->subtotal             = number_format($request->subtotal, 2);
          $sale->tax                  = number_format($request->tax, 2);
          $sale->total                = number_format($request->total, 2);
          $sale->refund               = false;
          $sale->source               = "admin";
          $sale->sell_to_organization = ($request->organization_id == 1) ? false : true;

          $sale->save();

          $sale->events()->attach([$request->first_event_id, $request->second_event_id]);

          if (isSet($request->memo))
          {
            $sale->memo()->create([
              'author_id' => Auth::user()->id,
              'message'   => $request->memo,
              'sale_id'   => $sale->id,
            ]);
          }

          if (isSet($request->payment_method_id) && ($request->tendered > 0)) {

            // Create new payment
            $payment = new Payment;

            $payment->cashier_id        = Auth::user()->id;
            $payment->payment_method_id = $request->payment_method_id;
            // Tendered may be nullable if the customer hasn't paid
            $payment->tendered          = number_format($request->tendered, 2);
            $payment->total             = number_format($request->total, 2);
            // payment = total - tendered (precision set to two decimal places)
            $payment->change_due        = number_format($request->change_due, 2);
            $payment->reference         = $request->reference;
            $payment->source            = 'admin';
            $payment->sale_id           = $sale->id;

            $payment->save();

          }

          // Mark sale as completed if it has been paid in full
          if ($sale->payments->sum('tendered') >= $sale->total) {
            $sale->status = "complete";
            $sale->save();
          }

          // Holds the tickets coming from the request
          $firstShowTickets  = [];

          // Create array with all tickets for the first show if the amount of
          // tickets for a ticket type is not zero
          foreach($request->ticket as $key => $value) {
            for($i = 1; $i <= $value; $i++) {
              $array['ticket_type_id'] = $key;
              $array['event_id']       = $request->first_event_id;
              $array['customer_id']    = $request->customer_id;
              $array['cashier_id']     = Auth::user()->id;

              $firstShowTickets = array_prepend($firstShowTickets, $array);
            }
          }

          /*********************************************************************
          A NOTE ON TICKET UPDATES!
          Tickets are not actually updated because their number may change.
          The previous tickets created are deleted and new ones are created
          every time a sale is updated to ensure that each ticket has the right
          event, sale number and owner.
          *********************************************************************/

          // Add first show tickets to the database
          $sale->tickets()->createMany($firstShowTickets);

          // add second show tickets if a second show exists
          if ($request->second_event_id != 1) {
            // If it does, create and array with all the tickets for the second
            // show if the amount of tickets for a ticket type is not zero

            // Create array with second show tickets
            $secondShowTickets = [];

            // Populate the array
            foreach($request->ticket as $key => $value) {
              for($i = 1; $i <= $value; $i++) {
                $array['ticket_type_id'] = $key;
                $array['event_id'] = $request->second_event_id;
                $array['customer_id'] = $request->customer_id;
                $array['cashier_id'] = Auth::user()->id;
                $secondShowTickets = array_prepend($secondShowTickets, $array);
              }
            }

            // Save to the database
            $sale->tickets()->createMany($secondShowTickets);
          }

          // Email customer with copies to management
          // Mail::to($sale->customer->email)->bcc('planetarium.webmaster@ctcd.edu')
          //                                ->send(new ConfirmationLetter($sale));

          Session::flash('success', '<strong>Sale #'. $sale->id .'</strong> created successfully!');

          return redirect()->route('admin.sales.show', $sale);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $paid = number_format($sale->payments->sum('tendered') - $sale->payments->sum('change_due'), 2);
        $balance = number_format(($sale->payments->sum('tendered') - $sale->payments->sum('change_due')) - $sale->total, 2);
        $memos = \App\SaleMemo::where('sale_id', $sale->id)->orderBy('updated_at', 'desc')->get();
        return view('admin.sales.show')->withSale($sale)
                                       ->withPaid($paid)
                                       ->withMemos($memos)
                                       ->withBalance($balance);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $organizations = Organization::pluck('name', 'id');
        $events    = Event::where('type_id', $sale->events[0]->type->id)->orderBy('start', 'asc')->get();
        $paymentMethods = PaymentMethod::all();
        $ticketTypes = $sale->events[0]->type->allowedTickets;

        // $customers = $allCustomers->mapWithKeys(function ($item) {
        //   return [ $item['id'] => $item['firstname'].' '.$item['lastname']];
        // });

        return view('admin.sales.edit')
          ->withEvents($events)
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods)
          ->withOrganizations($organizations)
          ->withSale($sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {

        $this->validate($request, [
          'organization_id'      => 'required',
          'customer_id'          => 'required',
          'status'               => 'required',
          'first_event_id'       => 'required|different:second_event_id',
          'tendered'             => 'numeric',
          'ticket.*'             => 'numeric',
          'memo'                 => 'required|max:255',
          'sell_to_organization' => 'required',
        ]);

        // If the event(s) for this sale change, delete tickets that belong to the old event
        if (isSet($request->first_event_id)) {
          if ($sale->events[0]->id != $request->first_event_id) {
            // Delete old tickets created
            $sale->tickets()->delete();

            // Store updated tickets in the database

            // Holds the tickets coming from the request
            $firstShowTickets  = [];

            // Create array with all tickets for the first show if the amount of
            // tickets for a ticket type is not zero
            foreach($request->ticket as $key => $value) {
              for($i = 1; $i <= $value; $i++) {
                $array['ticket_type_id'] = $key;
                $array['event_id']       = $request->first_event_id;
                $array['customer_id']    = $request->customer_id;
                $array['cashier_id']     = Auth::user()->id;

                $firstShowTickets = array_prepend($firstShowTickets, $array);
              }
            }

            // Update first show tickets to the database
            $sale->tickets()->createMany($firstShowTickets);
          }
        }

        if ($request->second_event_id != 1) {
          if ($sale->events[1]->id != $request->second_event_id) {
            // If it does, create and array with all the tickets for the second
            // show if the amount of tickets for a ticket type is not zero

            // Create array with second show tickets
            $secondShowTickets = [];

            // Populate the array
            foreach($request->ticket as $key => $value) {
              for($i = 1; $i <= $value; $i++) {
                $array['ticket_type_id'] = $key;
                $array['event_id'] = $request->second_event_id;
                $array['customer_id'] = $request->customer_id;
                $array['cashier_id'] = Auth::user()->id;
                $secondShowTickets = array_prepend($secondShowTickets, $array);
              }
            }

            // Save to the database
            $sale->tickets()->createMany($secondShowTickets);
          }
        }

        $sale->organization_id      = $request->organization_id;
        $sale->customer_id          = $request->customer_id;
        $sale->status               = $request->status;
        $sale->taxable              = $request->taxable;
        $sale->subtotal             = number_format($request->subtotal, 2);
        $sale->tax                  = number_format($request->tax, 2);
        $sale->total                = number_format($request->total, 2);
        $sale->refund               = false;
        //$sale->memo                 = $request->memo;
        $sale->sell_to_organization = $request->sell_to_organization;

        $sale->save();

        $sale->events()->detach();

        $sale->events()->attach([$request->first_event_id, $request->second_event_id]);

        if (isSet($request->memo))
        {
          $sale->memo()->create([
            'author_id' => Auth::user()->id,
            'message'   => $request->memo,
            'sale_id'   => $sale->id,
          ]);
        }

        if (isSet($request->payment_method_id) && ($request->tendered > 0)) {

          // Create new payment
          $payment = new Payment;

          $payment->cashier_id        = Auth::user()->id;
          $payment->payment_method_id = $request->payment_method_id;
          // Tendered may be nullable if the customer hasn't paid
          $payment->tendered          = number_format($request->tendered, 2);
          $payment->total             = number_format($request->total, 2);
          // payment = total - tendered (precision set to two decimal places)
          $payment->change_due        = number_format($request->change_due, 2);
          $payment->reference         = $request->reference;
          $payment->source            = 'admin';
          $payment->sale_id           = $sale->id;

          $payment->save();

        }

        // Mark sale as completed if it has been paid in full
        if ($sale->payments->sum('tendered') >= $sale->total) {
          $sale->status = "complete";
          $sale->save();
        }

        // Update tickets only if its number changes
        if (array_sum($request->ticket) != $sale->tickets->count()) {
          // Delete old tickets created
          $sale->tickets()->delete();

          // Store updated tickets in the database

          // Holds the tickets coming from the request
          $firstShowTickets  = [];

          // Create array with all tickets for the first show if the amount of
          // tickets for a ticket type is not zero
          foreach($request->ticket as $key => $value) {
            for($i = 1; $i <= $value; $i++) {
              $array['ticket_type_id'] = $key;
              $array['event_id']       = $request->first_event_id;
              $array['customer_id']    = $request->customer_id;
              $array['cashier_id']     = Auth::user()->id;

              $firstShowTickets = array_prepend($firstShowTickets, $array);
            }
          }

          // Update first show tickets to the database
          $sale->tickets()->createMany($firstShowTickets);
        }

        // Check if a second show exists
        if ($request->second_event_id != 1) {
          // If it does, create and array with all the tickets for the second
          // show if the amount of tickets for a ticket type is not zero

          // Create array with second show tickets
          $secondShowTickets = [];

          // Populate the array
          foreach($request->ticket as $key => $value) {
            for($i = 1; $i <= $value; $i++) {
              $array['ticket_type_id'] = $key;
              $array['event_id'] = $request->second_event_id;
              $array['customer_id'] = $request->customer_id;
              $array['cashier_id'] = Auth::user()->id;
              $secondShowTickets = array_prepend($secondShowTickets, $array);
            }
          }

          // Save to the database
          $sale->tickets()->createMany($secondShowTickets);
        }

        Session::flash('success', '<strong>Sale #'. $sale->id .'</strong> updated successfully!');

        return redirect()->route('admin.sales.show', $sale);

        //dd(array_sum($request->ticket));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }

    // THIS METHODS REFUNDS SALES, NOT PAYMENTS
    public function refund(Request $request, Sale $sale)
    {
      // Pending server side validation

      $sale->refund = true;
      $sale->memo()->create([
        'author_id' => Auth::user()->id,
        'message'   => $request->memo,
        'sale_id'   => $sale->id,
      ]);

      // Add a negative payment of the sum of payments for this sale to even out

      $refund =  new Payment([
        'cashier_id'        => Auth::user()->id,
        'payment_method_id' => $sale->payments[0]->payment_method_id,
        'tendered'          => - number_format($sale->payments->sum('tendered'), 2),
        'total'             => - number_format($sale->payments->sum('total'), 2),
        'change_due'        => - number_format($sale->payments->sum('change_due'), 2),
        'source'            => 'admin',
        'sale_id'           => $sale->id,
        'refunded'          => false,
      ]);

      $sale->payments()->save($refund);

      $sale->status = "complete";

      $sale->tickets()->delete();

      $sale->save();


      Session::flash('success',
          '<strong>Sale # '.$sale->id.'</strong> has been refunded successfully!');

      return redirect()->route('admin.sales.show', $sale);
    }

    // THIS METHOD REFUNDS INDIVIDUAL PAYMENTS, NOT SALES
    public function refundPayment(Payment $payment)
    {

      $refund = new Payment;

      $sale = Sale::find($payment->sale_id);

      $refund->cashier_id        = Auth::user()->id;
      $refund->payment_method_id = $payment->payment_method_id;
      // Tendered may be nullable if the customer hasn't paid
      $refund->tendered          = - number_format($payment->tendered, 2);
      $refund->total             = - number_format($payment->total, 2);
      // payment = total - tendered (precision set to two decimal places)
      $refund->change_due        = - number_format($payment->change_due, 2);
      $refund->reference         = $payment->reference;
      $refund->source            = 'admin';
      $refund->sale_id           = $payment->sale_id;
      $refund->refunded          = false;

      $refund->save();

      // Mark a payment that has been refunded and such
      $payment->refunded = true;
      $payment->save();

      Session::flash('success',
          '<strong>Payment # ' . $refund->id . '</strong> has been refunded successfully!');

      return redirect()->route('admin.sales.show', $payment->sale_id);

    }

    public function confirmation(Sale $sale)
    {
      return view('admin.sales.confirmation')->withSale($sale);
    }

    public function invoice(Sale $sale)
    {
      return view('admin.sales.invoice')->withSale($sale);
    }

    public function receipt(Sale $sale)
    {
      return view('admin.sales.receipt')->withSale($sale);
    }

    public function cancelation(Sale $sale)
    {
      return view('admin.sales.cancelation')->withSale($sale);
    }

    public function mail(Request $request, Sale $sale)
    {
      // Email customer with copies to management
      Mail::to($sale->customer->email)->bcc('planetarium.webmaster@ctcd.edu')
                                      ->send(new ConfirmationLetter($sale));
      // Write memo
      $sale->memo()->create([
        'author_id' => Auth::user()->id,
        'message'   => 'I sent a confirmation letter to this group on ' . Date::now()->format('l, F j, Y \a\t g:i A') . '.',
      ]);
      Session::flash('success', '<strong>Confirmation Letter</strong> successfully sent to <strong>' . $sale->customer->email . '</strong>!');
      return redirect()->route('admin.sales.show', $sale);
    }

}
