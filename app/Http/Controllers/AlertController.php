<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Alert;

class AlertController extends Controller
{
    /**
     * List alerts.
     *
     * @return Response
     */
    public function listAlerts($device) {
        
        return Alert::join('metrics', 'alerts.metric', '=', 'metrics.id')
                ->select('alerts.*')
                ->where('metrics.device', $device)
                ->with(['metric'])
                ->get();
    }
    
    /**
     * Create alert for metric.
     *
     * @return Response
     */
    public function createAlert(Request $request) {
       
        $request->validate([
            'metric' => 'required|numeric|max:10',
            'min_amount' => 'required|numeric',
            'max_amount' => 'required|numeric'
        ]);
        
        return Alert::create($request->all());
    }
    
    /**
     * Update an alert
     *
     * @param  int  $alert
     * @return Response
     */
    public function updateAlert($alert, Request $request) {
        
        $request->validate([
            'metric' => 'numeric|max:10',
            'min_amount' => 'numeric',
            'max_amount' => 'numeric'
        ]);
        
        $update = Alert::where('id', $alert)
                ->update($request->only('metric', 'min_amount', 'max_amount'));
        
        if (! $update) {
            return new JsonResponse(null, 400);
        } 
        
        return new JsonResponse();
    }
}
