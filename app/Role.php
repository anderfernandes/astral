<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function creator()
    {
      return $this->belongsTo('App\User');
    }

    public function permissions()
    {
      return $this->hasOne('App\RoleAccessControl');
    }
}
