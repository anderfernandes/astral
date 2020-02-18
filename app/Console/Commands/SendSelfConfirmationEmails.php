<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SelfConfirmation;
use Illuminate\Support\Facades\Mail;

class SendSelfConfirmationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'astral:send-self-confirmation-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends self confirmation emails according to the configuration in settings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $setting = \App\Setting::find(1);
        $self_confirmation = $setting->self_confirmation;

        if ($self_confirmation)
        {
          $sales = [];

          $this->info("Self confirmation is enabled");
          $self_confirmation_days = $setting->self_confirmation_days;

          $start = now()->startOfDay();
          $end = now()->addDays($self_confirmation_days)->endOfDay();

          $this->info("From {$start->toDateTimeString()} to {$end->toDateTimeString()}");

          $events = \App\Event::where([
            ['start', '>=', $start->toDateTimeString()], 
            ['start', '<=', $end->toDateTimeString()],
          ])->get();

          foreach ($events as $event)
          {
            foreach ($event->sales as $sale)
              array_push($sales, $sale->id);
          }

          $sales = array_unique($sales);

          $sales = \App\Sale::whereIn('id', $sales)->get();

          $sent = 0;


          foreach ($sales as $sale)
          {
            // Will they be emailed everyday?
            if ($sale->status == 'open')
            {

              $cc = $sale->creator_id == 1 ? $setting->email : $sale->creator->email;

              try {
                Mail::to($sale->customer->email)
                ->cc($cc)
                ->send(new SelfConfirmation($sale));

                $sale->memo()->create([
                  'author_id' => 1,
                  'message'   => 'Self confirmation email sent on ' . now()->format('l, F j, Y \a\t g:i A') . '.',
                ]);
  
                $sent++;

              } catch (\Exception $e) {
                $sale->memo()->create([
                  'author_id' => 1,
                  'message'   => 'Unable to send confirmation email. Make sure the address',
                ]);
              }
            }
          }

          $word = $sent == 1 ? 'email' : 'emails';

          $this->info("Sent $sent/$sales->count() $word successfully!");
        } else {
          $this->info('Self confirmations are set as disabled!');
        }
    }
}
