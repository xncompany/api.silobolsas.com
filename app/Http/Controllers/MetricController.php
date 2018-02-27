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
        
        return Metric::where('device', $device)
                ->with(['metric_type', 'metric_status', 'metric_unit'])
                ->get();
    }
}
