@extends('layouts.master')

@section('title', 'Tambah Data Mobil')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
	<h3 class="page-title">
		<span class="page-title-icon bg-gradient-primary text-white mr-2">
			<i class="mdi mdi-car"></i>
		</span>
		Tambah Data Mobil
	</h3>
    
</div>

<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				
				<form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{route('car.store')}}">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="car_type">Jenis Mobil</label>
						<input required type="text" class="form-control" name="car_type" id="car_type" placeholder="Jenis Mobil">
					</div>
					<div class="form-group">
						<label for="car_plat_number">Plat Nomor Mobil</label>
						<input required type="text" class="form-control" name="car_plat_number" id="car_plat_number" placeholder="Plat Nomor Mobil">
					</div>
					<div class="form-group">
						<label for="car_frame_number">Nomor Rangka Mobil</label>
						<input required type="text" class="form-control" name="car_frame_number" id="car_frame_number" placeholder="Nomor Rangka Mobil">
					</div>
					<div class="form-group">
						<label for="car_machine_number">Nomor Mesin Mobil</label>
						<input required type="text" class="form-control" name="car_machine_number" id="car_machine_number" placeholder="Nomor Mesin Mobil">
					</div>
					<div class="form-group">
						<label for="car_rute">Rute</label>
						<input required type="text" class="form-control" name="car_rute" id="car_rute" placeholder="Rute">
					</div>
					<div class="form-group">
						<label for="owner_id">Pemilik Mobil</label>
						<select class="form-control" name="owner_id" id="owner_id" required>
							<option value=""> -- Pilih Pemilik Mobil --</option>
							@foreach($owners as $owner)
								<option value="{{ $owner->id }}"> {{ $owner->owner_name }}</option>
							@endforeach
						</select>
					</div>
					{{-- <div class="form-group">
						<label>Foto Mobil</label>
						<input required type="file" name="car_image" class="form-control">
					</div> --}}
					{{-- <div class="form-group">
						<label for="package_barcode">Barcode</label>
						<div class="row" style="margin-bottom:20px">
							<button style="margin-left: 20px;" id="btn-generate" type="submit" class="btn btn-sm btn-default">Generate</a>
						</div>

						<div class="col-md-12" id="img-barcode">
							<input required id="car_barcode" type="hidden" class="form-control" name="car_barcode" required>
						</div>
					</div> --}}

					<button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
					<a href="{{ url()->previous() }}" class="btn btn-light">Cancel</a>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('custom_js')

<script type="text/javascript">
	$( "#btn-generate" ).click(function(e) {
		e.preventDefault();
	
		$.ajax({
			dataType : 'json',
			type : 'GET',
			url : '{{ route("barcode") }}',
			success : function(data) {
				$('#img-barcode img').remove();
				var html = '<img src="data:image/png;base64,'+data.code+'" />';
				$('#car_barcode').val(data.number);
				$('#img-barcode').prepend(html);
			}
		});
  
	});
</script>

@endsection
