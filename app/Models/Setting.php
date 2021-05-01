<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{
    protected $hidden = ['id', 'created_at'];

    protected $casts = [
        'astc' => 'boolean',
        'seats' => 'integer',
        'tax' => 'double',
        'cashier_customer_dropdown' => 'boolean',
        'cashier_member_barcode' => 'boolean',
        'self_confirmation' => 'boolean'
    ];
}