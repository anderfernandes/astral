<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{

  protected $dates = ['created_at', 'updated_at', 'start', 'end'];

  protected $fillable = ["shift_id", "user_id"];

  public function employees()
  {
    return $this->hasManyThrough('App\User', 'App\Position', 'user_id', 'position_id', 'id', 'id');
  }
}
