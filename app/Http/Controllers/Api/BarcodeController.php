<?php

namespace App\Http\Controllers\Api;

use App\Barcode;
use Illuminate\Http\Request;
use App\Transformers\BarcodeTransformer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;


class BarcodeController extends Controller
{
    public function check($barcode)
    {
        $barcodes = Barcode::where(['barcode' => $barcode])->first();
        
        if (!@$barcodes) {
            return response()->json(['error' => true, 'message' => 'Sorry, your barcode number not found !'], 200);
        }

        $response = fractal()
                    ->item($barcodes)
                    ->transformWith(new BarcodeTransformer)
                    ->toArray();
                    
        return Response::json($response);
    }
}