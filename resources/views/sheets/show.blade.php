@extends('layouts.master')

@section('title', 'Update Database')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-cached"></i>
    </span>
    Spreadsheets
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
            <a href="{{ url()->previous() }}" class="btn btn-outline-default">Back</a>
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

          <h4>Pilih salah satu sheet :</h4>
          <ul>
            @foreach($sheets as $id => $title)
                <li><a href="{{ route('sheets.sheet', [$spreadsheet_id, $title]) }}">{{ $title }}</a></li>
            @endforeach
        </ul>
      </div>
      <div class="card-footer">
        <p><strong>Keterangan :</strong></p>
        <p>ROW 0 = nama kolom </p> 
        <p>ROW 1 s/d seterusnya = isi kolom</p>
        <p><strong>* kolom harus sesuai dengan format</strong></p>
        <br>
        <p><strong>Contoh :</strong></p>
        <table class="table table-stripped">
          <thead>
            <th>Nama pemilik</th>
            <th>Alamat</th>
            <th>No KTP</th>
            <th>No Plat</th>
            <th>Jenis  Mobil</th>
            <th>No Rangka</th>
            <th>No Mesin</th>
            <th>Rute</th>
          </thead>
          <tbody>
            <td>Required</td>
            <td>Required</td>
            <td>Required</td>
            <td>Required</td>
            <td>Required</td>
            <td>Required</td>
            <td>Required</td>
            <td>Required</td>
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
