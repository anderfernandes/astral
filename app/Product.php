<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductType;

class Product extends Model
{

    protected $fillable = ['product_id'];

    /**
     * Returns an object with this product's Creator data
     * @return App\User An instance of the User model.
     */
    public function creator()
    {
      return $this->belongsTo('App\User');
    }

    /**
     * Returns an object with this product's ProductType data
     * @return App\ProductType An instance of the ProductType model.
     */
    public function type()
    {
      return $this->belongsTo('App\ProductType');
    }

    public function sales()
    {
      return $this->belongsToMany('App\Sale', 'sale_product', 'product_id', 'sale_id');
    }

    /**
     * Fixes the URL of the product cover
     * 
     * @param String $value
     * @return String
     */
    public function getCoverAttribute($value)
    {

      $value = substr($value, 0, 4) == "/def"
                                      ? asset("$value")
                                      : asset("/storage/$value");
      return $value;
    }
}
