<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'role_id', 'organization_id', 'type', 'membership_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Guard 'role' attribute
    protected $guarded = ['role_id'];

    public function role()
    {
      return $this->belongsTo('App\Role');
    }

    public function organization()
    {
      return $this->belongsTo('App\Organization');
    }

    public function member()
    {
      return $this->hasOne('App\Member', 'user_id');
    }
}
