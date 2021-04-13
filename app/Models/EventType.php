<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
      'public' => 'boolean',
    ];
  
      /**
       * The tickets allowed to be sold in an event type.
       *
       * @return array
       */
      public function allowedTickets()
      {
          return $this->belongsToMany(
          'App\Models\TicketType',
          'allowed_ticket_events',
          'event_type_id',
          'ticket_type_id'
      )
        ->where('active', true);
      }
  
      /**
       * Gets the user who created an event type.
       *
       * @return array
       */
      public function creator()
      {
          return $this->belongsTo('App\User');
      }
  
      /**
       * Gets the events tagged with a ticket type.
       *
       * @return array
       */
      public function events()
      {
          return $this->hasMany('App\Models\Event', 'type_id');
      }

}
