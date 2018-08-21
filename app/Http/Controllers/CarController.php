<?php

namespace App\Http\Controllers;

use App\Car;
use App\Owner;
use App\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class CarController extends Controller
{   
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::with('owners')->orderBy('ID', 'DESC')->get();
        return view('cars.list', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $owners = Owner::orderBy('owner_name')->get();
        return view('cars.create', ['owners' => $owners]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $host = request()->getHttpHost();
        // $input = $request->file('car_image');
        $input = $request->all();

        // $input['car_image'] = 'http://'.$host.'/public/images/'.$request->car_image->getClientOriginalName();
        // $request->car_image->move(public_path('images'), $input['car_image']);

        $cars = Car::create($input);
        return redirect()->route('car.index')->with('alert-success','Berhasil Menambahkan Data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cars = Car::where('id',$id)->with('owners')->first(); 

        $barcode = new BarcodeGenerator();
        $barcode->setText($cars->car_barcode);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(2);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        return view('cars.detail', ['cars' => $cars, 'code' => $code]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cars = Car::find($id); 
        $owners = Owner::orderBy('owner_name')->get();
        return view('cars.edit', ['cars' => $cars, 'owners' => $owners]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $host = request()->getHttpHost();
        $cars = Car::find($id);
        // if ($request->hasFile('car_image')) {
        //     $input = $request->file('car_image');
        //     $input = $request->all();
        //     $input['car_image'] = 'http://'.$host.'/public/images/'.$request->car_image->getClientOriginalName();
        //     $request->car_image->move(public_path('images'), $input['car_image']);
        // }
        // else{
            $input = $request->all();
            // $input['car_image'] = $cars->car_image;
        // }

        $cars->car_type = $input['car_type'];
        $cars->car_plat_number = $input['car_plat_number'];
        $cars->car_frame_number = $input['car_frame_number'];
        $cars->car_rute = $input['car_rute'];        
        // $cars->car_image = $input['car_image'];
        $cars->owner_id = $input['owner_id'];
        // $cars->car_barcode = $input['car_barcode'];
        $cars->save();

        return redirect()->route('car.index')->with('alert-success','Berhasil Memperbarui Data!');
    }

    /** 
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Car::destroy($id);
        return redirect()->route('car.index')->with('alert-success','Berhasil Menghapus Data!');
    }

    public static function barcode($number=null)
    {
        if ($number) {
          $rand = $number;
        }else{
          $rand = mt_rand(1000000000, mt_getrandmax());
        }
        $barcode = new BarcodeGenerator();
        $barcode->setText((string)$rand);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(2);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        if ($number) {
          return $code;
        }else{
          return response()->json(['code' => $code, 'number' => $rand ]);
        }
    }

    public function export()
    {
        $data = Car::with('owners')->orderBy('ID', 'DESC')->get();

        if (count($data) == 0) {
            return redirect()->route('rekap.index')->with('alert-danger','Sorry, Anda tidak dapat melakukan Export data dikarenakan data masih kosong !');
        }  
        else{
            return Excel::download(new \App\Exports\CarExport($data), 'Data Mobil.xlsx');      
        }
    }
}
