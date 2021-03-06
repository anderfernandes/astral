<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
  use Notifiable;

  protected $casts = [
    'newsletter' => 'boolean'
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'firstname', 'lastname', 'email', 'password', 'role_id', 'organization_id', 'type', 'membership_id', 'active', 'staff'
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

  /**
   * Returns an object with this user's Role data.
   * @return App\Role An instance of the Role model.
   */
  public function role()
  {
    return $this->belongsTo('App\Role');
  }

  /**
   * Returns an object with this user's Organization data
   * @return App\Organization An instance of the Organization model.
   */
  public function organization()
  {
    return $this->belongsTo('App\Organization');
  }

  /**
   * Returns an object with this user's Membership data
   * @return App\Member An instance of the Member model.
   */
  public function member()
  {
    return $this->belongsTo('App\Member', 'membership_id');
  }

  public function membership()
  {
    return $this->belongsTo('App\Member', 'membership_id');
  }

  /**
   * Returns an object with this user's Creator data
   * @return App\User An instance of the User model.
   */
  public function creator()
  {
    return $this->belongsTo('App\User');
  }

  /**
   * Returns all tickets assigned to a User
   * @return App\Ticket Returns a tickets assigned to a User
   */
  public function tickets()
  {
    return $this->hasMany('App\Ticket', 'customer_id');
  }

  /**
   * Return this user's full name, combining $firstname and $lastname
   * @return {String} "${this->firstname} {$this->lastname}"
   */
  public function getFullnameAttribute()
  {
    return "{$this->firstname} {$this->lastname}";
  }

  public function getMembershipNumberAttribute()
  {

    return $this->member->number;
  }

  public function shifts()
  {
    return $this->belongsToMany('App\Shift', 'shift_user', 'user_id', 'shift_id');
  }

  public function sales()
  {
    return $this->hasMany('App\Sale', 'customer_id');
  }

  public function getIsMemberAttribute()
  {
    return !($this->membership_id == 1);
  }
}
