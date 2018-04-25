<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MetricConfiguration extends Model
{
    protected $table = 'metric_configurations';

    public function metric_type()
    {
        return $this->hasOne('App\Http\Models\MetricType', 'id', 'id_metric_type');
    }
    
    public function status()
    {
        return $this->hasOne('App\Http\Models\MetricStatus', 'id', 'id_metric_status');
    }
    
    public function configuration_type()
    {
        return $this->hasOne('App\Http\Models\MetricConfigurationType', 'id', 'id_metric_configuration_type');
    }
}
