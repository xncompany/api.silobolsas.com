<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    const UPDATED_AT = null;
    
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    protected $fillable = ['less_id', 'silobag', 'description', 'type', 'active'];
    
    public function type()
    {
        return $this->hasOne('App\DeviceType', 'id', 'type');
    }
    
    public function attributes()
    {
        return $this->hasMany('App\DeviceAttributeValue', 'device');
    }
}
