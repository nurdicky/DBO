<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::orderBy('ID', 'DESC')->get();
        return view('employees.list', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employees = Employee::create([
            'employee_name' => $request->employee_name,
            'employee_username' => $request->employee_username,
            'employee_password' => bcrypt($request->employee_password),
        ]);

        User::create([
            'name' => $request->employee_username,
            'email' => null,
            'password' => bcrypt($request->employee_password),
        ]);
        return redirect()->route('employee.index')->with('alert-success','Berhasil Menambahkan Data!');
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
        $employees = Employee::find($id);
        return view('employees.edit', ['employees' => $employees]);
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
        $employees = Employee::find($id);
        $employees->employee_name = $request->employee_name; 
        $employees->employee_username = $request->employee_username;
        $employees->employee_password = $request->employee_password;
        $employees->save();
        return redirect()->route('employee.index')->with('alert-success','Berhasil Memperbarui Data!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::destroy($id);
        return redirect()->route('employee.index')->with('alert-success','Berhasil Menghapus Data!');
    }

    public function export()
    {
        $data = Employee::orderBy('ID', 'DESC')->get();

        if (count($data) == 0) {
            return redirect()->route('rekap.index')->with('alert-danger','Sorry, Anda tidak dapat melakukan Export data dikarenakan data masih kosong !');
        }  
        else{
            return Excel::download(new \App\Exports\EmployeeExport($data), 'Data Employee.xlsx');      
        }
    }
}
