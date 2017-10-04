<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function show()
    {
      return $this->belongsTo('App\Show');
    }

    public function creator()
    {
      return $this->belongsTo('App\User');
    }

    public function sale()
    {
      $this->belongsToMany('App\Sale', 'sale_event');
    }

}
