<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Silobag;

class SilobagController extends Controller
{
    /**
     * List silo bags for a given land
     *
     * @param  int  $land
     * @return Response
     */
    public function listSilobags($land) {
        
        return Silobag::where('land', $land)->get();
    }
}
