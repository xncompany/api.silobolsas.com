<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    public function metric()
    {
        return $this->hasOne('App\Metric', 'id', 'metric');
    }
}
