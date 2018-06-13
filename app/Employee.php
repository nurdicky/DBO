<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_name',
        'employee_username',
        'employee_password',
    ];

    protected $hidden = [
        'password',
    ];
}
