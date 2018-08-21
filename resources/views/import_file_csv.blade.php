<html lang="en">
<head>
    <title>Import</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
</head>
<body>
    <div class="panel panel-primary">
 <div class="panel-heading">Import CSV File</div>
  <div class="panel-body">     
        <form method="POST" action="{{ route('import-csv-excel') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row" style="margin-top: 10px;">
		   <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label for="sample_file" class="col-md-3">Select File to Import:</label>
                    <div class="col-md-9">
                    <input class="form-control" name="sample_file" type="file" id="sample_file">
                    
                    </div>
                </div>
            </div>
           
            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 10px;">
			<input class="btn btn-primary" type="submit" value="Upload">
			</div>
        </div>
		</form>
 </div>
</div>
</body>
</html>