<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
  public function type()
  {
    return $this->belongsTo('App\OrganizationType');
  }

  public function users()
  {
    return $this->hasMany('App\User');
  }
}
