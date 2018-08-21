@extends('layouts.master')

@section('title', 'Update Database')

@section('custom_css')
  <link rel="stylesheet" href="{{ asset('public/assets/css/custom.css')}}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css">
@endsection

<?php $data = json_encode($rows); ?>
<?php $field = json_encode($headers); ?>

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
        <button id="btn-update" type="button" class="btn btn-gradient-primary">Update</button>      
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
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($rows as $row)
                    <tr>
                    <?php $i=0;  ?>
                        @foreach($row as $value)

                            <td>{{ $value }} </td>

                        <?php $i++; ?>
                        @endforeach
                    </tr>
                @endforeach 
            </tbody>
        </table>

      </div>
      <div class="card-footer">
        {{-- <p><strong>Keterangan </strong> : Untuk kolom berupa image, anda harus mengupload image secara manual !</p> --}}
      </div>
    </div>
  </div>
</div>

<meta name="_token" content="{!! csrf_token() !!}" />

@endsection

@section('custom_js')
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    } );
    var arr  = <?php echo($data); ?>;
    var arrFields  = <?php echo($field); ?>;   

    if (jQuery.inArray( 'Alamat', arrFields, 1 ) == -1) {
      $("#btn-update").attr('disabled');
      alert("Sorry, format kolom spreadsheet anda tidak sesuai !");
      window.location.href = "{{ route('home') }}";
    }

    var tempArr = [];

    $('#btn-update').click(function (){
      $.each(arr, function( key, value ) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });                

        $.ajax({
          dataType : 'json',
          type : 'POST',
          url : '{{ route("sync") }}',
          data: {req: value},
          success : function(data) {
            // console.log(data);
            if (data.status != null) {
              tempArr.push(data.status)
            }
            var last = Object.keys(arr).length;

            if(key == last){
              console.log(tempArr);
              
              if (jQuery.inArray( 1, tempArr ) != -1) {
                alert("Update Succesfully !");
                window.location.href = "{{ route('home') }}";
              }
              else if(jQuery.inArray( 0, tempArr ) != -1){
                alert("Database is already update!");
                window.location.href = "{{ route('home') }}";
              }
     
            }
            
          }
        });
        
      });
      


    });





    
    
  </script>
@endsection

