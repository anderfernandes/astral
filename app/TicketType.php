<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    // This relationship defines what event types certain tickets are allowed
    public function allowedEvents()
    {
      return $this->belongsToMany('App\EventType', 'allowed_ticket_events', 'ticket_type_id', 'event_type_id');
    }
}
