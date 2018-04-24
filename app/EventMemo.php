<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventMemo extends Model
{
  protected $fillable = [
      'author_id', 'event_id', 'message',
  ];

    //
    public function event()
    {
      return $this->belongsTo('App\Event');
    }

    public function author()
    {
      return $this->belongsTo('App\User');
    }
}
