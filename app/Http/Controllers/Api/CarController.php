<?php

namespace App\Http\Controllers\Api;

use App\Car;
use App\Transformers\CarTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CarController extends Controller
{
    public function barcode($barcode, Car $car)
    {
        $cars = $car::where(['car_barcode' => $barcode])->first();
        
        $response = fractal()
                    ->item($cars)
                    ->transformWith(new CarTransformer)
                    ->toArray();

        return Response::json($response);
    }

    public function activation(Request $request, Car $car)
    {
        # code...
    }
}
