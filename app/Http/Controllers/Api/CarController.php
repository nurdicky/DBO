<?php

namespace App\Http\Controllers\Api;

use App\Car;
use App\Barcode;
use App\Transformers\CarTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use League\Fractal\Manager;


class CarController extends Controller
{
    public function barcode($barcode, Car $car)
    {
        $cars = $car::where(['car_barcode' => $barcode])->first();
        
        if (!@$cars) {
            return response()->json(['error' => true, 'message' => 'Sorry, your barcode number not found !'], 200);
        }

        $response = fractal()
                    ->item($cars)
                    ->transformWith(new CarTransformer)
                    ->toArray();
                    
        return Response::json($response);
    }

    public function activation(Request $request, Car $car)
    {
        $this->validate($request, [
            'plat_nomor' => 'required',
            'barcode' => 'required',
        ]);

        $cars = $car::where(['car_plat_number' => $request->plat_nomor])->first();
        
        if (!@$cars) {
            return response()->json(['error' => true, 'message' => 'Sorry, your plat number not found !'], 401);
        }

        $barcode = Barcode::where(['barcode' => $request->barcode])->first();
        if (!@$barcode) {
            return response()->json(['error' => true, 'message' => 'Sorry, your barcode number not found !'], 401);
        }
        elseif($barcode->status == 1){
            return response()->json(['error' => true, 'message' => 'Sorry, your barcode number has been activated !'], 401);
        }
        elseif($cars->car_barcode != null){
            return response()->json(['error' => true, 'message' => 'Sorry, your plat number has been barcode number !'], 401);
        }

        if ($cars->status == 0) {
            $barcode->status = 1;
            $barcode->save();

            $cars->car_barcode = $request->barcode;
            $cars->status = 1;
            $cars->save();
        }

        $response = fractal()
                    ->item($cars)
                    ->transformWith(new CarTransformer)
                    ->toArray();
                    
        return Response::json($response);
    }

    public function detail(Car $car, $id)
    {
        $cars = $car::find($id);
        if(!@$cars){
            return response()->json(["error"=> true,"message" => "Sorry, your ID not found !"], 401);
        }

        $response = fractal()
                    ->item($cars)
                    ->transformWith(new CarTransformer)
                    ->toArray();
                    
        return Response::json($response);
    }
}
