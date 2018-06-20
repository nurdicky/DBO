<?php

namespace App\Transformers;

use App\Car;
use League\Fractal\TransformerAbstract;

class CarTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Car $car)
    {
        return [
            'jenis_mobil'     => $car->car_type,
            'plat_nomor'      => $car->car_plat_number,
            'nomor_rangka'    => $car->car_frame_number,
            'nomor_mesin'     => $car->car_machine_number,
            'foto_mobil'      => $car->car_image,
            'rute_mobil'      => $car->car_rute,
        ];
    }
}
