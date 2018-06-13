<?php

namespace App\Http\Controllers;

use App\Car;
use App\Owner;
use App\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::with('owners')->get();
        return view('cars.list', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $owners = Owner::all();
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
        if( $request->hasFile('car_image'))
        { 
            $img = $request->file('car_image'); 
            $extension = $img->getClientMimeType(); 
            dd($extension); 
        } else {
            dd('No image was found');
        }
        $input = $request->file('car_image');
        $input = $request->all();

        dd($request->car_image->getClientOriginalExtension());
        $input['car_image'] = time().'.'.$request->car_image->getClientOriginalExtension();
        $request->car_image->move(public_path('images'), $input['car_image']);

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
        $cars = Car::find($id); 
        $owners = Owner::all();
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
        $cars = Car::find($id);
        $cars->car_type = $request->car_type;
        $cars->car_plat_number = $request->car_plat_number;
        $cars->car_frame_number = $request->car_frame_number;
        $cars->car_rute = $request->car_rute;        
        $cars->car_image = $request->car_image;
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
}
