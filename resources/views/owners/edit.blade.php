@extends('layouts.master')

@section('title', 'Edit Data Pemilik')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
	<h3 class="page-title">
		<span class="page-title-icon bg-gradient-primary text-white mr-2">
			<i class="mdi mdi-car"></i>
		</span>
		Edit Data Pemilik
	</h3>
    
</div>

<div class="row">
	<div class="col-12 grid-margin stretch-card">
		<div class="card">
			<div class="card-body">
				
				<form class="forms-sample"  action="{{ route('owner.update', $owners->id) }}" method="POST"  enctype="multipart/form-data">
					{{ method_field('PUT') }}
					{{ csrf_field() }}
					<div class="form-group">
						<label for="owner_name">Nama Pemilik</label>
						<input type="text" class="form-control" name="owner_name" id="owner_name" value="{{$owners->owner_name}}" >
					</div>
					<div class="form-group">
						<label for="owner_address">Alamat Pemilik</label>
						<textarea class="form-control" rows="4" name="owner_address" id="owner_address">{{$owners->owner_address}}</textarea>
					</div>
					<div class="form-group">
						<label for="owner_identity_number">Nomor KTP</label>
						<input type="text" class="form-control" name="owner_identity_number" id="owner_identity_number" value="{{$owners->owner_identity_number}}">
					</div>
					
					<!-- <div class="form-group">
						<label>Foto </label>
						<input type="file" name="owner_avatar" class="form-control">
					</div> -->

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
