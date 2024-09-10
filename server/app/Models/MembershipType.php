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
    protected $fillable = ['name', 'description', 'price', 'duration', 'max_secondaries', 'secondary_price', 'is_active', 'keep_remaining_days'];

    /**
     * The user that created the record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'keep_remaining_days' => 'boolean'];
    }
}
