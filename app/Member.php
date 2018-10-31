<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * The attributes that should be mutaded to dates
     * @var [type]
     */
    protected $dates = ['created_at', 'updated_at', 'start', 'end'];

    /**
     * Defining mass assignment properties of this model
     * @var array
     */
    protected $fillable = ['member_type_id', 'start', 'end', 'primary_id', 'creator_id'];

    /**
     * Returns the type of membership
     *
     * @return App\MembershipType Returns the respective App\MembershipType of this membership
     */
    public function type()
    {
      return $this->belongsTo('App\MemberType', 'member_type_id');
    }

    /**
     * Returns all App\User objects under this membership with the first always being the primary.
     *
     * @return App\User Returns all App\User objects under this membership with the first always being the primary.
     */
    public function secondaries()
    {
      return $this->hasMany('App\User', 'membership_id')->where('id', '!=', $this->primary_id);
    }

    /**
     * Returns the primary on the current membership
     * @return App\User Returns the primary on the current membership
     */
    public function primary()
    {
      return $this->belongsTo('App\User');
    }

    public function getUsersAttribute()
    {
      $primary = $this->primary;
      $secondaries = $this->secondaries->all();

      return array_prepend($secondaries, $primary);

    }

    /**
     * Returns the creator of the memebrship
     *
     * @return App\User Returns creator of the membership
     */
    public function creator()
    {
      return $this->belongsTo('App\User');
    }
}
