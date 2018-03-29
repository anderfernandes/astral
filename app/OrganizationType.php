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
}
