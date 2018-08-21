<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'driver_name',
        'driver_identity_number',
        'driver_address',
        'driver_rute',
        'car_id'
    ];

    public function cars()
    {
        return $this->belongsTo('App\Car', 'car_id');
    }

    public function logs()
    {
        return $this->hasMany('App\Log', 'driver_id');
    }
    
}
