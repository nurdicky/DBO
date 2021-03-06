@extends('layouts.master')

@section('title', 'Tambah Petugas')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
	<h3 class="page-title">
		<span class="page-title-icon bg-gradient-primary text-white mr-2">
			<i class="mdi mdi-account"></i>
		</span>
		Tambah Petugas
	</h3>
    
</div>

<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				
				<form class="forms-sample" method="POST" action="{{route('employee.store')}}">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="employee_name">Nama Petugas</label>
						<input required type="text" class="form-control" name="employee_name" id="employee_name" placeholder="Nama Petugas">
					</div>
					<div class="form-group">
						<label for="employee_username">Username</label>
						<input required type="text" class="form-control" name="employee_username" id="employee_username" placeholder="Username">
					</div>
					<div class="form-group">
						<label for="employee_password">Password</label>
						<input required type="password" class="form-control" name="employee_password" id="employee_password" placeholder="Password">
					</div>

					<button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
					<a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('custom_js')

@endsection
