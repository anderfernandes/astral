<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Sale extends Model
{

  public $fillable = ['ticket_id', 'product_id'];

  /**
   * Return products included in this sale
   * @return App\Product An instance of the Product model.
   */
  public function products()
  {
    return $this->belongsToMany('App\Product', 'sale_product', 'sale_id', 'product_id');
  }

  public function grades()
  {
    return $this->belongsToMany('App\Grade', 'sale_grade', 'sale_id', 'grade_id');
  }

  public function tickets()
  {
    return $this->hasMany('App\Ticket');
  }

  public function creator()
  {
    return $this->belongsTo('App\User');
  }

  public function payments()
  {
    return $this->hasMany('App\Payment');
  }

  public function customer()
  {
    return $this->belongsTo('App\User');
  }

  public function organization()
  {
    return $this->belongsTo('App\Organization');
  }

  public function events()
  {
    return $this->belongsToMany('App\Event', 'sale_event', 'sale_id', 'event_id');
  }

  public function memos()
  {
    return $this->hasMany('App\SaleMemo');
  }

  public function memo()
  {
    return $this->hasMany('App\SaleMemo');
  }

  public function setRefundAttribute($value)
  {
    $this->attributes['refund'] = (bool) $value;
  }

  public function getBalanceAttribute($value)
  {
    $total = (float) $this->total;
    $paid  = (float) $this->payments->sum('total');

    return $total - $paid;
  }
}
