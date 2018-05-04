<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class Sale extends Model
{

    public $fillable = ['ticket_id'];

    /**
     * Return products included in this sale
     * @return App\Product An instance of the Product model.
     */
    public function products()
    {
      return $this->belongsToMany('App\Product', 'product_sale');
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

}
