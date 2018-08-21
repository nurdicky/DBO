@extends('layouts.master')

@section('title', 'Dashboard')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
@endsection

@section('content')

<div id="container" style="width:100%; height: 8px; position: relative;"></div>

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

<div class="row">
  <div class="col-12">
    <span class="d-flex align-items-center purchase-popup">
      <div class="row" style="width:100%">
        <div class="col-lg-8 col-md-8 col-sm-12">Update data from Xlsx, Xls, or Csv file ? </div>
        <div class="col-lg-4 col-md-4 col-sm-12" id="content-btn">
          <button style="width:90%" type="button"  class="btn btn-gradient-warning float-right" data-toggle="modal" data-target="#myModal">
            Import Data
          </button>
          {{-- <a style="width:90%"  class="btn btn-gradient-warning float-right" href="{{ URL('/auth/google') }}">Connect Google</a> --}}
        </div>
      </div>      
    </span>
  </div>
</div>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-home"></i>
    </span>
    Dashboard
  </h3>
 
</div>

<div class="row" style="margin: 10px 0">
  <div class="container">    
    <div id="filter-date" style="margin:-35px -40px 0 0 " class="float-right">
      <select id="filter" name="filter" class="form-control select2" style="width: 100%;">
        <option value="{{ Date('Y-m-d') }}">This Day</option>
        <option value="{{ Date('m') }}">This Month</option>
        <option value="all">All</option>
      </select>
    </div>

  </div>
</div>

<div class="row">
  <div class="col-md-12 stretch-card grid-margin">
    <div class="card bg-gradient-primary card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('public/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
        <h4 class="font-weight-normal mb-3">Mobil ganjil
            <i class="mdi mdi-chart-line mdi-24px float-right"></i>
        </h4>

        @if(count($table) == null)
          <p colspan="4">Data Masih kosong !</p>
        @else
          <div class="table-responsive">
            <table class="table table-stripped">
              <thead>
                <tr>
                  <th>Mobil (Pemilik)</th>
                  <th>Plat Nomor</th>
                  <th>Masuk</th>
                  <th>Keluar</th>
                </tr>
              </thead>
              <tbody>
                @foreach($table as $log)
                  <tr>
                    <td>{{$log->cars->car_type}} <label class="badge badge-outline-dark">{{$log->owners->owner_name}} </label> </td>
                    <td>{{$log->cars->car_plat_number}} </td>
                    <td><label class="badge badge-success">{{$log->count_in}} </label></td>
                    <td><label class="badge badge-danger">{{$log->count_out}} </label></td>
                  </tr>
                @endforeach               
              </tbody>
            </table>
          </div>
        @endif 
        
        <div class="row" style="margin-top:20px">
            <div class=" col-md-6 col-sm-12">
              <h6 id="badge-IN" class="card-text">{{ Date('Y-m-d') }}</h6>
            </div>
            <div class="col-md-6 col-sm-12">
              <a href="{{ route('rekap.index') }}" class="float-right btn btn-sm btn-inverse-dark">More >>></a>        
            </div> 
          </div>
      </div>
    </div>
  </div>

</div>

