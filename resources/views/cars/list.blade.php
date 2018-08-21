@extends('layouts.master')

@section('title', 'Data Mobil')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-car"></i>
    </span>
    Data Mobil
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('car.export') }}" class="btn btn-outline-success">Export to Excel</a>
        <a href="{{ route('car.create') }}" class="btn btn-outline-primary">Tambah Data</a>
      </li>
    </ul>
  </nav>    
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body table-responsive">
        @if(Session::has('alert-success'))
          <div class="alert alert-success" style="background-color:#dff0d8 !important; color:#00a65a !important">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  
            <strong>{{ \Illuminate\Support\Facades\Session::get('alert-success') }}</strong>
          </div>
        @endif

        @if(Session::has('alert-danger'))
          <div class="alert alert-danger" style="background-color:#dff0d8 !important; color:crimson !important">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  
            <strong>{{ \Illuminate\Support\Facades\Session::get('alert-danger') }}</strong>
          </div>
        @endif

        <table table id="example" style="width:100%" class="table table-striped display">
          <thead>
            <tr>
              <th>#</th>
              {{-- <th>Mobil</th> --}}
              <th>Jenis Mobil</th>
              <th >Plat Mobil</th>
              <th>Nomor Rangka</th>
              <th>Nomor Mesin</th>
              <th>Rute</th>
              <th>Pemilik</th>
              <th>Barcode</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
              @if(count($cars) == 0)
              <tr>
                <td colspan="10">Data Masih Kosong</td>
              </tr>
            @else
              <?php $index=1; ?>
              @foreach($cars as $car)
                <tr>
                  <td>{{ $index++ }}</td>
                  {{-- <td class="py-1"> --}}
                    {{-- <img src="{{ $car->car_image }}" alt="image"/> --}}
                  {{-- </td> --}}
                  <td>{{ $car->car_type }}</td>
                  <td>{{ $car->car_plat_number }}</td>
                  <td>{{ $car->car_frame_number }}</td>
                  <td>{{ $car->car_machine_number }}</td>
                  <td>{{ $car->car_rute }}</td>
                  <td>{{ $car->owners->owner_name }}</td>
                  <td>{{ $car->car_barcode }}</td>
                  <td>
                    @if($car->status == 0)
                      <label style="width:100%" class="badge badge-gradient-danger">Not Activated</label>
                    @else
                      <label style="width:100%" class="badge badge-gradient-success">Activated</label>
                    @endif
                  </td>
                  <td>
                    <form action="{{ route('car.destroy', $car->id) }}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <a data-toggle="tooltip" title="View" class="btn btn-sm btn-success" href="{{ route('car.show', $car->id) }}"><i class="mdi mdi-eye"></i> </a> 
                      <a data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info" href="{{ route('car.edit', $car->id) }}"><i class="mdi mdi-pencil"></i> </a>
                      <button data-toggle="tooltip" title="Delete" class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Yakin ingin menghapus data?')"><i class="mdi mdi-delete"></i></button>
                    </form>
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModallLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width:650px">
    <div class="modal-content">
      <div class="modal-header" style="background: #fff; border-bottom: 1px solid #b3b6bd;">
        <h4 class="modal-title" id="defaultModalLabel"><strong>Detail Data Mobil</strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div id="content-detail" class="row">
            <div id="left" class="col-md-4" style="margin-left:-10px">
              
            </div>
            <div class="col-md-8">
              <div id="right" class="row" style="margin-left:10px">
                
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('custom_js')

  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

  <script>
    var host = window.location.hostname;
    var path = window.location.pathname;
    $(document).ready(function() {
        $('#example').DataTable();

        $('[data-toggle="tooltip"]').tooltip();   
    } );
  </script>

@endsection
