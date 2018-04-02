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
        
        return Device::where('silobag', $silobag)
                ->where('active', 1)
                ->with(['type', 'attributes', 'attributes.device_attribute'])
                ->get();
    }

    /**
     * Create Device.
     *
     * @return Response
     */
    public function create(Request $request) {


        // revisar: esta validación está fallando.
        $request->validate([
            'less_id' => 'required|numeric|max:40',
            'silobag' => 'required|numeric|max:20',
            'type' => 'required|numeric|max:20',
            'description' => 'required|string|max:128',
            'active' => 'required|boolean'
        ]);

        return Device::create($request->all());
    }
    
    /**
     * Get device.
     *
     * @param  int  $device
     * @return Response
     */
    public function getDevice($device) {
        
        return Device::where('id', $device)
                ->with(['type', 'attributes', 'attributes.device_attribute'])
                ->first();
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

    /**
     * Delete Device.
     *
     * @return Response
     */
    public function delete($id) {

        $update = Device::where('id', $id)->update(['active' => 0]);

        if (!$update) {
            return new JsonResponse(null, 400);
        } 

        return new JsonResponse();
    }
}
