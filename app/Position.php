<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function creator()
    {
      return $this->belongsTo('App\User');
    }
}
