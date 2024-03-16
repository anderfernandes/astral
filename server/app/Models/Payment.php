<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cashier_id',
        'method_id',
        'tendered',
        'total',
        'change_due',
        'source',
        'sale_id',
        'reference'
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'refunded' => 'boolean'
        ];
    }

    /**
     * The `PaymentMethod` of the payment in question.
     */
    public function method(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'method_id');
    }

    /**
     * The `User` who created the payment.
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The `App\Models\Sale` the payment in question belongs to.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Returns the customer to whom this sale belongs to.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
