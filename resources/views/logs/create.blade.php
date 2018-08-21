@extends('layouts.master')

@section('title', 'Tambah Data Log Aktivitas')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
	<h3 class="page-title">
		<span class="page-title-icon bg-gradient-primary text-white mr-2">
			<i class="mdi mdi-cached"></i>
		</span>
		Tambah Data Log Aktivitas
	</h3>
    
</div>

<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				
				<form class="forms-sample" method="POST" action="{{route('log.store')}}">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="car_id">Mobil</label>
						<select class="form-control" name="car_id" id="car_id">
							<option value=""> -- Pilih Mobil --</option>
							@foreach($cars as $car)
								<option value="{{ $car->id }}">{{ $car->id }} ( {{$car->car_plat_number}} )</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="owner_id">Pemilik</label>
						<select class="form-control" name="owner_id" id="owner_id">
							<option value=""> -- Pilih Pemilik --</option>
							@foreach($owners as $owner)
								<option value="{{ $owner->id }}">{{$owner->owner_name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="driver_id">Pengemudi</label>
						<select class="form-control" name="driver_id" id="driver_id">
							<option value=""> -- Pilih Pengemudi --</option>
							@foreach($drivers as $driver)
								<option value="{{ $driver->id }}">{{$driver->driver_name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<select class="form-control" name="status" id="status">
							<option value=""> -- Pilih Status --</option>
							<option value="IN">IN</option>
							<option value="OUT">OUT</option>
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

<script>
	var host = window.location.hostname;
	var path = window.location.pathname;
	$(document).ready(function(){
	  
	  $( "#car_id" ).change(function() {
		var str = $("#car_id option:selected").val();
		var URL = 'http://'+host+'/master/owner/'+str;
		console.log(URL);
		
		var data = JSON.parse($.ajax({
			type: 'GET',
			url : URL,
			dataType:'json',
			global: false,
			async: false,
			success:function(msg){
			}
		}).responseText)
		
		console.log(data);
		
		var htmlStr = "";
		var htmlStr2 = "";
		htmlStr += '<option value=""> -- Pilih Pemilik --</option>';
		htmlStr += '<option value="'+data.owners.id+'"> '+ data.owners.owner_name +' </option>';
		$('#owner_id option').remove();
		$('#owner_id').prepend(htmlStr);
		$('#owner_id option[value='+data.owners.id+']').prop('selected', true);		

		htmlStr2 += '<option value=""> -- Pilih Pengemudi --</option>';
		if (data.drivers.length == 0) {
			$('#driver_id option').remove();
			$('#driver_id').prepend(htmlStr2);
		}

		$.each(data.drivers, function(index, item){
			htmlStr2 += '<option value="'+item.id+'"> '+ item.driver_name +' </option>';
			$('#driver_id option').remove();
			$('#driver_id').prepend(htmlStr2);

		});
			
			

		// $.ajax({
		//   dataType : 'json',
		//   type : 'GET',
		//   url : URL,
		//   success : function(data) { 
		// 	console.log(data);
			
		//   }
		// });
	  
	  });
	});
  </script>

@endsection
