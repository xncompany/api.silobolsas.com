<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Land;

class LandController extends Controller
{
    /**
     * List lands.
     *
     * @return Response
     */
    public function listLands(Request $request) {
        
        $land = Land::with(['id_user']);
        
        if ($request->has('user')) {
            $land = $land->where('id_user', $request->get('user'));
        } 
        
        return $land->get();
    }
}
