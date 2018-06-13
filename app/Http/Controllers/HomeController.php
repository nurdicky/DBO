<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Owner;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function sync(Request $request)
    {
        $output = is_array($request->req); 
        if($output == true){

            $exist = $this->checkOwnerExist($request->req[3]);

            $avatarVal = implode('', $request->req[0]);
            $imageVal = implode('', $request->req[5]);

            if ($exist == null) {
                $owners = new Owner();
                $owners->owner_avatar = $this->explodeImage($avatarVal);
                $owners->owner_name = implode('', $request->req[1]);
                $owners->owner_address = implode('', $request->req[2]);
                $owners->owner_identity_number = implode('', $request->req[3]);
                $owners->save();

                $cars = $owners->cars()->create([
                    'car_plat_number' => implode('', $request->req[4]),
                    'car_image' => $this->explodeImage($imageVal),
                    'car_type' => implode('', $request->req[6]),
                    'car_frame_number' => implode('', $request->req[7]),
                    'car_machine_number' => implode('', $request->req[8]),
                    'car_rute' => implode('', $request->req[9]),
                    'owner_id' => $owners->id,
                ]);
                
                return response()->json([
                    'owner' => $owners,
                    'car' => $cars,
                ]);
            }    
            else{
                return response()->json('Database is already update!');
            }     

        }
        
    }

    public function checkOwnerExist($number)
    {
        return Owner::where(['owner_identity_number' => $number])->first();
    }

    public function explodeImage($arr)
    {
        return explode('"', $arr)[1];
    }
}
