<?php

namespace App\Exports;

use App\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmployeeExport implements FromView
{

    public function __construct($collection)
    {
        $this->collection = $collection;
    }


    public function view(): View
    {
        return view('exports.employees', [
            'employees' => $this->collection
        ]);
    }
}