<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A type of event.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 */
class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['start', 'end', 'memo', 'seats', 'creator_id', 'is_public', 'type_id', 'show_id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['title', 'seats', 'is_all_day'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['tickets', 'memo', 'pivot'];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'seats' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'start' => 'datetime',
            'end' => 'datetime',
            'is_public' => 'boolean',
            'show_id' => 'integer',
            'creator_id' => 'integer',
            'type_id' => 'integer',
        ];
    }

    /**
     * Returns the show that belongs to this event.
     */
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    /**
     * Returns the type of this event.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(EventType::class);
    }

    /**
     * Returns the memo(s) for this event;
     */
    public function memos(): HasMany
    {
        return $this->hasMany(EventMemo::class)->orderByDesc('id');
    }

    /**
     * A mutator that returns the title of the event. It uses the old memo property of the events
     * table.
     */
    protected function title(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $attributes == null ? null : $attributes['memo'];
            },
            set: function (string $value, array &$attributes) {
                $attributes['memo'] = $value;
            }
        );
    }

    /**
     * Returns the tickets for this event
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Returns an object with information on number of seats for the event.
     */
    protected function seats(): Attribute
    {
        $tickets_sold = $this->tickets()->count();

        return Attribute::make(
            get: fn(mixed $value, array $attributes) => [
                "available" => $attributes['seats'] - $tickets_sold,
                "taken" => $tickets_sold,
                "total" => $attributes['seats']
            ]
        );
    }

    /**
     * Returns whether the event is all day or not.
     */
    protected function isAllDay(): Attribute
    {
        return Attribute::make(
            get: function (mixed $attributes) {
                if ($attributes == null) {
                    return false;
                }
                return $attributes['start']->start->diffInDays($attributes['end']) == 1;
            }
        );
    }
}
