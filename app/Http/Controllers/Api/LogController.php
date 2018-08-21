<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Log;
use Carbon\Carbon;
use App\Transformers\LogTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function transaction(Log $log, Request $request)
    {
        $this->validate($request, [
			'car_id' => 'required',
			'owner_id' => 'required',
			'status' => 'required',
        ]);
        
        $logs = $log::create([
            'car_id' => $request->car_id,
            'owner_id' => $request->owner_id,
            'driver_id' => ($request->driver_id == null) ? null : $request->driver_id ,
            'status' => strtoupper($request->status),
        ]);

        return response()->json([
            'message' => 'Create transaction succesfully !',
            'data' => $logs
        ], 201);
    }

    public function getByDay()
    {
        $logsIN = Log::where('status', 'IN')->where(DB::raw('DATE(created_at)'), '=', Carbon::now()->format('Y-m-d'))->get();
        $logsOUT = Log::where('status', 'OUT')->where(DB::raw('DATE(created_at)'), '=', Carbon::now()->format('Y-m-d'))->get();

        $arr = array(
            'masuk' => count($logsIN), 
            'keluar' => count($logsOUT)
        );

        $response = fractal()
                    ->item($arr)
                    ->transformWith(new LogTransformer)
                    ->toArray();

        return Response::json($response);
    }
}
