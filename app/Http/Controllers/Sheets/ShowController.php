<?php

namespace App\Http\Controllers\Sheets;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Sheets;
use Google;

/**
 * 2. sheetList
 */
class ShowController extends Controller
{
    public function __invoke(Request $request, $spreadsheet_id)
    {

        // GoogleSheets Trait
        $sheets = $request->user()
                          ->sheets()
                          ->spreadsheet($spreadsheet_id)
                          ->sheetList();

        return view('sheets.show')->with(compact('spreadsheet_id', 'sheets'));
    }
}
