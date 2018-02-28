<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    protected $fillable = ['user', 'description', 'active'];

    const UPDATED_AT = null;
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user');
    }
}
