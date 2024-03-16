<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleMemo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['author_id', 'sale_id', 'message'];

    /**
     * The `App\Models\Sale` that this sale memo belongs to.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * The `User` who created this sale memo.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
