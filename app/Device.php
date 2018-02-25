<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    public function type()
    {
        return $this->hasOne('App\DeviceType', 'id', 'type');
    }
}
