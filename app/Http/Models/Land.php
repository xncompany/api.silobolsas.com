<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    const UPDATED_AT = null;
    
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    protected $fillable = ['user', 'organization', 'description', 'active'];
    
    public function user()
    {
        return $this->hasOne('App\Http\Models\User', 'id', 'user');
    }

    public function organization()
    {
        return $this->hasOne('App\Http\Models\Organization', 'id', 'organization');
    }
}
