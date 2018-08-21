<?php

namespace App\Http\Controllers;

use App\Owner;
use App\Car;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::orderBy('ID', 'DESC')->get();
        return view('owners.list', ['owners' => $owners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('owners.create');
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
        $this->validate($request, [
            'owner_name' => 'required',
            'owner_identity_number' => 'required',
            'owner_address' => 'required',
            // 'owner_avatar' => 'required',
        ]);

        // $input = $request->file('owner_avatar');
        $input = $request->all();

        // $input['owner_avatar'] = 'http://'.$host.'/public/images/'.$request->owner_avatar->getClientOriginalName();
        // $request->owner_avatar->move(public_path('images'), $input['owner_avatar']);

        $owners = Owner::create($input);
        return redirect()->route('owner.index')->with('alert-success','Berhasil Menambahkan Data!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $owners = Car::where('owner_id', $id)
                    ->with('owners', 'drivers')
                    ->first();
        return response()->json($owners, 200);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $owners = Owner::find($id);
        return view('owners.edit', ['owners' => $owners]);
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
        $owners = Owner::find($id);
        // if ($request->hasFile('owner_avatar')) {
        //     $input = $request->file('owner_avatar');
        //     $input = $request->all();
        //     $input['owner_avatar'] = 'http://'.$host.'/public/images/'.$request->owner_avatar->getClientOriginalName();
        //     $request->owner_avatar->move(public_path('images'), $input['owner_avatar']);
        // }
        // else{
            $input = $request->all();
            // $input['owner_avatar'] = $owners->owner_avatar;
        // }
        
        $owners->owner_name = $input['owner_name'];
        $owners->owner_address = $input['owner_address'];
        $owners->owner_identity_number = $input['owner_identity_number'];
        // $owners->owner_avatar = $input['owner_avatar'];
        $owners->save();

        return redirect()->route('owner.index')->with('alert-success','Berhasil Memperbarui Data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Owner::destroy($id);
        return redirect()->route('owner.index')->with('alert-success','Berhasil Menghapus Data!');
    }

    public function export()
    {
        $data = Owner::orderBy('ID', 'DESC')->get();

        if (count($data) == 0) {
            return redirect()->route('rekap.index')->with('alert-danger','Sorry, Anda tidak dapat melakukan Export data dikarenakan data masih kosong !');
        }  
        else{
            return Excel::download(new \App\Exports\OwnerExport($data), 'Data Pemilik.xlsx');      
        }
    }
}
