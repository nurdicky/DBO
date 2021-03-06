<?php

namespace App\Http\Controllers;

use App\Driver;
use App\Car;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = Driver::orderBy('ID', 'DESC')->get();
        return view('drivers.list', ['drivers' => $drivers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = Car::all();
        return view('drivers.create', ['cars' => $cars ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $drivers = Driver::create($request->all());
        return redirect()->route('driver.index')->with('alert-success','Berhasil Menambahkan Data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $drivers = Driver::find($id);
        $cars = Car::all();
        return view('drivers.edit', ['drivers' => $drivers, 'cars' => $cars ]);
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
        $drivers = Driver::find($id);
        $drivers->driver_name = $request->driver_name;
        $drivers->driver_identity_number = $request->driver_identity_number;
        $drivers->driver_address = $request->driver_address;
        $drivers->driver_rute = $request->driver_rute;
        $drivers->car_id = $request->car_id;
        $drivers->save();

        return redirect()->route('driver.index')->with('alert-success','Berhasil Memperbarui Data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Driver::destroy($id);
        return redirect()->route('driver.index')->with('alert-success','Berhasil Menghapus Data!');
    }

    public function export()
    {
        $data = Driver::with('cars')->orderBy('ID', 'DESC')->get();

        if (count($data) == 0) {
            return redirect()->route('rekap.index')->with('alert-danger','Sorry, Anda tidak dapat melakukan Export data dikarenakan data masih kosong !');
        }  
        else{
            return Excel::download(new \App\Exports\DriverExport($data), 'Data Pengemudi.xlsx');      
        }
    }
}
