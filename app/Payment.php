<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

  protected $fillable = ['cashier_id', 'payment_method_id', 'tendered', 'total', 'change_due', 'source', 'sale_id', 'reference'];


  public function method()
  {
    return $this->hasOne('App\PaymentMethod', 'id', 'payment_method_id');
  }

  public function cashier()
  {
    return $this->belongsTo('App\User');
  }

  public function sale()
  {
    return $this->belongsTo('App\Sale');
  }
}
