@extends('layouts.master')

@section('title', 'Log Activitas')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-cached"></i>
    </span>
    Log Aktivitas
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('log.create') }}" class="btn btn-outline-primary">Tambah Data</a>
      </li>
    </ul>
  </nav> 
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
          @if(Session::has('alert-success'))
            <div class="alert alert-success" style="background-color:#dff0d8 !important; color:#00a65a !important">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>  
              <strong>{{ \Illuminate\Support\Facades\Session::get('alert-success') }}</strong>
            </div>
          @endif

        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Car ID</th>
              <th>Owner ID</th>
              <th>Driver ID</th>
              <th>Status</th>
              <th>Aksi</th>
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
                  <td>{{ $log->car_id }}</td>
                  <td>{{ $log->owner_id }}</td>
                  <td>{{ $log->driver_id }}</td>
                  <td>{{ $log->status }}</td>
                  <td>
                    <form action="{{ route('log.destroy', $log->id) }}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <a class="btn btn-sm btn-info" href="{{ route('log.edit', $log->id) }}">Edit</a>
                      <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Yakin ingin menghapus data?')">Delete</button>
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

@endsection

@section('custom_js')

@endsection
