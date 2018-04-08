<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceAttribute extends Model
{
    const UPDATED_AT = null;
    
    protected $table = 'device_attributes';
    
    protected $fillable = ['description'];
}