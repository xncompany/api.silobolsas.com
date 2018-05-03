<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Metric;
use App\Http\Models\MetricHistory;
use Illuminate\Http\JsonResponse;

class MetricController extends Controller
{
    /**
     * List metrics for given device.
     *
     * @param  int  $device
     * @return Response
     */
    public function device($device) {
        
        $result['last'] = Metric::where('device', $device)
                ->with(['metric_type', 'metric_status', 'metric_unit'])
                ->orderBy('created_at', 'desc')
                ->get();

        $lastMonth = date('Y-m-d H:i:s', (time() -  2592000));
        $result['history'] = MetricHistory::where('device', $device)
                ->with(['metric_type', 'metric_status', 'metric_unit'])
                ->where('created_at', '>=', $lastMonth)
                ->orderBy('created_at', 'desc')
                ->get();

        return $result;
    }

    /**
     * List metrics with alerts for given organization.
     *
     * @param  int  $idOrganization
     * @return Response
     */
    public function alerts($idOrganization) {
        
        $devices = array();
        $lands = array();
        $silobags = array();
        $alerts = $this->_alerts($idOrganization);

        if (!count($alerts)) {
            return new JsonResponse();
        }

        foreach ($alerts as $alert) 
        {
            if (!in_array($alert->device, $devices)) {
                $devices[] = $alert->device;
            }
            if (!in_array($alert->land, $lands)) {
                $lands[] = $alert->land;
            }
            if (!in_array($alert->silobag, $silobags)) {
                $silobags[] = $alert->silobag;
            }
        }

        $result = array();
        $result['alerts'] = $alerts;
        $result['dashboard']['lands'] = count($lands);
        $result['dashboard']['devices'] = count($devices);
        $result['dashboard']['silobags'] = count($silobags);
        $result['dashboard']['alerts'] = count($alerts);
        return $result;
    }

    private function _alerts($idOrganization)
    {
        $today = date('Y-m-d H:i:s', (time() -  86400));
        return Metric::join('devices', 'devices.id', '=', 'metrics.device')
                        ->join('silobags', 'silobags.id', '=', 'devices.silobag')
                        ->join('lands', 'lands.id', '=', 'silobags.land')
                        ->with(['metric_type', 'metric_unit', 'device.attributes'])
                        ->where('lands.organization', $idOrganization)
                        ->where('metric_status', 3)
                        ->where('metrics.created_at', '>=', $today)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1)
                        ->where('devices.active', 1)
                        ->get();
    }

    public function all($idOrganization)
    {
        $today = date('Y-m-d H:i:s', (time() -  86400));
        return Metric::join('devices', 'devices.id', '=', 'metrics.device')
                        ->join('silobags', 'silobags.id', '=', 'devices.silobag')
                        ->join('lands', 'lands.id', '=', 'silobags.land')
                        ->with(['metric_type', 'metric_unit'])
                        ->where('lands.organization', $idOrganization)
                        ->where('metrics.created_at', '>=', $today)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1)
                        ->where('devices.active', 1)
                        ->get();
    }
}
