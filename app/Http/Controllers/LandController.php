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
        
        $land = Land::with(['user']);
        
        if ($request->has('user')) {
            $land = $land->where('user', $request->get('user'));
        } 
        
        return $land->get();
    }
    
    /**
     * Create land.
     *
     * @return Response
     */
    public function createLand(Request $request) {

        $request->validate([
            'user' => 'required|numeric|digits_between:1,20',
            'description' => 'required|string|max:128',
            'active' => 'required|boolean'
        ]);

        return Land::create($request->all());
    }

    /**
     * Delete land.
     *
     * @return Response
     */
    public function delete($id) {

        $update = Land::where('id', $id)->update(['active' => 0]);

        if (!$update) {
            return new JsonResponse(null, 400);
        } 

        return new JsonResponse();
    }
}
