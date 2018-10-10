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

  public function events()
  {
    return $this->belongsToMany('App\Event', 'organization_event', 'organization_id', 'event_id');
  }

  /**
   * Returns all tickets assigned to a User
   * @return App\Ticket Returns a tickets assigned to a User
   */
  public function tickets()
  {
    return $this->hasMany('App\Ticket');
  }
}
