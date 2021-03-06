<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    public function device()
    {
        return $this->hasOne('App\Http\Models\Device', 'id', 'device');
    }

    public function metric_type()
    {
        return $this->hasOne('App\Http\Models\MetricType', 'id', 'metric_type');
    }
    
    public function metric_status()
    {
        return $this->hasOne('App\Http\Models\MetricStatus', 'id', 'metric_status');
    }
    
    public function metric_unit()
    {
        return $this->hasOne('App\Http\Models\MetricUnit', 'id', 'metric_unit');
    }
}
