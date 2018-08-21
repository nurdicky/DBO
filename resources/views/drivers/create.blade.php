@extends('layouts.master')

@section('title', 'Tambah Data Pengemudi')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
	<h3 class="page-title">
		<span class="page-title-icon bg-gradient-primary text-white mr-2">
			<i class="mdi mdi-car"></i>
		</span>
		Tambah Data Pengemudi
	</h3>
    
</div>

<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				
				<form class="forms-sample" method="POST" action="{{route('driver.store')}}">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="driver_name">Nama Pengemudi</label>
						<input required type="text" class="form-control" name="driver_name" id="driver_name" placeholder="Nama Pengemudi">
					</div>
					<div class="form-group">
						<label for="driver_identity_number">Nomor KTP</label>
						<input required type="text" class="form-control" name="driver_identity_number" id="driver_identity_number" placeholder="Nomor KTP">
					</div>
					<div class="form-group">
						<label for="driver_address">Alamat Pengemudi</label>
						<textarea required class="form-control" rows="4" name="driver_address" id="driver_address" placeholder="Alamat Pengemudi"></textarea>
					</div>
					<div class="form-group">
						<label for="driver_rute">Rute</label>
						<input required type="text" class="form-control" name="driver_rute" id="driver_rute" placeholder="Rute">
					</div>
					<div class="form-group">
						<label for="car_id">Mobil</label>
						<select class="form-control" name="car_id" id="car_id" required>
							<option value=""> -- Pilih Mobil --</option>
							@foreach($cars as $car)
								<option value="{{ $car->id }}">{{ $car->id }} ( {{$car->car_plat_number}} )</option>
							@endforeach
						</select>
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
