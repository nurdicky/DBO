<?php

namespace App\Transformers;

use App\Driver;
use League\Fractal\TransformerAbstract;

class DriverTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Driver $driver)
    {
        return [
            'nama'      => $driver->driver_name,
            'alamat'    => $driver->driver_address,
            'nomor_ktp' => $driver->driver_identity_number,
            'rute'      => $driver->driver_rute,
        ];
    }
}
