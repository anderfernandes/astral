<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationType extends Model
{
    //
    public function creator()
    {
      return $this->belongsTo('App\User');
    }

    public function organizations()
    {
      return $this->hasMany('App\Organization', 'type_id');
    }
}
