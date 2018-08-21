<?php

namespace App\Exports;

use App\Log;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LogActivityExport implements FromView
{

    public function __construct($collection)
    {
        $this->collection = $collection;
    }


    public function view(): View
    {
        return view('exports.logs_activity', [
            'logs' => $this->collection
        ]);
    }
}