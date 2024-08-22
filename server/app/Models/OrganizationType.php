<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationType extends Model
{
    use HasFactory;
    
    protected function casts() : array {
        return [
            'taxable' => 'boolean'
        ];
    }

    protected $fillable = [ 'name', 'description', 'taxable' ];

    /**
     * Returns the `User` who created this record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
