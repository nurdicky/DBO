<?php

namespace App\Transformers;

use App\Car;
use App\Transformers\DriverTransformer;
use App\Transformers\OwnerTransformer;
use League\Fractal\TransformerAbstract;

class CarTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'owners', 'drivers'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Car $car)
    {
        return [
            'id'              => $car->id,
            'jenis_mobil'     => $car->car_type,
            'plat_nomor'      => $car->car_plat_number,
            'nomor_rangka'    => $car->car_frame_number,
            'nomor_mesin'     => $car->car_machine_number,
            'foto_mobil'      => $car->car_image,
            'rute_mobil'      => $car->car_rute,
            'pemilik_id'      => $car->owner_id,
            'barcode'      => $car->car_barcode,
            'status'          => ($car->status == 0) ? 'Not Activated' : 'Activated' ,
        ];
    }

    public function includeOwners(Car $car)
    {
        $owners = $car->owners;

        return $this->item($owners, new OwnerTransformer);
    }

    public function includeDrivers(Car $car)
    {
        $drivers = $car->drivers;

        return $this->collection($drivers, new DriverTransformer);
    }

}
