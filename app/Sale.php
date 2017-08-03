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

}
