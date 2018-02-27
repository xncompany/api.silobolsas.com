<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
}
