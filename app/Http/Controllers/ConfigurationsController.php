<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Models\MetricConfiguration;

class ConfigurationsController extends Controller
{
    /**
     * List all metrics configuration
     *
     * @return Response
     */
    public function getMetrics() {
        
        return MetricConfiguration::with(['metric_type', 'status', 'configuration_type'])
                ->get();
    }
}
