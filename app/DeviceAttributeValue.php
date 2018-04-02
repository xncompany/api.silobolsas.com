<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceAttributeValue extends Model
{
    protected $table = 'device_attribute_values';
    
    public function device()
    {
        return $this->belongsTo('App\Device', 'id');
    }
    
    public function device_attribute()
    {
        return $this->belongsTo('App\DeviceAttribute', 'id');
    }
}