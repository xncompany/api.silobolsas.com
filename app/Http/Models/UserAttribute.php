<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttribute extends Model
{
    const UPDATED_AT = null;
    
    protected $table = 'user_attributes';
    
    protected $fillable = ['description'];
}