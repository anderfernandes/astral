<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class TicketType extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = ['pivot'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'is_active', 'price', 'in_cashier', 'is_public'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'double',
            'in_cashier' => 'boolean',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
            'creator_id' => 'integer',
        ];
    }

    /**
     * Gets the allowed event types for a ticket type.
     */
    public function allowedEvents(): BelongsToMany
    {
        return $this->belongsToMany(
            EventType::class,
            'allowed_ticket_events',
            'ticket_type_id',
            'event_type_id'
        );
    }

    /**
     * Gets the user who created a ticket type.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
