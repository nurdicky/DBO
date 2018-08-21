<?php

namespace App\Transformers;

use App\Log;
use League\Fractal\TransformerAbstract;

class LogTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($arr)
    {
        return [
            'total_mobil_masuk'     => $arr['masuk'],
            'total_mobil_keluar'    => $arr['keluar'],
            'tanggal'               => Date('Y-m-d')
        ];
    }
}
