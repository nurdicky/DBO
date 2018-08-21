@extends('layouts.master')

@section('title', 'Rekap Data')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
  {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css"> --}}
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

  <style>
    .btn-a{
      margin: 20px; color:#1bcfb4 !important;
    }
    .btn-a:hover{
      color:#fff !important;
    }
  </style>
@endsection

@section('content')

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-table"></i>
    </span>
    Rekap Data
  </h3>
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
      </li>
    </ul>
  </nav> 
</div>

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="row" style="margin-bottom: -20px">
        <div class="col-md-12">
          <div id="reportrange" class="float-left" style="background: #fff; margin: 20px; cursor: pointer; padding: 10px; border: 1px solid #ccc; width: 25%; border-radius: 3px">
              <i class="fa fa-calendar"></i>&nbsp;
              <span></span> <i class="mdi mdi-calendar"></i>
          </div>

          <?php $now = date('Y-m-d') ?>
          <a id="cetak" href="{{ route('export.excel', [$now, $now]) }}" class="btn-a float-right btn btn-inverse btn-outline-success">Export to Excel</a>
        </div>
      </div>
             
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
              <th>Indeks</th>
              <th>Plat Nomor</th>
              <th>Pemilik Mobil</th>
              <th>Jumlah Masuk</th>
              <th>Jumlah keluar</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="table-body">
            <?php $index=1; ?>
            @if(count($data) == 0)
              <tr id="table-message">
                <td colspan="7">Data Masih Kosong</td>
              </tr>
            @else
              @foreach($data as $log)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $log->indeks }}</td>
                    <td>{{ $log->cars->car_plat_number }}</td>
                    <td>{{ $log->owners->owner_name }}</td>
                    <td>{{ $log->count_in }}</td>
                    <td>{{ $log->count_out }}</td>
                    <td>
                        @if($log->count_in != $log->count_out)
                            <label class="badge badge-danger">Tidak Sesuai</label>
                        @else
                            <label class="badge badge-success">Sesuai</label>
                        @endif
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
  {{-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> --}}
  {{-- <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script> --}}
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  
  <script>
    // $(document).ready(function() {
    //   $('#example').DataTable();
    // } );
    var host = window.location.hostname;
    var path = window.location.pathname;
    $(function() {
      // var start = moment().subtract(29, 'days');
      var start = moment();
      var end = moment();

      function cb(start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          actionFilter(start, end);
      }

      $('#reportrange').daterangepicker({
          startDate: start,
          endDate: end,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          }
      }, cb);

      cb(start, end);

      function actionFilter(start, end){
        var date1 = start.format('Y-MM-DD');
        var date2 = end.format('Y-MM-DD');

        var URL = path+'/filter/'+date1+'/'+date2;

        $('#cetak').attr("href", path+"/export/"+date1+"/"+date2);
        
        $.ajax({
          dataType : 'json',
          type : 'GET',
          url : URL,
          success : function(data) { 
            console.log(data);
            if (data.log.length == 0) {
              var table_message = "";
              $('#table-body tr').remove();
              table_message  += '<tr id="table-message">';
              table_message  += '   <td colspan="7">Data Masih Kosong</td>';
              table_message  += '</tr>';
              $('#table-body').append(table_message);
            }
            else{
              $('#table-body tr').remove();
              $.each(data.log, function(index, item){
                var table_body = '';
                var i = index+1;
                table_body += '<tr>';
                  table_body += '<td> '+ i +' </td>';
                  table_body += '<td> '+ item.indeks +'</td>';
                  table_body += '<td> '+ item.cars.car_plat_number +'</td>';
                  table_body += '<td> '+ item.owners.owner_name +'</td>';
                  table_body += '<td> '+ item.count_in +'</td>';
                  table_body += '<td> '+ item.count_out +'</td>';
                  table_body += '<td>';
                    if (item.count_in != item.count_out) {
                      table_body += '<label class="badge badge-danger">Tidak Sesuai</label>';
                    }
                    else{
                      table_body += '<label class="badge badge-success">Sesuai</label>';
                    }
                  table_body += '</td>';               
                table_body += '</tr>';
                $('#table-body').append(table_body);
              });
            }
            
          },
        });
        
      }

    });
  </script>
@endsection
