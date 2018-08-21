<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Barcode</title>
    <style>
        .float-left{
            margin-left: 15%;
            margin-bottom: 100px;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <div class="row">
            @foreach($data as $key => $value)
                <div class="float-left">
                    <img src="data:image/png;base64,{{$value}}"/>
                </div>
            @endforeach
        </div>
    </div> 

</body>
</html>