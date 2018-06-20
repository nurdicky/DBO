<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'employee_name',
        'employee_username',
        'employee_password',
        'api_token',
    ];

    protected $hidden = [
        'password',
        'api_token',
    ];
}
