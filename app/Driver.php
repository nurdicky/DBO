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
    ];
}
