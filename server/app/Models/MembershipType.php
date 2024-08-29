<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'member_types';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'description', 'price', 'duration', 'max_secondaries', 'secondary_price'];

    /**
     * The user that created the record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
