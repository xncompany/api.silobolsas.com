<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
}
