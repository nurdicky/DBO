@extends('layouts.master')

@section('title', 'Detail Data Mobil')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-car"></i>
    </span>
    Detail Data Mobil
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>
      </li>
    </ul>
  </nav>    
</div>

<div class="row">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="float-left">Jenis Mobil</h5>
                    </div>
                    <div class="col-md-6">
                        <h4 class="btn btn-sm btn-outline-primary" style="width: 100%;">{{$cars->car_type}}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5 class="float-left">Nomor Plat Mobil</h5>
                    </div>
                    <div class="col-md-6">
                        <h4 class="btn btn-sm btn-outline-success" style="width: 100%;">{{$cars->car_plat_number}}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5 class="float-left">Nomor Rangka Mobil</h5>
                    </div>
                    <div class="col-md-6">
                        <h4 class="btn btn-sm btn-outline-info" style="width: 100%;">{{$cars->car_frame_number}}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5 class="float-left">Nomor Mesin Mobil</h5>
                    </div>
                    <div class="col-md-6">
                        <h4 class="btn btn-sm btn-outline-danger" style="width: 100%;">{{$cars->car_machine_number}}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5 class="float-left">Rute Mobil</h5>
                    </div>
                    <div class="col-md-6">
                        <h4 class="btn btn-sm btn-outline-info" style="width: 100%;">{{$cars->car_rute}}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5 class="float-left">Pemilik Mobil</h5>
                    </div>
                    <div class="col-md-6">
                        <h4 class="btn btn-sm btn-outline-success" style="width: 100%;">{{$cars->owners->owner_name}}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5 class="float-left">Barcode</h5>
                    </div>
                    <div class="col-md-6">
                        <h4 class="btn btn-sm btn-outline-primary" style="width: 100%;">{{$cars->car_barcode}}</h4>
                    </div>
                    <div class="col-md-6">
                        <h5 class="float-left">Status</h5>
                    </div>
                    <div class="col-md-6">
                        <?php $status = ($cars->status == 0) ? 'Not Activated' : 'Activated' ; ?>
                        <h4 class="btn btn-sm btn-gradient-primary" style="width: 100%;">{{$status}}</h4>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body" style="text-align: center">
                <img src="data:image/png;base64,{{$code}}" />
                <div class="space"></div>
                <img height="200px" src="{{$cars->car_image}}" alt="image">
            </div>
        </div>
    </div>
</div>


@endsection

@section('custom_js')

@endsection
