<?php

namespace App\Http\Controllers;

use App\Log;
use App\Car;
use App\Driver;
use App\Owner;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Log::all();
        return view('logs.list', ['logs' => $logs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('logs.create');
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
        return view('logs.edit', ['logs' => $logs]);
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
}
