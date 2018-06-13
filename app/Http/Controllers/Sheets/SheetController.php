<?php

namespace App\Http\Controllers\Sheets;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;


use Sheets;
use Google;

/**
 * 3. sheet
 */
class SheetController extends Controller
{
    public function __invoke(Request $request, $spreadsheet_id, $sheet_id)
    {
        $user = $request->user();

        $response = Curl::to('https://sheets.googleapis.com/v4/spreadsheets/1fElYACfo-DVt7jVu6sMOxrihA8PQBjlHHAhRsnlEiow?includeGridData=true')
                          ->withHeader('Accept: application/json')
                          ->withHeader('Authorization: Bearer '.$user->access_token)
                          ->get();

        $data = json_decode($response)->sheets[0]->data[0]->rowData;

        foreach ($data as $key => $value) {
          foreach ($value as $key => $item) {
            $array = array('');
            foreach ($item as $key => $value) {
              $key = key((array)$value);
              $key2 = key((array)$value->$key);
              // dd($value->$key->$key2);

              if ($key2 == 'formulaValue') {
                $imgStr = $value->$key->$key2;
                $imgUrl = explode('"', $imgStr);
                array_push($array, $imgUrl[1]);
              }else{
                array_push($array, $value->$key->$key2);
              }

            }
            $filtered = array_except($array, [0]);

            $arr[] = array_merge_recursive($filtered  );

          }
        }
        $rows = (collect($arr));
        $headers = $rows->pull(0);

        // $token = [
        //     'access_token'  => $user->access_token,
        //     'refresh_token' => $user->refresh_token,
        //     'expires_in'    => $user->expires_in,
        //     'created'       => $user->updated_at->getTimestamp(),
        // ];
        //
        // // GoogleSheets Trait
        // $rows = $request->user()
        //                 ->sheets()
        //                 ->spreadsheet($spreadsheet_id)
        //                 ->sheet($sheet_id)
        //                 ->get();
        //
        // dd(Sheets::setAccessToken($token)->spreadsheet($spreadsheet_id)->sheet($sheet_id)->all());
        // $headers = $rows->pull(0);

        return view('sheets.sheet')->with(compact('headers', 'rows'));
    }
}
