<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceAttributeValue extends Model
{
    const UPDATED_AT = null;
    
    protected $table = 'device_attribute_values';
    
    protected $fillable = ['device', 'device_attribute', 'description'];
    
    public function device()
    {
        return $this->belongsTo('App\Device', 'id');
    }
    
    public function device_attribute()
    {
        return $this->belongsTo('App\DeviceAttribute', 'id');
    }
}