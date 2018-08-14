<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Models\Silobag;
use DB;

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

    /**
     * Chart Data.
     *
     * @return Response
     */
    public function chart($id, $days, $unit) {

        $days++;

        $query = "SELECT a.id, a.less_id, AVG(a.amount) AS 'amount', DATE_FORMAT(CONCAT(a.month, '-01 00:00:00'), '%b') AS 'date', a.month FROM (SELECT d.id, d.less_id, m.amount, m.created_at, DATE_FORMAT(m.created_at, '%Y-%m') as 'month' from metrics_history m inner join devices d on d.id = m.device where d.silobag = $id and m.metric_type = $unit and  m.created_at >= SUBDATE(NOW(), $days)) a GROUP BY a.id, a.less_id, a.month ORDER BY a.id, month";

        if ($days < 30) 
        {
            $query = "SELECT a.id, a.less_id, AVG(a.amount) AS 'amount', DATE_FORMAT(CONCAT(a.month, ' 00:00:00'), '%D') AS 'date', a.month FROM (SELECT d.id, d.less_id, m.amount, m.created_at, DATE_FORMAT(m.created_at, '%Y-%m-%d') as 'month' from metrics_history m inner join devices d on d.id = m.device where d.silobag = $id and m.metric_type = $unit and  m.created_at >= SUBDATE(NOW(), $days)) a GROUP BY a.id, a.less_id, a.month ORDER BY a.id, month";
        }



        $results = DB::select($query);

        if (!$results) {
            return new JsonResponse(null, 400);
        } 

        return $results;
    }
}
