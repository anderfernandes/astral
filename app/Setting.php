<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $hidden = [ 'gateway_private_key' ];
}
