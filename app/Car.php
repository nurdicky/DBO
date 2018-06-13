<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'car_type',
        'car_plat_number',
        'car_frame_number',
        'car_machine_number',
        'car_rute',
        'car_image',
    ];

    public function owners()
    {
        return $this->belongsTo('App\Owner', 'owner_id');
    }

}
