<?php

namespace App\Http\Controllers\Api;

use App\Driver;
use App\Car;
use App\Transformers\DriverTransformer;
use App\Transformers\CarTransformer;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class DriverController extends Controller
{
    public function create(Request $request, Driver $driver)
    {
        $this->validate($request, [
			'nama'      => 'required',
            'nomor_ktp' => 'required',
            'alamat'    => 'required',
            'rute'      => 'required',
            'car_id'    => 'required',
        ]);
        
        $drivers = $driver::create([
            'driver_name'            => $request->nama,
            'driver_identity_number' => $request->nomor_ktp,
            'driver_address'         => $request->alamat,
            'driver_rute'            => $request->rute,
            'car_id'                 => $request->car_id,
        ]);

        return Response::json([
            'message' => 'Create data successfully !',
            'data' => $drivers
        ], 201);
    }

    public function list($carId)
    {
        $drivers = Car::where('id', $carId)->with(['owners', 'drivers'])->first();

        $response = fractal()
                    ->item($drivers)
                    ->transformWith(new CarTransformer)
                    ->toArray();

        $fractal = new Manager;
        $fractal->parseExcludes('owners', 'drivers');

        return Response::json($response);
    }

    public function update(Request $request, $id)
    {
        $drivers = Driver::find($id);
        if (!@$drivers) {
            return response()->json(['error' => true, 'message' => 'Sorry, your ID not found !'], 401);
        }

        $drivers->driver_name = ($request->nama == null) ? $drivers->driver_name : $request->nama;
        $drivers->driver_identity_number = ($request->nomor_ktp == null) ? $drivers->driver_identity_number : $request->nomor_ktp;
        $drivers->driver_address = ($request->alamat == null) ? $drivers->driver_address : $request->alamat;
        $drivers->driver_rute = ($request->rute == null) ? $drivers->driver_rute : $request->rute;
        $drivers->car_id = ($request->car_id == null) ? $drivers->car_id : $request->car_id;
        $drivers->save();

        return response()->json([
            'message' => 'Update driver successfully !',
            'data' => $drivers
        ], 201);
    }
}
