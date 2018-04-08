<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    const UPDATED_AT = null;
    
    protected $fillable = ['metric', 'min_amount', 'max_amount'];

    public function metric()
    {
        return $this->hasOne('App\Http\Models\Metric', 'id', 'metric');
    }
}
