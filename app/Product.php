<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductType;

class Product extends Model
{

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name',
        'description',
        'price',
        'type_id',
        'creator_id',
        'inventory',
        'active',
        'public',
        'in_cashier',
        'stock',
        'cover'
    ];

    protected $casts = [
      'stock' => 'integer',
      'price' => 'double',
      'inventory' => 'integer',
      'active' => 'boolean',
      'public' => 'boolean',
      'in_cashier' => 'boolean'
    ];

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
