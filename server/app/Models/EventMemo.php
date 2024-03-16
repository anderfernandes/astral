<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventMemo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'author_id',
        'event_id',
        'message',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'event_id' => 'integer',
            'author_id' => 'integer',
        ];
    }

    /**
     * Returns the Event this memo belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Returns the User model of the author of this memo.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
