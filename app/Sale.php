<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    public $fillable = ['ticket_id'];

    public function tickets()
    {
      return $this->hasMany('App\Ticket');
    }

    public function creator()
    {
      return $this->belongsTo('App\User');
    }

    public function payment()
    {
      return $this->belongsTo('App\Payment');
    }

    public function payments()
    {
      return $this->hasMany('App\Payment');
    }

    public function customer()
    {
      return $this->belongsTo('App\User');
    }

    public function organization()
    {
      return $this->belongsTo('App\Organization');
    }

    public function events()
    {
      return $this->belongsToMany('App\Event');
    }

}
