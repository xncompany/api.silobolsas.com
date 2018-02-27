<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user');
    }
}
