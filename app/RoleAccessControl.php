<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleAccessControl extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dashboard', 'shows', 'products', 'calendar', 'sales', 'reports',
        'members', 'users', 'organizations', 'bulletin', 'settings',
        'admin', 'cashier'
    ];

    protected $table = 'roles_access_control';
}