<div class="row">
  <div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('public/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
        <h4 class="font-weight-normal mb-3">Mobil Masuk
            <i class="mdi mdi-chart-line mdi-24px float-right"></i>
        </h4>
        
        <h2 style="font-size:300%" class="mb-5" id="val-IN">{{ $countIn }}</h2>
        <h6 id="badge-IN" class="card-text">{{ Date('Y-m-d') }}</h6>
      </div>
    </div>
  </div>
  <div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('public/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
        <h4 class="font-weight-normal mb-3">Mobil Keluar
          <i class="mdi mdi-chart-line mdi-24px float-right"></i>
        </h4>
        <h2 style="font-size:300%"  class="mb-5" id="val-OUT">{{ $countOut }}</h2>
        <h6 id="badge-OUT" class="card-text">{{ Date('Y-m-d') }}</h6>
      </div>
    </div>
  </div>

</div>

<div class="row">
  <div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-danger card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('public/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
        <h4 class="font-weight-normal mb-3">Mobil Sering Masuk
            <i class="mdi mdi-chart-line mdi-24px float-right"></i>
        </h4>
        
        <div class="grid-margin home-table" id="in" style="margin-top : 20px"> 
        @if(count($countCarIn) == 0)
          <div id="content-error-in">
            <p>Hari ini masih kosong !</p>
          </div>
        @else
          @foreach($countCarIn as $car)
          <div class="row" id="content-success-in">
            <div class="col-md-9">
              <h3>{{ $car->cars->car_plat_number }} <label class="badge badge-outline-dark">{{$car->owners->owner_name}}</label></h3>            
            </div>
            <div class="col-md-3">
              <h3 class="btn btn-rounded btn-dark">{{$car->total}}</h3>
            </div>
          </div>
          @endforeach
        @endif
        </div>

        <div class="row">
          <div class=" col-md-6 col-sm-12">
            <h6 id="badge-IN" class="card-text">{{ Date('Y-m-d') }}</h6>
          </div>
          <div class="col-md-6 col-sm-12">
          <a href="{{ url('masuk') }}" class="float-right btn btn-sm btn-inverse-dark">More >>></a>        
          </div> 
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-warning card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('public/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
        <h4 class="font-weight-normal mb-3">Mobil Sering Keluar
          <i class="mdi mdi-chart-line mdi-24px float-right"></i>
        </h4>

        <div class="grid-margin home-table" id="out" style="margin-top : 20px"> 
        @if(count($countCarOut) == 0)
          <div id="content-error-out">
            <p>Hari ini masih kosong !</p>
          </div>
        @else
          @foreach($countCarOut as $car)
          <div class="row " id="content-success-out">
            <div class="col-md-9">
              <h3>{{ $car->cars->car_plat_number }} <label class="badge badge-outline-dark">{{$car->owners->owner_name}}</label></h3>            
            </div>
            <div class="col-md-3">
              <h3 class="btn btn-rounded btn-dark">{{$car->total}}</h3>
            </div>
          </div>
          @endforeach
        @endif
        </div>

        <div class="row">
          <div class=" col-md-6 col-sm-12">
            <h6 id="badge-IN" class="card-text">{{ Date('Y-m-d') }}</h6>
          </div>
          <div class="col-md-6 col-sm-12">
            <a href="{{ url('keluar') }}"  class="float-right btn btn-sm btn-inverse-dark">More >>></a>        
          </div> 
        </div>
      </div>
    </div>
  </div>

</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" action="{{ route('import-csv-excel') }}" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Select File to Import:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{ csrf_field() }}
            <div class="row" style="margin-top: 10px;">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <div class="col-md-12">
                      <input class="form-control" name="sample_file" type="file" id="sample_file">
                    </div>
                </div>
              </div>
            </div>
            <div class="row" style="margin-top: 10px;">
              <div class="col-md-12">
                <p>Keterangan :</p>
                <p style="font-size: 12px;">Column A = <strong>Nama Pemilik</strong></p>
                <p style="font-size: 12px;">Column B = <strong>Alamat Pemilik</strong></p>
                <p style="font-size: 12px;">Column C = <strong>Nomor KTP Pemilik</strong></p>
                <p style="font-size: 12px;">Column D = <strong>Nomor Plat Mobil</strong></p>
                <p style="font-size: 12px;">Column E = <strong>Jenis Mobil</strong></p>
                <p style="font-size: 12px;">Column F = <strong>Nomor Rangka Mobil</strong></p>
                <p style="font-size: 12px;">Column G = <strong>Nomor Mesin Mobil</strong></p>
                <p style="font-size: 12px;">Column H = <strong>Rute Mobil</strong></p>
                <p>Download <a href="{{ asset('public/Book1.xlsx') }}">Sample File</a></p>
              </div>
            </div>
          </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
        </form>
      </div>
    </div>
  </div>

<meta name="_token" content="{!! csrf_token() !!}" />

@endsection

@section('custom_js')

{{-- <script src="https://apis.google.com/js/api.js"></script>
<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/1.0.0/dist/progressbar.js"></script>
<script>
  /**
   * Sample JavaScript code for sheets.spreadsheets.get
   * See instructions for running APIs Explorer code samples locally:
   * https://developers.google.com/explorer-help/guides/code_samples#javascript
   */

  function authenticate() {
    return gapi.auth2.getAuthInstance()
        .signIn({scope: "https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive.readonly https://www.googleapis.com/auth/spreadsheets https://www.googleapis.com/auth/spreadsheets.readonly"})
        .then(function() { alert("Sign-in successful"); },
              function(err) { alert("Error signing in", err); });
  }
  function loadClient() {
    return gapi.client.load("https://content.googleapis.com/discovery/v1/apis/sheets/v4/rest")
        .then(function() { console.log("GAPI client loaded for API"); },
              function(err) { console.error("Error loading GAPI client for API", err); });
  }
  // Make sure the client is loaded and sign-in is complete before calling this method.
  function execute() {
    return gapi.client.sheets.spreadsheets.get({
      "spreadsheetId": "1fElYACfo-DVt7jVu6sMOxrihA8PQBjlHHAhRsnlEiow",
      "includeGridData": "true"
    })
        .then(function(response) {
          // Handle the results here (response.result has the parsed body).
          console.log("Response", response.result.sheets);
          var message = ''; 
          $.each( response.result.sheets, function( key, value ) {

            $.each( value.data, function( key, value ) {

              $.each( value.rowData, function( key, value ) {
                var arrVal = [];
                var arrHeader = [];
                var arrContent = [];
                $.each( value.values, function( key, value ) {
                  var valData = Object.values(value.userEnteredValue);
                  var keyData = Object.keys(value.userEnteredValue);

                  arrVal.push(valData);

                });

                if (key == 0) {
                  arrHeader = arrVal.slice();
                }
                else{
                  arrContent = arrVal.slice();
                }                                

                $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });                

                $.ajax({
                  dataType : 'json',
                  type : 'POST',
                  url : '{{ route("sync") }}',
                  data: {req: arrContent},
                  success : function(data) {
                    console.log(data);
                    message = data;
                  }
                });

              });

            });

          });
          var bar = new ProgressBar.Line(container, {
            strokeWidth: 4,
            easing: 'easeInOut',
            duration: 1400,
            color: '#FFEA82',
            trailColor: '#eee',
            trailWidth: 1,
            svgStyle: {width: '100%', height: '100%'}
          });

          bar.animate(1.0);
        },
        function(err) { error("Execute error", err); });
  }
  gapi.load("client:auth2", function() {
    gapi.auth2.init({client_id: '947034058258-vmnu0gincqtsnp004mha0uqb4g7hbjnj.apps.googleusercontent.com'});
  });
</script> --}}

<script>
  var host = window.location.hostname;
  var path = window.location.pathname;
  $(document).ready(function(){
    
    $( "#filter-date #filter" ).change(function() {
      var str = $("#filter option:selected").val();
      var URL = 'http://'+host+path+'/count/'+str;
      console.log(URL);
      
      $.ajax({
        dataType : 'json',
        type : 'GET',
        url : URL,
        success : function(data) { 
          $('#val-IN').text(data.countIn);
          $('#val-OUT').text(data.countOut);
          $('.card-text').text(data.label);
          $('.card-text').text(data.label);

          var htmlStrIn   = '';
          var htmlStrOut  = '';
          if (data.countCarIn.length != 0) {
            $('.home-table #content-error-in').remove(); 
            $('.home-table #content-success-in').remove();

            $.each(data.countCarIn, function(index, item){
              console.log(item);
              htmlStrIn += '<div class="row " id="content-success-in">';
              htmlStrIn += '  <div class="col-md-9">';
              htmlStrIn += '    <h3>'+item.cars.car_plat_number+' <label class="badge badge-outline-dark">'+item.owners.owner_name+'</label></h3>';            
              htmlStrIn += '  </div>';
              htmlStrIn += '  <div class="col-md-3">';
              htmlStrIn += '    <h3 class="btn btn-rounded btn-dark">'+item.total+'</h3>';
              htmlStrIn += '  </div>';
              htmlStrIn += '</div>';
            });

          } else {
            $('.home-table #content-success-in').remove();
            $('.home-table #content-error-in').remove(); 

            htmlStrIn += '<div id="content-error-in">';
            htmlStrIn += '  <p>Hari ini masih kosong !</p>';
            htmlStrIn += '</div>';  
          }

          if (data.countCarOut.length != 0) {
            $('.home-table #content-error-out').remove(); 
            $('.home-table #content-success-out').remove();

            $.each(data.countCarOut, function(index, item){
              htmlStrOut += '<div class="row " id="content-success-out">';
              htmlStrOut += '  <div class="col-md-9">';
              htmlStrOut += '    <h3>'+item.cars.car_plat_number+' <label class="badge badge-outline-dark">'+item.owners.owner_name+'</label></h3>';            
              htmlStrOut += '  </div>';
              htmlStrOut += '  <div class="col-md-3">';
              htmlStrOut += '    <h3 class="btn btn-rounded btn-dark">'+item.total+'</h3>';
              htmlStrOut += '  </div>';
              htmlStrOut += '</div>';
            });

          } else {
            $('.home-table #content-error-out').remove(); 
            $('.home-table #content-success-out').remove();

            htmlStrOut += '<div id="content-error-out">';
            htmlStrOut += '  <p>Hari ini masih kosong !</p>';
            htmlStrOut += '</div>';  
          }

          $('.home-table#in').append(htmlStrIn);
          $('.home-table#out').append(htmlStrOut);
        }
      });
    
    });
  });
</script>

@endsection
