<?php

namespace App\Transformers;

use App\Employee;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Employee $employee)
    {
        return [
            'name' => $employee->employee_name,
            'username' => $employee->employee_username,
            'registered'  => $employee->created_at->diffForHumans(),
        ];
    }
}
