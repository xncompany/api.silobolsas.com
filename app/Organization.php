<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $casts = [
        'active'   => 'boolean'
    ];
    
    protected $fillable = ['description', 'active', 'created_at'];
}
