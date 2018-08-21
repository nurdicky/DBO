@extends('layouts.master')

@section('title', 'Log Keluar')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-clock-in"></i>
    </span>
    Log Masuk
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <!-- <a href="{{ route('log.create') }}" class="btn btn-outline-primary">Tambah Data</a> -->
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

        <table class="display table table-striped" id="example" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Mobil (Car ID)</th>
              <th>Pengemudi</th>
              <th>Status</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php $index=1; ?>
            @if(count($logs) == 0)
              <tr>
                <td colspan="4">Data Masih Kosong</td>
              </tr>
            @else
              @foreach($logs as $log)
                <tr>
                  <td>{{ $index++ }}</td>
                  <td>{{ $log->cars->car_plat_number }} <span class="badge" style="background: #abd5ff">{{ $log->car_id }} </span></td>
                  <td>
                    @if($log->driver_id != NULL)
                      {{ $log->drivers->driver_name }} <span class="badge" style="background: #1bcfb4">Driver</span>
                    @else
                      {{ $log->owners->owner_name }} <span class="badge" style="background: #f6e384">Pemilik</span>
                    @endif
                  </td>
                  <td >
                    <span style="width:100%" class="btn btn-xs btn-inverse-success">{{ $log->status }}</span>
                  </td>
                  <td>{{ $log->created_at }}</td>
                  
                </tr>
              @endforeach
            @endif
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('custom_js')
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    } );
  </script>
@endsection
