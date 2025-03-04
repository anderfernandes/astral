<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'staff' => 'boolean',
            'creator_id' => 'integer',
        ];
    }
}
