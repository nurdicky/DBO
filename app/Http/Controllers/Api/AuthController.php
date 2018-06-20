<?php

namespace App\Http\Controllers\Api;

use App\Employee; 
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	protected function guard()
    {
      return Auth::guard('api');
	}
	
	public function login(Request $request, Employee $employee)
	{
		$this->validate($request, [
			'username' => 'required',
			'password' => 'required|min:6',
		]);
		$employees = $employee::where('employee_username', $request->username)->first();
		
		if($employees->api_token == null){
			$employees->api_token = bcrypt($request->username);
			$employees->save();
		}

		if ((@$employees->employee_username !== $request->username) && (!Hash::check($request->password,  @$employees->employee_password))) {
			return Response::json(['error' => 'Your credential is wrong'], 401);
		}

		$response =  fractal()
					->item($employees)
					->transformWith( new UserTransformer)
					->addMeta([
						'token' => $employees->api_token
					])
					->toArray();
		return Response::json($response );
	}

	public function profile(Employee $employee)
    {
      $user = $this->guard()->user();
      $employees = $employee::find($user->id);
      $response =  fractal()
                  ->item($employees)
                  ->transformWith( new UserTransformer)
                  ->toArray();
      return Response::json($response);
	}
	
	public function update(Employee $employee)
	{
		$user = $this->guard()->user();
		return Response::json($user);
	}
}
