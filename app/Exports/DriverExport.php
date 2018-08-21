<?php

namespace App\Exports;

use App\Driver;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DriverExport implements FromView
{

    public function __construct($collection)
    {
        $this->collection = $collection;
    }


    public function view(): View
    {
        return view('exports.drivers', [
            'drivers' => $this->collection
        ]);
    }
}