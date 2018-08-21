<?php

namespace App\Exports;

use App\Car;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CarExport implements FromView
{

    public function __construct($collection)
    {
        $this->collection = $collection;
    }


    public function view(): View
    {
        return view('exports.cars', [
            'cars' => $this->collection
        ]);
    }
}