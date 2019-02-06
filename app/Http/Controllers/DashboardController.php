<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Land;
use App\Http\Models\Silobag;
use App\Http\Models\Device;
use App\Http\Models\Metric;
use App\Http\Models\MetricHistory;

class DashboardController extends Controller
{
    /**
     * List components for the dashboard.
     *
     * @return Response
     */
    public function list(Request $request) {
        
        $data = array();

        if ($request->has('organization')) 
        {
            $idOrganization = $request->get('organization');
            $devices = $this->_devices($idOrganization)->get();
            $silobags = $this->_silobags($idOrganization)->get();
            $alerts = $this->_alerts($idOrganization)->get();

            foreach ($alerts as $alert) {
                if ($alert->metric_status == 3) 
                {
                    foreach ($silobags as &$silobag) 
                    {
                        if ($silobag->id == $alert->silobag) {
                            $silobag->alarm = 1;
                        }
                    }
                }
            }

            $data['counters']['lands'] = $this->_lands($idOrganization)->count();
            $data['counters']['silobags'] = count($silobags);
            $data['counters']['devices'] = count($devices);
            $data['counters']['metrics'] = $this->_metrics($idOrganization)->count();
            $data['counters']['alerts'] = count($alerts);
            $data['devices'] = $devices;
            $data['silobags'] = $silobags;
            $data['alerts'] = $alerts;
        } 
        
        return $data;
    }

    private function _lands($idOrganization) 
    {
        return Land::where('organization', $idOrganization)
                    ->where('active', 1);
    }

    private function _silobags($idOrganization) 
    {
        return Silobag::join('lands', 'silobags.land', '=', 'lands.id')
                        ->select('silobags.*', 'lands.description as land', 'lands.id as idLand')
                        ->where('lands.organization', $idOrganization)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1)
                        ->orderBy('lands.id');
    }

    private function _devices($idOrganization) 
    {
        return Device::join('silobags', 'silobags.id', '=', 'devices.silobag')
                        ->join('lands', 'lands.id', '=', 'silobags.land')
                        ->select('devices.*')
                        ->with(['type', 'attributes', 'attributes.device_attribute'])
                        ->where('lands.organization', $idOrganization)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1)
                        ->where('devices.active', 1);
    }

    private function _metrics($idOrganization)
    {
        return MetricHistory::join('devices', 'devices.id', '=', 'metrics_history.device')
                        ->join('silobags', 'silobags.id', '=', 'devices.silobag')
                        ->join('lands', 'lands.id', '=', 'silobags.land')
                        ->with(['type', 'attributes', 'attributes.device_attribute'])
                        ->where('lands.organization', $idOrganization)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1)
                        ->where('devices.active', 1);
    }

    private function _alerts($idOrganization)
    {
        $today = date('Y-m-d H:i:s', (time() -  86400));
        return Metric::join('devices', 'devices.id', '=', 'metrics.device')
                        ->join('silobags', 'silobags.id', '=', 'devices.silobag')
                        ->join('lands', 'lands.id', '=', 'silobags.land')
                        ->where('lands.organization', $idOrganization)
                        ->where('metrics.created_at', '>=', $today)
                        ->where('metric_status', 3)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1)
                        ->where('devices.active', 1);
    }
}
