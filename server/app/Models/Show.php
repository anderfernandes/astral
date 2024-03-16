<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Show extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:c',
            'updated_at' => 'datetime:c',
            'duration' => 'int',
            'is_active' => 'boolean',
            'expiration' => 'datetime:c',
            'type_id' => 'integer'
        ];
    }

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['is_expired'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    //protected $with = ['type'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'duration',
        'description',
        'type_id',
        'cover',
        'is_active',
        'trailer_url',
        'expiration',
        'creator_id',
        'type' // This is the legacy string type of show property in the database
    ];

    /**
     * The type of the show.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ShowType::class);
    }

    /**
     * Fixes the URL of the show cover.
     */
    public function cover(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => "/storage/$value"
        );
    }

    /**
     * Returns if the show is expired or not.
     */
    public function isExpired(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['expiration'] == null
                ? false
                : $attributes['expiration']->isPast()
        );
    }
}
