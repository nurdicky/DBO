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
    public function transform(Log $logIN, Log $logOUT)
    {
        return [
            'total_mobil_masuk' => count($logIN),
            'total_mobil_keluar' => count($logOUT),
        ];
    }
}
