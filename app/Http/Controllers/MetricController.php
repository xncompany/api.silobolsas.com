<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Metric;

class MetricController extends Controller
{
    /**
     * List metrics for given device.
     *
     * @param  int  $device
     * @return Response
     */
    public function listMetrics($device) {
        
        return Metric::where('id_device', $device)
                ->with(['id_metric_type', 'id_metric_status', 'id_metric_unit'])
                ->get();
    }
}
