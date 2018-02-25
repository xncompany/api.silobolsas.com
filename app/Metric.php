<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    public function id_metric_type()
    {
        return $this->hasOne('App\MetricType', 'id', 'id_metric_type');
    }
    
    public function id_metric_status()
    {
        return $this->hasOne('App\MetricStatus', 'id', 'id_metric_status');
    }
    
    public function id_metric_unit()
    {
        return $this->hasOne('App\MetricUnit', 'id', 'id_metric_unit');
    }
}
