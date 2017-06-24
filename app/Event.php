<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function show()
    {
        return $this->hasOne('App\Show');  
    }
}
