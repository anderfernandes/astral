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
    $member->public      = true;

    $member->save();

    $member->allowedEvents()->attach([2, 3, 4]);

    /************************************************************************/

    $matinee = new App\TicketType;

    $matinee->name        = "Matinee";
    $matinee->price       = 5;
    $matinee->active      = true;
    $matinee->description = "Matinee unique price ticket, adult or child";
    $matinee->creator_id  = 1;
    $matinee->in_cashier  = true;
    $matinee->public      = true;

    $matinee->save();

    $matinee->allowedEvents()->attach([2]);

    /************************************************************************/

    $adult = new App\TicketType;

    $adult->name        = "Adult";
    $adult->price       = 7;
    $adult->active      = true;
    $adult->description = "Adult tickets for Weekend shows";
    $adult->creator_id  = 1;
    $adult->in_cashier  = true;
    $adult->public      = true;

    $adult->save();

    $adult->allowedEvents()->attach([3]);

    /************************************************************************/

    $child = new App\TicketType;

    $child->name        = "Child";
    $child->price       = 6;
    $child->active      = true;
    $child->description = "Adult tickets for Weekend shows";
    $child->creator_id  = 1;
    $child->in_cashier  = true;
    $child->public      = true;

    $child->save();

    $child->allowedEvents()->attach([3]);

    /************************************************************************/

    $student = new App\TicketType;

    $student->name        = "Student";
    $student->price       = 5;
    $student->active      = true;
    $student->description = "Student tickets";
    $student->creator_id  = 1;
    $student->in_cashier  = true;
    $student->public      = false;

    $student->save();

    $student->allowedEvents()->attach([5]);

    /************************************************************************/

    $studentMultishow = new App\TicketType;

    $studentMultishow->name        = "Multishow Student";
    $studentMultishow->price       = 4;
    $studentMultishow->active      = true;
    $studentMultishow->description = "Student Multishow tickets";
    $studentMultishow->creator_id  = 1;
    $studentMultishow->in_cashier  = true;
    $studentMultishow->public      = false;

    $studentMultishow->save();

    $studentMultishow->allowedEvents()->attach([5]);

    /************************************************************************/

    $teacher = new App\TicketType;

    $teacher->name        = "Teacher";
    $teacher->price       = 0;
    $teacher->active      = true;
    $teacher->description = "Teacher tickets";
    $teacher->creator_id  = 1;
    $teacher->in_cashier  = true;
    $teacher->public      = false;

    $teacher->save();

    $teacher->allowedEvents()->attach([5]);

    /************************************************************************/

    $parent = new App\TicketType;

    $parent->name        = "Parent";
    $parent->price       = 5;
    $parent->active      = true;
    $parent->description = "Parent tickets";
    $parent->creator_id  = 1;
    $parent->in_cashier  = true;
    $parent->public      = false;

    $parent->save();

    $parent->allowedEvents()->attach([5]);

    /************************************************************************/

    $parentMultishow = new App\TicketType;

    $parentMultishow->name        = "Multishow Parent";
    $parentMultishow->price       = 4;
    $parentMultishow->active      = true;
    $parentMultishow->description = "Parent Multishow tickets";
    $parentMultishow->creator_id  = 1;
    $parentMultishow->in_cashier  = true;
    $parentMultishow->public      = false;

    $parentMultishow->save();

    $parentMultishow->allowedEvents()->attach([5]);
  }
}
