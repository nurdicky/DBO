<?php

namespace App\Http\Controllers\Sheets;

use App\user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;

use Revolution\Google\Sheets\Facades\Sheets;
use PulkitJalan\Google\Facades\Google;

/**
 * 1. spreadsheetList
 */
class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        // Facade
        //        $user = $request->user();
        //
        //        $token = [
        //            'access_token'  => $user->access_token,
        //            'refresh_token' => $user->refresh_token,
        //            'expires_in'    => 3600,
        //            'created'       => $user->updated_at->getTimestamp(),
        //        ];
        //
        //        $spreadsheets = Sheets::setAccessToken($token)
        //                              ->spreadsheetList();

        // GoogleSheets Trait
        $spreadsheets = $request->user()
                                ->sheets()
                                ->spreadsheetList();


        return view('sheets.index')->with(compact('spreadsheets'));
    }

    public function index(Request $request)
    {
        $spreadsheets = $request->user()
                                ->sheets()
                                ->spreadsheetList();

        return view('sheets.index')->with(compact('spreadsheets'));

    }
}
