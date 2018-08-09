<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $fillable = ['ticket_type_id', 'event_id', 'customer_id', 'cashier_id', 'organization_id'];

    public function sale()
    {
      return $this->belongsTo('App\Sale');
    }

    public function event()
    {
      return $this->belongsTo('App\Event');
    }

    public function type()
    {
      return $this->hasOne('App\TicketType', 'id', 'ticket_type_id');
    }
}
