@extends('layouts.master')

@section('title', 'Edit Data Pengemudi')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
@endsection


@section('content')

<div class="page-header">
	<h3 class="page-title">
		<span class="page-title-icon bg-gradient-primary text-white mr-2">
			<i class="mdi mdi-car"></i>
		</span>
		Edit Data Pengemudi
	</h3>
    
</div>

<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				
				<form class="forms-sample"  action="{{ route('driver.update', $drivers->id) }}" method="POST"  enctype="multipart/form-data">
					{{ method_field('PUT') }}
					{{ csrf_field() }}
					<div class="form-group">
						<label for="driver_name">Nama Pengemudi</label>
						<input type="text" class="form-control" name="driver_name" id="driver_name" value="{{$drivers->driver_name}}" >
					</div>
					<div class="form-group">
						<label for="driver_identity_number">Nomor KTP</label>
						<input type="text" class="form-control" name="driver_identity_number" id="driver_identity_number" value="{{$drivers->driver_identity_number}}">
					</div>
					<div class="form-group">
						<label for="driver_address">Alamat Pengemudi</label>
						<textarea class="form-control" rows="4" name="driver_address" id="driver_address">{{$drivers->driver_address}}</textarea>
					</div>
					<div class="form-group">
						<label for="driver_rute">Rute</label>
						<textarea class="form-control" rows="4" name="driver_rute" id="driver_rute">{{$drivers->driver_rute}}</textarea>
					</div>
					<div class="form-group">
						<label for="car_id">Mobil</label>
						<select class="form-control" name="car_id" id="car_id">
							<option value=""> -- Pilih Mobil --</option>
							@foreach($cars as $car)
								<option <?= ($drivers->car_id == $car->id) ? 'selected' : '' ; ?> value="{{ $car->id }}">{{ $car->id }} ( {{$car->car_plat_number}} )</option>
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
