<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Land extends Model
{
    const UPDATED_AT = null;
    
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    protected $fillable = ['user', 'description', 'active'];
    
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user');
    }
}
