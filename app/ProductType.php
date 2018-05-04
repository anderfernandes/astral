<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    /**
     * Returns an object with this product type's Creator data
     * @return App\User An instance of the User model.
     */
    public function creator()
    {
      return $this->belongsTo('App\User');
    }
}
