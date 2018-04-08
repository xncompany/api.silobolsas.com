<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Silobag extends Model
{
    const UPDATED_AT = null;
    
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    protected $fillable = ['land', 'description', 'active'];
}
