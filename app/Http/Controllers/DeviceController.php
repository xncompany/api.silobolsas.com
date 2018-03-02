<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Device;

class DeviceController extends Controller
{
    /**
     * List device for given silo bag.
     *
     * @param  int  $silobag
     * @return Response
     */
    public function listDevices($silobag) {
        
        return Device::where('silobag', $silobag)->with(['type'])->get();
    }
    
    /**
     * Get device.
     *
     * @param  int  $device
     * @return Response
     */
    public function getDevice($device) {
        
        return Device::where('id', $device)->with(['type'])->first();
    }
    
    /**
     * Update a device
     *
     * @param  int  $device
     * @return Response
     */
    public function updateDevice($device, Request $request) {
        
        $request->validate(['silobag' => 'required|numeric|max:20']);
        
        $update = Device::where('id', $device)
                ->update(['silobag' => $request->get('silobag')]);
        
        if (! $update) {
            return new JsonResponse(null, 400);
        } 
        
        return new JsonResponse();
    }
}
