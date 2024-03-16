<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that should be mass assignable.
     */
    public $fillable = [
        'creator_id',
        'status',
        'source',
        'taxable',
        'subtotal',
        'tax',
        'total',
        'refund',
        'customer_id',
        'organization_id',
        'sell_to_organization'
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['balance'];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'taxable' => 'boolean',
            'refund' => 'boolean',
            'sell_to_organization' => 'boolean'
        ];
    }

    /**
     * Returns the products in this sale.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'sale_product', 'sale_id', 'product_id');
    }

    /**
     * Returns the tickets of this sale.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Returns the `User` who created this sale.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the payments applied to this sale.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Returns the customer to whom this sale belongs to.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the events attached to this sale.
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'sale_event', 'sale_id', 'event_id');
    }

    /**
     * Returns the memos that were left on this sale.
     */
    public function memos(): HasMany
    {
        return $this->hasMany(SaleMemo::class)->orderBy('created_at', 'desc');
    }

    /**
     * Return whether this sale has been refunded or not.
     */
    protected function refund(): Attribute
    {
        return Attribute::make(set: fn($value) => (bool) $value);
    }

    /**
     * Returns the balance of the sale.
     */
    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn($value, $attributes) => $attributes['total'] - (new Payment)->where('sale_id',
                    $attributes['id'])->sum('total')
        );
    }
}
