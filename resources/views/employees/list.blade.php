@extends('layouts.master')

@section('title', 'Petugas')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>
    </span>
    Petugas
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('employee.export') }}" class="btn btn-outline-success">Export to Excel</a>
        <a href="{{ route('employee.create') }}" class="btn btn-outline-primary">Tambah Data</a>
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

        <table class="display table table-striped" id="example" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $index=1; ?>
            @if(count($employees) == 0)
              <tr>
                <td colspan="4">Data Masih Kosong</td>
              </tr>
            @else
              @foreach($employees as $employee)
                <tr>
                  <td>{{ $index++ }}</td>
                  <td>{{ $employee->employee_name }}</td>
                  <td>{{ $employee->employee_username }}</td>
                  <td>
                    <form action="{{ route('employee.destroy', $employee->id) }}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <a data-toggle="tooltip" title="Edit" class="btn btn-sm btn-info" href="{{ route('employee.edit', $employee->id) }}"><i class="mdi mdi-pencil"></i> </a>
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
