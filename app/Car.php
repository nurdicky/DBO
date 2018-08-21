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
        // 'car_image',
        'owner_id',
        // 'car_barcode'
    ];

    public function owners()
    {
        return $this->belongsTo('App\Owner', 'owner_id');
    }

    public function drivers()
    {
        return $this->hasMany('App\Driver', 'car_id');
    }

    public function logs()
    {
        return $this->hasMany('App\Log', 'car_id');
    }

}
