<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    const UPDATED_AT = null;
    
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    protected $fillable = ['silobag'];
    
    public function type()
    {
        return $this->hasOne('App\DeviceType', 'id', 'type');
    }
}
