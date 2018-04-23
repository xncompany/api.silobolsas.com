<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	const UPDATED_AT = null;

    protected $casts = [
        'active'   => 'boolean'
    ];
    
    protected $fillable = ['description', 'active', 'created_at'];
}
