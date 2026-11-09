<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
    protected $casts = [
      'duration' => 'int',
      'price' => 'int',
      'secondary_price' => 'int',
      'max_secondaries' => 'int'
    ];

    //
    public function creator()
    {
      return $this->belongsTo('App\User');
    }
}
