<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Mail\ConfirmationLetter;

// Helpers
use Session;
use PDF;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\{ Log, Auth, Mail };


// Models
use App\{ Sale, User, Organization, Event, Show, Payment, PaymentMethod };
use App\{ Ticket, TicketType, EventType, Product };



class SaleController extends Controller
{
    /**
     * Display a of Sales.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventTypes = EventType::where('id', '!=', 1)->get();

        if (count($request->all()) > 0)
        {
          $sales = Sale::take(500);

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
          // Do not limit search results so that we can find old sales
          $sales = $sales->orderBy('id', 'desc')->paginate(10);
        }
        else
        {
          // Get only 500 sales to avoid querying data that won't be used
          // MAKE THIS A VALUE DEFINED BY THE USER IN THE FUTURE
          //$salesIds = Sale::take(-100)->pluck('id');

          //$sales = Sale::whereIn('id', $salesIds)->orderBy('id', 'desc')->paginate(10);
          $sales = Sale::orderBy('id', 'desc')->paginate(10);
        }

        // if app.force_https is true, make pagination links have https in them

        if (config('app.force_https'))
        {
          $shows->setPath('/admin/sales');
        }

        return view('admin.sales.index')->withSales($sales)->withEventTypes($eventTypes)->withRequest($request);
    }

    /**
     * Show the form for creating a new Sale.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $paymentMethods = PaymentMethod::all();
        $eventType      = EventType::find($request->eventType);
        $ticketTypes    = $eventType->allowedTickets;
        $products       = Product::where('active', true)->get();
        $grades         = \App\Grade::all();

        return view('admin.sales.create')
          ->withGrades($grades)
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods)
          ->withEventType($eventType)
          ->withProducts($products);
    }

    /**
     * Store a newly created Sale in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

          $this->validate($request, [
            'status'                          => 'required',
            'sell_to_organization'            => 'required|boolean',
            'customer_id'                     => 'required|integer',
            'events.*.date'                   => 'required|date',
            'events.*.id'                     => 'required|integer',
            'events.*.tickets.*.quantity'     => 'integer|min:0',
            'events.*.tickets.*.type_id'      => 'integer',
            'products.*.quantity'             => 'integer|min:0',
            'products.*.type_id'              => 'integer',
            'taxable'                         => 'required',
            'payment_method_id'               => 'string|nullable',
            'tendered'                        => 'numeric',
            'change_due'                      => 'numeric',
            'memo'                            => 'max:255',

          ]);

          // Filtering numbers to ensure formating
          $request->subtotal = str_replace(",", "", $request->subtotal);
          $request->tax      = str_replace(",", "", $request->tax);
          $request->total    = str_replace(",", "", $request->total);

          // Get user's organization
          $user = User::find($request->customer_id);

          // Create new sale
          $sale = new Sale;

          $sale->creator_id           = Auth::user()->id;
          $sale->organization_id      = $user->organization->id;
          $sale->customer_id          = $request->customer_id;
          $sale->status               = $request->status;
          $sale->taxable              = $request->taxable;
          $sale->subtotal             = number_format($request->subtotal, 2, '.', '');
          $sale->tax                  = number_format($request->tax, 2, '.', '');
          $sale->total                = number_format($request->total, 2, '.', '');
          $sale->refund               = false;
          $sale->source               = "admin";
          $sale->sell_to_organization = ($request->organization_id == "0");

          $sale->save();

          // Create an array with event ids that are not a "no event" and add them to the DB

          $eventsArray = [];

          foreach ($request->events as $event) {
            if ($event['id'] != "1") {
              array_push($eventsArray, $event['id']);
            }
          }

          $sale->events()->attach($eventsArray);

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
            $payment->tendered          = number_format($request->tendered, 2, '.', '');
            $payment->total             = number_format($request->total, 2, '.', '');
            // payment = total - tendered (precision set to two decimal places)
            $payment->change_due        = number_format($request->change_due, 2, '.', '');
            $payment->reference         = $request->reference;
            $payment->source            = 'admin';

            $sale->payments()->save($payment);

            // Log created payment
            Log::info(Auth::user()->fullname . ' added Payment #' . $payment->id . ' to Sale #' . $sale->id .' using admin');

          }

          // Mark sale as completed if it has been paid in full
          if ($sale->status != 'canceled') {
            if ($sale->payments->sum('tendered') >= $sale->total) {
              $sale->status = "complete";
              $sale->save();
            }
          }

          $tickets = [];

          foreach ($request->events as $event) {
            // Do not create tickets for "No Event" events
            if ($event['id'] != 1) {
              foreach ($event['tickets'] as $ticket) {
                // Create the amount of tickets in the amount field if quantity is greater than 0
                if ((int)$ticket['quantity'] > 0) {
                  for ($i = 1; $i <= (int)$ticket['quantity']; $i++) {
                    $tickets = array_prepend($tickets, [
                      'ticket_type_id'  => $ticket['type_id'],
                      'event_id'        => $event['id'],
                      'customer_id'     => $request->customer_id,
                      'cashier_id'      => Auth::user()->id,
                      'organization_id' => $user->organization_id,
                    ]);
                  }
                }
              }
            }
          }

          $sale->tickets()->createMany($tickets);

          // Add Products to sale

          // Take out products with 0 quantity

          $productsArray = [];

          foreach ($request->products as $product) {
            if ((int)$product['quantity'] > 0) {
              // Add product quantities
              for ($i = 1; $i <= $product['quantity']; $i++)
              {
                array_push($productsArray, $product['id']);
              }
            }
          }

          $sale->products()->attach($productsArray);

          // Attaching Grades if they exist
          if (isSet($request->grades))
          {
            if (count($request->grades) > 0)
            {
              $sale->grades()->attach($request->grades);
            }
          }

          // Attaching an Organization to an Event
          $sale->organization->events()->attach($eventsArray);

          Session::flash('success', "<strong>Sale #{$sale->id}</strong> created successfully!");

          // Log created sale
          Log::info(Auth::user()->fullname . ' created Sale #' . $sale->id .' using admin');

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
        $paid = number_format($sale->payments->sum('tendered') - $sale->payments->sum('change_due'), 2, '.', ',');
        $balance = number_format(($sale->payments->sum('tendered') - $sale->payments->sum('change_due')) - $sale->total, 2, '.', '');
        $memos = \App\SaleMemo::where('sale_id', $sale->id)->orderBy('updated_at', 'desc')->get();

        if ($sale->memos->count() > 0) {
          if ($sale->memos->count() == 1) {
            Session::flash('info', "This sale <strong>has {$sale->memos->count()}</strong> memo. <a href='#memos'>Click here</a> to read it.");
          }
          else {
            Session::flash('info', "This sale <strong>has {$sale->memos->count()}</strong> memos. <a href='#memos'>Click here</a> to read them.");
          }
        }

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
        $paymentMethods = PaymentMethod::all();
        $eventType      = EventType::find($sale->events[0]->type_id ?? 1);
        $ticketTypes    = $eventType->allowedTickets;
        $products       = Product::where('active', true)->get();
        $grades         = \App\Grade::all();
        $events         = [];

        foreach($sale->events as $event)
        {
          $event = Event::whereDate('start', $event->start->format('Y-m-d'))->get();
          array_push($events, $event);
        }

        //dd($events);

        return view('admin.sales.edit')
          ->withEvents($events)
          ->withGrades($grades)
          ->withTicketTypes($ticketTypes)
          ->withPaymentMethods($paymentMethods)
          ->withEventType($eventType)
          ->withProducts($products)
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
        'status'                          => 'required',
        'sell_to_organization'            => 'required|boolean',
        'customer_id'                     => 'required|integer',
        'events.*.date'                   => 'required|date',
        'events.*.id'                     => 'required|integer|distinct',
        'events.*.tickets.*.quantity'     => 'integer|min:0',
        'events.*.tickets.*.type_id'      => 'integer',
        'products.*.quantity'             => 'integer|min:0',
        'products.*.type_id'              => 'integer',
        'taxable'                         => 'required',
        'payment_method_id'               => 'string|nullable',
        'tendered'                        => 'numeric',
        'change_due'                      => 'numeric',
        'memo'                            => 'max:255',
      ]);

      // Filtering numbers to ensure formating
      $request->subtotal = str_replace(",", "", $request->subtotal);
      $request->tax      = str_replace(",", "", $request->tax);
      $request->total    = str_replace(",", "", $request->total);

      // Get user's organization
      $user = User::find($request->customer_id);

      $sale->organization_id      = $user->organization->id;
      $sale->customer_id          = $request->customer_id;
      $sale->status               = $request->status;
      $sale->taxable              = $request->taxable;
      $sale->subtotal             = number_format($request->subtotal, 2, '.', '');
      $sale->tax                  = number_format($request->tax, 2, '.', '');
      $sale->total                = number_format($request->total, 2, '.', '');
      $sale->refund               = false;
      $sale->source               = "admin";
      $sale->sell_to_organization = (bool)$request->sell_to_organization;

      $sale->save();

      // Detach sales from events regardless if they were changed or not
      $sale->events()->detach($sale->events->pluck('id')->all());

      $eventsArray = [];

      foreach ($request->events as $event) {
        if ($event['id'] != "1") {
          array_push($eventsArray, $event['id']);
        }
      }

      // Attach Events to a Sale
      $sale->events()->attach($eventsArray);

      // Check if there's a memo. If there is, add it to the database
      if (isSet($request->memo))
      {
        $sale->memo()->create([
          'author_id' => Auth::user()->id,
          'message'   => $request->memo,
        ]);
      }

      if (isSet($request->payment_method_id) && ($request->tendered > 0)) {

        // Create new payment
        $payment = new Payment;

        $payment->cashier_id        = Auth::user()->id;
        $payment->payment_method_id = $request->payment_method_id;
        // Tendered may be nullable if the customer hasn't paid
        $payment->tendered          = number_format($request->tendered, 2, '.', '');
        $payment->total             = number_format($request->total, 2, '.', '');
        // payment = total - tendered (precision set to two decimal places)
        $payment->change_due        = number_format($request->change_due, 2, '.', '');
        $payment->reference         = $request->reference;
        $payment->source            = 'admin';

        $sale->payments()->save($payment);

        // Log created payment
        Log::info(Auth::user()->fullname . ' added Payment #' . $payment->id . ' to Sale #' . $sale->id .' using admin');

      }

      // Mark sale as completed if it has been paid in full
      if ($sale->status != 'canceled') {
        if ($sale->payments->sum('tendered') >= $sale->total) {
          $sale->status = "complete";
          $sale->save();
        }
      }

      // Delete tickets
      $sale->tickets()->delete();

      $tickets = [];

      // If it is the same, don't do anything
      // Else, see if we need to add or remove
      // If we need to add, figure out how many and add
      // Else, delete the amount of tickets we have extra

      foreach ($request->events as $event) {
        // Do not create tickets for "No Event" events
        if ($event['id'] != 1) {
          foreach ($event['tickets'] as $ticket) {
            // Create the amount of tickets in the amount field if quantity is greater than 0
            if ((int)$ticket['quantity'] > 0) {
              for ($i = 1; $i <= (int)$ticket['quantity']; $i++) {
                $tickets = array_prepend($tickets, [
                  'ticket_type_id'  => $ticket['type_id'],
                  'event_id'        => $event['id'],
                  'customer_id'     => $request->customer_id,
                  'cashier_id'      => Auth::user()->id,
                  'organization_id' => $user->organization_id,
                ]);
              }
            }
          }
        }
      }

      $sale->tickets()->createMany($tickets);

      // Remove products from sale

      $sale->products()->detach($sale->products->pluck('id')->all());

      // Add Products to Sale

      // Take out products with 0 quantity

      $productsArray = [];

      foreach ($request->products as $product) {
        if ((int)$product['quantity'] > 0) {

          // Add product quantities
          for ($i = 1; $i <= $product['quantity']; $i++)
          {
            array_push($productsArray, $product['id']);
          }

          // Update product stock
          $p = Product::find($product['id']);
          $p->stock = $p->stock - $product['quantity'];
          $p->save();
        }
      }

      $sale->products()->attach($productsArray);

      // Grades
      $sale->grades()->detach();

      // Attaching Grades if they exist
      if (isSet($request->grades))
      {
        if (count($request->grades) > 0)
        {
          $sale->grades()->attach($request->grades);
        }
      }

      // Detaching Events from Organization
      $sale->organization->events()->detach();

      // Attaching an Organization to an Event
      $sale->organization->events()->attach($eventsArray);

      Session::flash('success', '<strong>Sale #'. $sale->id .'</strong> updated successfully!');

      // Log edited sale
      Log::info(Auth::user()->fullname . ' edited Sale #' . $sale->id .' using admin');
      return redirect()->route('admin.sales.show', $sale);

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

      $sale->status != 'canceled' ? 'complete' : 'canceled';

      $sale->tickets()->delete();

      $sale->save();


      Session::flash('success',
        "<strong>Sale #{$sale->id} </strong> has been refunded successfully!");

      // Log created sale
      Log::info(Auth::user()->fullname . ' refunded Sale #' . $sale->id .' using admin');

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
      $refund->tendered          = - number_format($payment->tendered, 2, '.', '');
      $refund->total             = - number_format($payment->total, 2, '.', '');
      // payment = total - tendered (precision set to two decimal places)
      $refund->change_due        = - number_format($payment->change_due, 2, '.', '');
      $refund->reference         = $payment->reference;
      $refund->source            = 'admin';
      $refund->sale_id           = $payment->sale_id;
      $refund->refunded          = false;

      $refund->save();

      // Mark a payment that has been refunded and such
      $payment->refunded = true;
      $payment->save();

      Session::flash('success',
          "<strong>Payment #{$refund->id}</strong> has been refunded successfully!");

      // Log refunded payment
      Log::info(Auth::user()->fullname . ' refunded Payment #' . $payment->id . ' which belongs to Sale #' . $sale->id .' using admin');

      return redirect()->route('admin.sales.show', $payment->sale_id);

    }

    public function confirmation(Sale $sale, Request $request)
    {
      if ($request->format == 'pdf')
      {
        return PDF::loadView('pdf.confirmation', ['sale' => $sale])
                  ->stream("Astral - Confirmation #$sale->id.pdf");
      }
      else
      {
        return view('admin.sales.confirmation')->withSale($sale);
      }
    }

    public function invoice(Sale $sale, Request $request)
    {
      if ($request->format == 'pdf')
      {
        return PDF::loadView('pdf.invoice', ['sale' => $sale])
                  ->stream("Astral - Invoice #$sale->id.pdf");
      }
      else
      {
        return view('admin.sales.invoice')->withSale($sale);
      }

    }

    public function receipt(Sale $sale, Request $request)
    {
      if ($request->format == 'pdf')
      {
        return PDF::loadView('pdf.receipt', ['sale' => $sale])
                  ->stream("Astral - Receipt #$sale->id.pdf");
      }
      else
      {
        return view('admin.sales.receipt')->withSale($sale);
      }
    }

    public function cancelation(Sale $sale, Request $request)
    {
      if ($request->format == 'pdf')
      {
        return PDF::loadView('pdf.cancelation', ['sale' => $sale])
                  ->stream("Astral - Cancelation - Sale #$sale->id.pdf");
      }
      else
      {
        return view('admin.sales.cancelation')->withSale($sale);
      }
    }

    public function mail(Request $request, Sale $sale)
    {
      try {
        // Email customer with copies to the person who clicked the send button
        Mail::to($sale->customer->email)->bcc(Auth::user()->email)
                                        ->send(new ConfirmationLetter($sale));
      } catch (\Exception $exception) {
        $request->session()->flash('warning', "<strong>Failed to email confirmation letter. Please send it manually.</strong>");
        Log::info(Auth::user()->fullname . ' - Failed to email confirmation letter.');
        return redirect()->route('admin.sales.show', $sale);
      }

      // Write memo
      $sale->memo()->create([
        'author_id' => Auth::user()->id,
        'message'   => 'I sent a confirmation letter to ' . $sale->customer->email . ' on ' . Date::now()->format('l, F j, Y \a\t g:i A') . '.',
      ]);

      Session::flash('success', '<strong>Confirmation Letter</strong> successfully sent to <strong>' . $sale->customer->email . '</strong>!');

      $customer = $sale->customer->fullname == $sale->organization->name ? $sale->organization->name : $sale->customer->name;

      // Log email sent
      Log::info(Auth::user()->fullname . ' sent a Confirmation letter to ' . $customer .' using admin');

      return redirect()->route('admin.sales.show', $sale);
    }

    /**
     * Routes user to a page with all tickets that belong to this sale
     * @param  Sale   $sale Number of the Sale
     * @return void         This function doesn't return anything
     */
    public function tickets(Sale $sale)
    {
      $organization = \App\Setting::find(1);
      return view('admin.tickets.tickets')->withSale($sale)
                                          ->withOrganization($organization);
    }

}
