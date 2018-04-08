<?php

namespace App\Http\Models;

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
        return $this->hasOne('App\Http\Models\DeviceType', 'id', 'type');
    }
    
    public function attributes()
    {
        return $this->hasMany('App\Http\Models\DeviceAttributeValue', 'device');
    }
}
