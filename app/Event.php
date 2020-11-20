<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

  protected $fillable = ['start', 'end', 'memo', 'seats', 'creator_id', 'type_id', 'public', 'show_id'];

  protected $appends  = ['title', 'seats_available'];

  protected $casts = ['seats' => 'integer'];

  /**
   * These variables will be mutated to dates
   * @var Carbon\Carbon
   */
  protected $dates = ['created_at', 'updated_at', 'start', 'end'];

  public function show()
  {
    return $this->belongsTo('App\Show');
  }

  public function creator()
  {
    return $this->belongsTo('App\User');
  }

  public function sales()
  {
    return $this->belongsToMany('App\Sale', 'sale_event', 'event_id', 'sale_id');
  }

  public function type()
  {
    return $this->belongsTo('App\EventType');
  }

  public function memo()
  {
    return $this->hasMany('App\EventMemo');
  }

  public function memos()
  {
    return $this->hasMany('App\EventMemo');
  }

  public function tickets()
  {
    return $this->hasMany('App\Ticket');
  }

  public function shifts()
  {
    return $this->belongsToMany('App\Shift', 'shift_event', 'event_id', 'shift_id');
  }

  public function getTitleAttribute()
  {
    return $this->attributes['memo'];
  }

  public function getSeatsAvailableAttribute()
  {

    return $this->seats - $this->tickets->count();

  }
}
