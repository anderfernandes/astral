<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function author()
    {
      return $this->belongsTo('App\User');
    }

    public function category()
    {
      return $this->belongsTo('App\Category');
    }

    public function replies()
    {
      return $this->hasMany('App\Reply');
    }
}
