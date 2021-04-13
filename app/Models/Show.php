<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:c',
        'updated_at' => 'datetime:c',
        'duration' => 'int',
        'creator_id' => 'int',
        'type_id' => 'int',
        'active' => 'bool',
        'expiration' => 'datetime:c'
    ];

    protected $appends = ['is_expired'];

    protected $hidden = ['type'];

    /**
   * Fixes the URL of the show cover
   * 
   * @param String $value
   * @return String
   */
    public function getCoverAttribute($value)
    {

        // Covers that come from links
        if (substr($value, 0, 4) == "http")
            return $this->attributes['cover'] = $value;
        // Default covers
        else if ($value === '/default.png')
            return $this->attributes['cover'] = asset($value);
        // Uploaded covers
        else
            return $this->attributes['cover'] = asset("storage/$value");
    }

    /**
   * Returns whether a show is expired or not
   *
   * @param string $value
   * @return boolean
   */
    public function getIsExpiredAttribute($value)
    {
        return $this->attributes['is_expired'] = ($this->expiration == null)
            ? false
            : $this->expiration->isPast();
    }
}
