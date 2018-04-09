<?php

use Illuminate\Database\Seeder;

class TicketTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /* 1
      DB::table('ticket_types')->insert([
        'name'          => 'Adult Weekend',
        'description'   => 'Adult Weekend ticket',
        'active'        => 'true',
        'event_type_id' => 3,
        'price'         => 7.00,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 2
      DB::table('ticket_types')->insert([
        'name'          => 'Children Weekend',
        'description'   => 'Children Weekend ticket',
        'active'        => 'true',
        'event_type_id' => 3,
        'price'         => 6.00,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]);
      // 3
      DB::table('ticket_types')->insert([
        'name'          => 'Matinee',
        'description'   => 'Matinee ticket',
        'active'        => 'true',
        'event_type_id' => 2,
        'price'         => 5.00,
        'created_at'    => Date::now('America/Chicago')->toDateTimeString(),
      ]); */


      $member = new App\TicketType;

      $member->name        = "Member";
      $member->price       = 0;
      $member->active      = true;
      $member->description = "Member tickets for all event types";
      $member->creator_id  = 1;
      $member->in_cashier  = true;

      $member->save();

      $member->allowedEvents()->attach([2, 3, 4]);

      /************************************************************************/

      $matinee = new App\TicketType;

      $matinee->name        = "Matinee";
      $matinee->price       = 5;
      $matinee->active      = true;
      $matinee->description = "Matinee unique price ticket, adult or child";
      $matinee->creator_id  = 1;
      $member->in_cashier  = true;

      $matinee->save();

      $matinee->allowedEvents()->attach([2]);

      /************************************************************************/

      $adult = new App\TicketType;

      $adult->name        = "Adult";
      $adult->price       = 7;
      $adult->active      = true;
      $adult->description = "Adult tickets for Weekend shows";
      $adult->creator_id  = 1;
      $member->in_cashier  = true;

      $adult->save();

      $adult->allowedEvents()->attach([3]);

      /************************************************************************/

      $child = new App\TicketType;

      $child->name        = "Child";
      $child->price       = 6;
      $child->active      = true;
      $child->description = "Adult tickets for Weekend shows";
      $child->creator_id  = 1;
      $member->in_cashier  = true;

      $child->save();

      $child->allowedEvents()->attach([3]);
    }
}
