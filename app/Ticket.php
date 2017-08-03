<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $fillable = ['type', 'show_id', 'price', 'event_id', 'customer_id', 'cashier_id', 'sale_id'];

    public function sale()
    {
      $this->belongsTo('App\Sale');
    }
}
