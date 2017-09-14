<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    public $fillable = ['ticket_id'];

    public function tickets()
    {
      return $this->belongsToMany('App\Ticket');
    }

    public function cashier()
    {
      return $this->belongsTo('App\User');
    }

    public function customer()
    {
      return $this->belongsTo('App\User');
    }

    public function events()
    {
      return $this->belongsToMany('App\Event');
    }

}
