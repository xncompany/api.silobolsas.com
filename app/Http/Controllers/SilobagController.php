<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Models\Silobag;

class SilobagController extends Controller
{
    /**
     * List silo bags for a given land
     *
     * @param  int  $land
     * @return Response
     */
    public function listSilobags($land) {
        
        return Silobag::where('land', $land)->where('active', 1)->get();
    }
    
    /**
     * Get silo bag
     *
     * @param  int  $silobag
     * @return Response
     */
    public function getSilobag($silobag) {
        
        return Silobag::where('id', $silobag)->first();
    }
    
    /**
     * Update a silo bag
     *
     * @param  int  $silobag
     * @return Response
     */
    public function updateSilobag($silobag, Request $request) {
        
        $request->validate(['land' => 'required|numeric|digits_between:1,20']);
        
        $update = Silobag::where('id', $silobag)
                ->update(['land' => $request->get('land')]);
        
        if (! $update) {
            return new JsonResponse(null, 400);
        } 
        
        return new JsonResponse();
    }
    
    /**
     * Create a silo bag
     *
     * @return Response
     */
    public function createSilobag(Request $request) {
        
        $request->validate([
            'description' => 'required|string|max:128',
            'active' => 'required|boolean'
        ]);
        
        return Silobag::create($request->all());
    }

    /**
     * Delete Silobag.
     *
     * @return Response
     */
    public function delete($id) {

        $update = Silobag::where('id', $id)->update(['active' => 0]);

        if (!$update) {
            return new JsonResponse(null, 400);
        } 

        return new JsonResponse();
    }
}
