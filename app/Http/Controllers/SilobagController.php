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
    public function chart($id, $unit) 
    {

        $start = request()->input('start');
        $end = request()->input('end');

        if (request()->input('start') == "0") {
            $end = date('m/d/Y');
            $start = date('m/d/Y', time() - (365 * 24 * 60 * 60));
        }

        list($mStart, $dStart, $yStart) = explode('/', $start);
        list($mEnd, $dEnd, $yEnd) = explode('/', $end);

        // going through days
        $unixStart = mktime(0, 0, 0, $mStart, $dStart, $yStart);
        $unixEnd = mktime(0, 0, 0, $mEnd, $dEnd, $yEnd);

        $sameMonth = ($mStart == $mEnd && $yStart == $yEnd);
        $diffDays = intval(($unixEnd - $unixStart) / 60 / 60 / 24);


        if ($diffDays < 15 ) {

            $query = "SELECT a.id, a.less_id, AVG(a.amount) AS 'amount', DATE_FORMAT(CONCAT(a.month, ' 00:00:00'), '%d') AS 'date', a.month FROM (SELECT d.id, d.less_id, m.amount, m.created_at, DATE_FORMAT(m.created_at, '%Y-%m-%d') as 'month' from metrics_history m inner join devices d on d.id = m.device where d.silobag = $id and m.metric_type = $unit and  m.created_at >= '$yStart-$mStart-$dStart' AND m.created_at <= '$yEnd-$mEnd-$dEnd') a GROUP BY a.id, a.less_id, a.month ORDER BY a.id, month;";

        } else if ($diffDays >= 15 && $diffDays < 60) {

            $query = "SELECT a.id, a.less_id, AVG(a.amount) AS 'amount', CONCAT('s', a.month) AS 'date', a.month FROM (SELECT d.id, d.less_id, m.amount, m.created_at, DATE_FORMAT(m.created_at, '%u') as 'month' from metrics_history m inner join devices d on d.id = m.device where d.silobag = $id and m.metric_type = $unit and  m.created_at >= '$yStart-$mStart-$dStart' AND m.created_at <= '$yEnd-$mEnd-$dEnd') a GROUP BY a.id, a.less_id, a.month ORDER BY a.id, month;";

        } else {
            
            $query = "SELECT a.id, a.less_id, AVG(a.amount) AS 'amount', DATE_FORMAT(CONCAT(a.month, '-01 00:00:00'), '%b') AS 'date', a.month FROM (SELECT d.id, d.less_id, m.amount, m.created_at, DATE_FORMAT(m.created_at, '%Y-%m') as 'month' from metrics_history m inner join devices d on d.id = m.device where d.silobag = $id and m.metric_type = $unit and  m.created_at >= '$yStart-$mStart-$dStart' AND m.created_at <= '$yEnd-$mEnd-$dEnd') a GROUP BY a.id, a.less_id, a.month ORDER BY a.id, month;";
        }

        $results = DB::select($query);

        if (!$results) {
            return new JsonResponse(null, 400);
        } 

        return $results;
    }
}
