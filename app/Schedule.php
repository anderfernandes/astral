<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
  public function creator()
  {
    return $this->belongsTo('App\User');
  }

  public function shifts()
  {
    return $this->belongsToMany('App\Shift', 'schedule_shift', 'schedule_id', 'shift_id');
  }
}
