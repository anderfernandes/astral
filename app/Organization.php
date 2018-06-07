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

  public function creator()
  {
    return $this->belongsTo('App\User');
  }

  public function sales()
  {
    return $this->hasMany('App\Sale');
  }
}
