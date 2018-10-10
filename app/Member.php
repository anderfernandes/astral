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
    protected $fillable = ['member_type_id', 'start', 'end'];

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
    public function users()
    {
      return $this->hasMany('App\User', 'membership_id');
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
