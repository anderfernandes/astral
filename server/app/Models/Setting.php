<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 * @property int $id
 */
class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['id', 'created_at'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['organization', 'address', 'email', 'phone', 'fax', 'seats', 'astc', 'tax', 'website'];

}
