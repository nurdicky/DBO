@extends('layouts.master')

@section('title', 'Dashboard')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css')}}">
@endsection

@section('content')

<div class="row">
  <div class="col-12">
    <span class="d-flex align-items-center purchase-popup">
      <p>Update data from Google Spreadsheet ? </p>
      <button class="btn ml-auto download-button" onclick="authenticate().then(loadClient)">Connect Google</button>
      <button class="btn btn-gradient-warning" onclick="execute()">Update</button>
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
  <nav aria-label="breadcrumb">
    <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span></span>Overview
        <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul>
  </nav>
</div>
<div class="row">
  <div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-success card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
        <h4 class="font-weight-normal mb-3">Mobil Masuk
          <i class="mdi mdi-chart-line mdi-24px float-right"></i>
        </h4>
        <h2 class="mb-5">1800</h2>
      </div>
    </div>
  </div>
  <div class="col-md-6 stretch-card grid-margin">
    <div class="card bg-gradient-info card-img-holder text-white">
      <div class="card-body">
        <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
        <h4 class="font-weight-normal mb-3">Mobil Keluar
          <i class="mdi mdi-chart-line mdi-24px float-right"></i>
        </h4>
        <h2 class="mb-5">1700</h2>
      </div>
    </div>
  </div>

</div>
<meta name="_token" content="{!! csrf_token() !!}" />

@endsection

@section('custom_js')

<script src="https://apis.google.com/js/api.js"></script>
<script>
  /**
   * Sample JavaScript code for sheets.spreadsheets.get
   * See instructions for running APIs Explorer code samples locally:
   * https://developers.google.com/explorer-help/guides/code_samples#javascript
   */

  function authenticate() {
    return gapi.auth2.getAuthInstance()
        .signIn({scope: "https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive.readonly https://www.googleapis.com/auth/spreadsheets https://www.googleapis.com/auth/spreadsheets.readonly"})
        .then(function() { console.log("Sign-in successful"); },
              function(err) { console.error("Error signing in", err); });
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
                  
                  }
                });

              });

            });

          });


        },
        function(err) { console.error("Execute error", err); });
  }
  gapi.load("client:auth2", function() {
    gapi.auth2.init({client_id: '366122955748-mcivttkmbmghhhqrppn4bh74ipm5a70l.apps.googleusercontent.com'});
  });
</script>

@endsection
