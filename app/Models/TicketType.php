<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var [type]
     */
    protected $casts = [
      'public' => 'boolean',
      'price'  => 'double',
    ];
    
    /**
     * Gets the allowed event types for a ticket type.
     *
     * @return array
     */
    public function allowedEvents()
    {
        return $this->belongsToMany(
          'App\Models\EventType',
          'allowed_ticket_events',
          'ticket_type_id',
          'event_type_id'
      );
    }

    /**
     * Gets the user who created a ticket type.
     *
     * @return  \App\User
     */
    public function creator()
    {
        return $this->belongsTo('App\User');
    }
}
