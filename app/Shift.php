<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

  protected $dates = ['created_at', 'updated_at', 'start', 'end'];

  protected $fillable = ["shift_id", "user_id"];

  public function employees()
  {
    return $this->belongsToMany('App\User', 'shift_user', 'shift_id', 'user_id');
  }

  public function positions()
  {
    return $this->belongsToMany('App\Position', 'shift_position', 'shift_id', 'position_id');
  }

  public function creator()
  {
    return $this->belongsTo('App\User');
  }

}
