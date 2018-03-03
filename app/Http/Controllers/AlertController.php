<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
