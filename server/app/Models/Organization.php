<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'address', 'city', 'state', 'zip', 'country', 'phone', 'fax', 'email', 'website', 'type_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'taxable' => 'boolean'
        ];
    }

    /**
     * Returns the type (`OrganizationType`) of organization
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }
    
    /**
     * Returns the `User` who created this record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the `User`s that belong to this organization.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class)->where('type', 'individual');
    }
}
