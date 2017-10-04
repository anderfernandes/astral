<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $fillable = ['ticket_type_id', 'event_id', 'customer_id', 'cashier_id'];

    public function sale()
    {
      $this->belongsToMany('App\Sale', 'sale_ticket');
    }

    public function event()
    {
      return $this->belongsTo('App\Event');
    }
}
