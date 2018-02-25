<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Silobag extends Model
{
    protected $casts = [
        'active'   => 'boolean'
    ];
}
