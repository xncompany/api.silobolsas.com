<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Models\MetricConfiguration;

class ConfigurationsController extends Controller
{
    /**
     * List all system configurations
     *
     * @return Response
     */
    public function getMetrics() {
        
        return MetricConfiguration::with(['metric_type', 'status', 'configuration_type'])
                ->get();
    }

    /**
     * Set system configurations
     *
     * @return Response
     */
    public function setMetrics(Request $request) {

    	$data = $request->all();

    	foreach ($data as $item) {

    		$update = MetricConfiguration::where('id', $item['id'])
                		->update(['rangeA' => $item['rangeA'], 
                				  'rangeB' => $item['rangeB']]);
        
	        if (!$update) {
	            return new JsonResponse(null, 400);
	        }
    	}

    	return new JsonResponse();
    }
}
