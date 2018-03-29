<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['member_type_id', 'start', 'end'];

    public function type()
    {
      return $this->belongsTo('App\MemberType', 'member_type_id');
    }
    public function users()
    {
      return $this->hasMany('App\User', 'membership_id');
    }
    public function sale()
    {
      return $this->belongsTo('App\Sale');
    }
    public function creator()
    {
      return $this->belongsTo('App\User');
    }
}
