<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
  /**
   * The attributes that should be mutaded to dates
   *
   *  @var array
   */
  protected $dates = ['created_at', 'updated_at'];

  /**
   * Returns an object with information on the user who created this Show.
   * @return App\User Returns an object with information on the user who created this Show.
   */
  public function creator()
  {
    return $this->belongsTo('App\User');
  }
}
