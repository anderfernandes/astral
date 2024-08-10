<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organization extends Model
{
    use HasFactory;
    
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
}
