<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $fillable = [
        'owner_name',
        'owner_address',
        'owner_identity_number',
        'owner_avatar',
    ];

    public function cars()
    {
        return $this->hasMany('App\Car', 'owner_id');
    }
}
