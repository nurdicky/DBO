<?php

namespace App\Http\Controllers;

use App\Log;
use App\Car;
use App\Driver;
use App\Owner;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Log::with('cars', 'owners', 'drivers')->orderBy('ID', 'DESC')->get();
        return view('logs.list', ['logs' => $logs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = Car::all();
        $drivers = Driver::orderBy('driver_name')->get();
        $owners = Owner::orderBy('owner_name')->get();
        return view('logs.create', ['cars' => $cars, 'owners' => $owners, 'drivers' => $drivers ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logs = Log::create([
            'car_id' => $request->car_id,
            'owner_id' => $request->owner_id,
            'driver_id' => $request->driver_id,
            'status' => $request->status,
        ]);
        
        return redirect()->route('log.index')->with('alert-success','Berhasil Menambahkan Data!');
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
        $logs = Log::find($id);
        $cars = Car::all();
        $drivers = Driver::orderBy('driver_name')->get();
        $owners = Owner::orderBy('owner_name')->get();
        return view('logs.edit', ['logs' => $logs, 'cars' => $cars, 'owners' => $owners, 'drivers' => $drivers]);
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
        $logs = Log::find($id);
        $logs->car_id = $request->car_id; 
        $logs->owner_id = $request->owner_id;
        $logs->driver_id = $request->driver_id;
        $logs->status = $request->status;
        $logs->save();
        return redirect()->route('log.index')->with('alert-success','Berhasil Memperbarui Data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::destroy($id);
        return redirect()->route('log.index')->with('alert-success','Berhasil Menghapus Data!');
    }

    public function masuk()
    {
        $logs = Log::where('status', 'IN')->with('cars', 'owners')->orderBy('id', 'DESC')->get();

        return view('masuk', ['logs' => $logs]);
    }

    public function keluar()
    {
        $logs = Log::where('status', 'OUT')->with('cars', 'owners')->orderBy('id', 'DESC')->get();

        return view('keluar', ['logs' => $logs]);
    }

    public function export()
    {
        $data = Log::with('cars', 'owners', 'drivers')->orderBy('ID', 'DESC')->get();

        if (count($data) == 0) {
            return redirect()->route('rekap.index')->with('alert-danger','Sorry, Anda tidak dapat melakukan Export data dikarenakan data masih kosong !');
        }  
        else{
            return Excel::download(new \App\Exports\LogActivityExport($data), 'Data Log Aktivitas.xlsx');      
        }
    }
}
