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

    public function sales()
    {
      return $this->belongsToMany('App\Sale', 'sale_event', 'event_id', 'sale_id');
    }

    public function type()
    {
      return $this->belongsTo('App\EventType');
    }

    public function memo()
    {
      return $this->hasMany('App\EventMemo');
    }

    public function memos()
    {
      return $this->hasMany('App\EventMemo');
    }

    public function tickets()
    {
      return $this->hasMany('App\Ticket');
    }

}
