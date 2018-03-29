<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    public function creator()
    {
      return $this->belongsTo('App\User');
    }
}
