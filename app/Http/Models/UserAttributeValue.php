<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttributeValue extends Model
{
    const UPDATED_AT = null;
    
    protected $table = 'user_attribute_values';
    
    protected $fillable = ['user', 'user_attribute', 'description'];
    
    public function user()
    {
        return $this->belongsTo('App\Http\Models\User', 'id');
    }
    
    public function user_attribute()
    {
        return $this->belongsTo('App\Http\Models\UserAttribute', 'user_attribute');
    }
}