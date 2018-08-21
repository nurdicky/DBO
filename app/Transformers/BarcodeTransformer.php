<?php

namespace App\Transformers;

use App\Barcode;
use League\Fractal\TransformerAbstract;

class BarcodeTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Barcode $barcode)
    {
        return [
            'barcode'   => $barcode->barcode,
            'status'    => ($barcode->status != 0) ? 'Activated' : 'Not Activated'
        ];
    }
}
