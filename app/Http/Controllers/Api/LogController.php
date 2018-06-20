<?php

namespace App\Http\Controllers\Api;

use App\Log;
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
        ]);
        
        $logs = $log::create([
            'car_id' => $request->car_id,
            'owner_id' => $request->owner_id,
            'driver_id' => ($request->driver_id == null) ? null : $request->driver_id ,
        ]);

        return response()->json([
            'message' => 'Create transaction succesfully !',
            'data' => $logs
        ], 201);
    }
}
