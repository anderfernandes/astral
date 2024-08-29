<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membership extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'members';
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['number', 'is_expired'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['type_id', 'start', 'end', 'primary_id', 'creator_id'];
    
    /**
     * Relationships that will be loaded by default.
     */
    protected $with = ['primary', 'secondaries'];
    
    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'start' => 'datetime',
            'end' => 'datetime',
        ];
    }
    
    /**
     * Returns the type of membership.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class, 'membership_type_id');
    }
    
    /**
     * The primary membership holder.
     */
    public function primary(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Additional users of the membership.
     */
    public function secondaries(): HasMany
    {
        return $this->hasMany(User::class, 'membership_id')->where('id', '!=', $this->primary_id);
    }
    
    /**
     * The creator of this record.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Mutator that formats a memberhsip number according to defined settings.
     */
    protected function number(): Attribute
    {
        $length = (int) Setting::find(1)->membership_number_length;
        
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => str_pad($attributes['id'], $length, '0', STR_PAD_LEFT),
        );
    }
    
    /**
     * Returns whether or not the membership has expired.
     */
    public function isExpired(): Attribute
    {
        return Attribute::get(fn (mixed $value, array $attributes) => \Illuminate\Support\Carbon::parse($attributes['end'])->isPast());
    }
}
