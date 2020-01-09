<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
          $self_confirmation_days = $setting->self_confirmation_days;
          $self_confirmation_time = $setting->self_confirmation_time;

          $start = now()->startOfDay();
          $end = now()->endOfDay();

          $events = \App\Event::where([
            ['start', '>=', $start->toDateTimeString()], 
            ['start', '<=', $end->toDateTimeString()],
          ])->get();

          foreach ($events as $event)
          {
            echo "$start->toDateTimeString()\n";
            echo "$end->toDateTimeString()\n";
            echo "$event->id\n";
          }
        }
    }
}
