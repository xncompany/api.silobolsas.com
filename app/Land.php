<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    public function id_user()
    {
        return $this->hasOne('App\User', 'id', 'id_user');
    }
}
