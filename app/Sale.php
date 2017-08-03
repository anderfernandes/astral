<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    public function tickets()
    {
      return $this->hasMany('App\Ticket');
    }

    public function event()
    {
      return $this->hasMany('App\Event');
    }
}
