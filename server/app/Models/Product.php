<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name', 'price', 'description', 'type_id', 'inventory', 'stock', 'cover', 'is_active', 'is_public',
        'in_cashier', 'creator_id'
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'stock' => 'integer',
            'price' => 'double',
            'inventory' => 'boolean'
        ];
    }

    /**
     * Returns the `User` who created this product.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the type of Product.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(ProductType::class);
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
}
