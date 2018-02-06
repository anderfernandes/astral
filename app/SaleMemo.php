<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleMemo extends Model
{

  protected $fillable = [
      'author_id', 'sale_id', 'message',
  ];

    //
    public function sale()
    {
      return $this->belongsTo('App\Sale');
    }

    public function author()
    {
      return $this->belongsTo('App\User');
    }
}
