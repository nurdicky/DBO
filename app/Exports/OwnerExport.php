<?php

namespace App\Exports;

use App\Owner;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OwnerExport implements FromView
{

    public function __construct($collection)
    {
        $this->collection = $collection;
    }


    public function view(): View
    {
        return view('exports.owners', [
            'owners' => $this->collection
        ]);
    }
}