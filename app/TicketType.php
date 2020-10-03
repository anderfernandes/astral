<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $casts = [
      'public' => 'boolean',
      'price'  => 'double',
      'in_cashier' => 'boolean',
    ];
    
    // This relationship defines what event types certain tickets are allowed
    public function allowedEvents()
    {
      return $this->belongsToMany('App\EventType', 'allowed_ticket_events', 'ticket_type_id', 'event_type_id');
    }
    public function creator()
    {
      return $this->belongsTo('App\User');
    }
}
