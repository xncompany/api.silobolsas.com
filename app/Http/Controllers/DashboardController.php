<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Land;
use App\Http\Models\Silobag;
use App\Http\Models\Device;
use App\Http\Models\Metric;

class DashboardController extends Controller
{
    /**
     * List components for the dashboard.
     *
     * @return Response
     */
    public function list(Request $request) {
        
        $data = array();

        if ($request->has('user')) {
            $user = $request->get('user');
            $devices = $this->_devices($user)->get();
            $data['counters']['lands'] = $this->_lands($user)->count();
            $data['counters']['silobags'] = $this->_silobags($user)->count();
            $data['counters']['devices'] = count($devices);
            $data['counters']['metrics'] = $this->_metrics($user)->count();
            $data['devices'] = $devices;
        } 
        
        return $data;
    }

    private function _lands($user) 
    {
        return Land::where('user', $user)
                    ->where('active', 1);
    }

    private function _silobags($user) 
    {
        return Silobag::join('lands', 'silobags.land', '=', 'lands.id')
                        ->where('lands.user', $user)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1);
    }

    private function _devices($user) 
    {
        return Device::join('silobags', 'silobags.id', '=', 'devices.silobag')
                        ->join('lands', 'lands.id', '=', 'silobags.land')
                        ->select('devices.*')
                        ->with(['type', 'attributes', 'attributes.device_attribute'])
                        ->where('lands.user', $user)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1)
                        ->where('devices.active', 1);
    }

    private function _metrics($user)
    {
        return Metric::join('devices', 'devices.id', '=', 'metrics.device')
                        ->join('silobags', 'silobags.id', '=', 'devices.silobag')
                        ->join('lands', 'lands.id', '=', 'silobags.land')
                        ->with(['type', 'attributes', 'attributes.device_attribute'])
                        ->where('lands.user', $user)
                        ->where('lands.active', 1)
                        ->where('silobags.active', 1)
                        ->where('devices.active', 1);
    }
}
