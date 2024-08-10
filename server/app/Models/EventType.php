<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A type of event.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class EventType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'description', 'is_public'];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * The relationships that should always be loaded.
     */
    protected $with = ['allowedTickets'];

    /**
     * The tickets allowed to be sold in an event type.
     */
    public function allowedTickets(): BelongsToMany
    {
        return $this->belongsToMany(
            TicketType::class,
            'allowed_ticket_events'
        );
        //->where('active', '==', true);
    }

    /**
     * Gets the user who created an event type.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets the events tagged with a ticket type.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'type_id');
    }
}
