<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
  public function allowedTickets()
  {
    return $this->belongsToMany('App\TicketType', 'allowed_ticket_events', 'event_type_id', 'ticket_type_id')
                 ->where('active', true);
  }
  public function creator()
  {
    return $this->belongsTo('App\User');
  }
  public function events()
  {
    return $this->hasMany('App\Event', 'type_id');
  }
}
