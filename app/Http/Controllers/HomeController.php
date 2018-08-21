<?php

namespace App\Http\Controllers;

use App\Owner;
use App\Car;
use App\Log;
use App\Barcode;
use DB;
use App\Exports\LogExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\carbon;
use Vsmoraes\Pdf\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class HomeController extends Controller
{
    private $pdf;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Pdf $pdf)
    {
        $this->middleware('auth');
        $this->pdf = $pdf;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logsIN = Log::where('status', 'IN')->where(DB::raw('DATE(created_at)'), '=', Carbon::now()->format('Y-m-d'))->count();
        $logsOUT = Log::where('status', 'OUT')->where(DB::raw('DATE(created_at)'), '=', Carbon::now()->format('Y-m-d'))->count();

        $logsCarIN = Log::select(DB::raw('COUNT(car_id) as total'), 'car_id', 'owner_id')
                        ->where('status', 'IN')
                        ->where(DB::raw('DATE(created_at)'), '=', Carbon::now()->format('Y-m-d'))
                        ->groupBy('car_id', 'owner_id')
                        ->with('cars', 'owners')
                        ->limit(3)
                        ->get();

        $logsCarOUT = Log::select(DB::raw('COUNT(car_id) as total'), 'car_id', 'owner_id')
                        ->where('status', 'OUT')
                        ->where(DB::raw('DATE(created_at)'), '=', Carbon::now()->format('Y-m-d'))
                        ->groupBy('car_id', 'owner_id')
                        ->with('cars', 'owners')
                        ->limit(3)
                        ->get();
        
        
        
        $log = Log::select(DB::raw('GROUP_CONCAT(status) as status'), 'car_id', 'owner_id')->where(DB::raw('DATE(created_at)'), '=', Carbon::now()->format('Y-m-d'))->groupBy('car_id', 'owner_id')->with('cars', 'owners')->limit(3)->get();
    
        foreach ($log as $item) {
            $IN = 0;
            $OUT = 0;
            if ($item->status) {
                $arr = explode(',', $item->status);

                for ($i=0; $i < count($arr); $i++) { 
                    if ($arr[$i] == "IN") {
                        $IN++;
                    }
                    else{
                        $OUT++;
                    }
                }
                $item['count_in'] = $IN;
                $item['count_out'] = $OUT;
            }
        }

        $arr = collect($log);
        foreach($log as $item){
            if ($item->count_in == $item->count_out) {
                $arr->pop();
            }
        }

        return view('home', [
            'countIn' => $logsIN,
            'countOut' => $logsOUT,
            'countCarIn' => $logsCarIN,
            'countCarOut' => $logsCarOUT,
            'table' => $arr,
        ]);
    }

    public function sync(Request $request)
    {
        $output = is_array($request->req); 
        //return response()->json($output);
        if($output == true){

            $exist = $this->checkOwnerExist($request->req[2]);

            // $avatarVal = $request->req[2];
            // $imageVal = implode('', $request->req[5]);

            if ($exist == null) {

                $existCar = $this->checkCarExist($request->req[3]);
                if ($existCar == null) {
                    $owners = new Owner();
                    //$owners->owner_avatar = $this->explodeImage($avatarVal);
                    $owners->owner_name = $request->req[0];
                    $owners->owner_address = $request->req[1];
                    $owners->owner_identity_number = $request->req[2];
                    $owners->save();

                    $cars = $owners->cars()->create([
                        'car_plat_number' => $request->req[3],
                        //'car_image' => $this->explodeImage($imageVal),
                        'car_type' => $request->req[4],
                        'car_frame_number' => $request->req[5],
                        'car_machine_number' => $request->req[6],
                        'car_rute' => $request->req[7],
                        'owner_id' => $owners->id,
                    ]);
                    
                    return response()->json([
                            'status' => 1,
                            'message' => 'Update Succesfully !'
                        ]);
                }
                
            }    
            else{
                return response()->json([
                        'status' => 0,
                        'message' => 'Database is already update!'
                    ]);
            }     

        }
        
    }

    public function checkOwnerExist($number)
    {
        return Owner::where(['owner_identity_number' => $number])->first();
    }

    public function checkCarExist($number)
    {
        return Car::where(['car_plat_number' => $number])->first();
    }

    public function explodeImage($arr)
    {
        return explode('"', $arr)[1];
    }

    public function filterByDate($date)
    {
        if($date == Date('Y-m-d')){
            $field = DB::raw('DATE(created_at)');
            $label = date('Y-m-d');
        }
        elseif ($date == Date('m')) {
            $field = DB::raw('MONTH(created_at)');
            $label = date('F');
        }
        else{
            $field = null;
            $label = "All Date";
        }

        if ($field == null) {
            $logsIN = Log::where('status', 'IN')->count();
            $logsOUT = Log::where('status', 'OUT')->count();
            $logsCarIN = Log::select(DB::raw('COUNT(car_id) as total'), 'car_id', 'owner_id')
                            ->where('status', 'IN')
                            ->groupBy('car_id', 'owner_id')
                            ->with('cars', 'owners')
                            ->limit(3)
                            ->get();

            $logsCarOUT = Log::select(DB::raw('COUNT(car_id) as total'), 'car_id', 'owner_id')
                            ->where('status', 'OUT')
                            ->groupBy('car_id', 'owner_id')
                            ->with('cars', 'owners')
                            ->limit(3)
                            ->get();
        }
        else{
            $logsIN = Log::where('status', 'IN')->where($field, '=', $date)->count();
            $logsOUT = Log::where('status', 'OUT')->where($field, '=', $date)->count();
            $logsCarIN = Log::select(DB::raw('COUNT(car_id) as total'), 'car_id', 'owner_id')
                            ->where('status', 'IN')
                            ->where($field, '=', $date)
                            ->groupBy('car_id', 'owner_id')
                            ->with('cars', 'owners')
                            ->limit(3)
                            ->get();
            
            $logsCarOUT = Log::select(DB::raw('COUNT(car_id) as total'), 'car_id', 'owner_id')
                            ->where('status', 'OUT')
                            ->where($field, '=', $date)
                            ->groupBy('car_id', 'owner_id')
                            ->with('cars', 'owners')
                            ->limit(3)
                            ->get();
        }
        
        return response()->json([
            'countIn' => $logsIN,
            'countOut' => $logsOUT,
            'countCarIn' => $logsCarIN,
            'countCarOut' => $logsCarOUT,
            'label' => $label
        ], 200);
    }

    public function generate()
    {
        $rand = mt_rand(1000000000, mt_getrandmax());

        $barcode = new BarcodeGenerator();
        $barcode->setText((string)$rand);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setScale(2);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $code = $barcode->generate();

        return array('code' => $code, 'number' => $rand);
    }

    public function print()
    {
        for ($i=0; $i < 20 ; $i++) {
            $data = $this->generate(); 
            $code[] = $data['code'];
            $this->saveBarcodeNumber($data['number']);
        }

        $html = view('barcode', ['data' => $code])->render();
    
        return $this->pdf->load($html, 'A4')->filename('barcode.pdf')->download();
    }

    public function saveBarcodeNumber($number)
    {
        Barcode::create([
            'barcode' => $number,
        ]);
    }

    public function rekap()
    {
        $log = Log::select(DB::raw('GROUP_CONCAT(status) as status'), 'car_id', 'owner_id', DB::raw('GROUP_CONCAT(created_at) as tgl'))
                    ->where(DB::raw('DATE(created_at)'), Date('Y-m-d'))
                    ->groupBy('car_id', 'owner_id')
                    ->with('cars', 'owners')
                    ->limit(3)->get();

        $index = 1;
        foreach ($log as $item) {
            $IN = 0;
            $OUT = 0;
            if ($item->status) {
                $arr = explode(',', $item->status);
                $arr2 = explode(',', $item->tgl);
                $tgl = explode('-', $arr2[0]);
                $year = $tgl[0];
                $month = $tgl[1];

                for ($i=0; $i < count($arr); $i++) { 
                    if ($arr[$i] == "IN") {
                        $IN++;
                    }
                    else{
                        $OUT++;
                    }
                }
                $item['count_in'] = $IN;
                $item['count_out'] = $OUT;
                $item['indeks'] = '000' .$index. '/' .$month. '/' .$year;
                $index++;
            }
        }

        return view('rekap', ['data' => $log]);
    }

    public function report($start, $end)
    {
        $log = Log::filterByDateBetween($start, $end);
        $log = $this->makeNewArrayLog($log);

        return response()->json(['log' => $log]);
    }

    public function export($start, $end)
    {
        $log = Log::filterByDateBetween($start, $end);
        $data = $this->makeNewArrayLog($log);

        if (count($data) == 0) {
            return redirect()->route('rekap.index')->with('alert-danger','Sorry, Anda tidak dapat melakukan Export data dikarenakan data masih kosong !');
        }  
        else{
            return Excel::download(new LogExport($data), 'Rekap Data.xlsx');      
        }

    }

    public function makeNewArrayLog($collection)
    {
        $index = 1;
        foreach ($collection as $item) {
            $IN = 0;
            $OUT = 0;
            if ($item->status) {
                $arr = explode(',', $item->status);
                $arr2 = explode(',', $item->tgl);
                $tgl = explode('-', $arr2[0]);
                $year = $tgl[0];
                $month = $tgl[1];

                for ($i=0; $i < count($arr); $i++) { 
                    if ($arr[$i] == "IN") {
                        $IN++;
                    }
                    else{
                        $OUT++;
                    }
                }
                $item['count_in'] = $IN;
                $item['count_out'] = $OUT;
                $item['indeks'] = '000' .$index. '/' .$month. '/' .$year;
                $index++;
            }
        }

        return $collection;
    }

    public function importExportExcelORCSV()
    {
        return view('import_file_csv');
    }
    public function importFileIntoDB(Request $request)
    {
        $request->validate([
            // 'sample_file' => 'mimes:xls,xlsx,csv,',
        ]);
        
        if($request->hasFile('sample_file')){           

            $path = $request->file('sample_file')->getRealPath();
            $extfile = $request->file('sample_file')->getClientOriginalExtension();

            switch ($extfile) {
                case 'csv':
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                    break;
                case 'xlsx':
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    break;
                case 'xls':
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                    break;
                default:
                    return redirect()->back()->with('alert-danger', 'Sorry, using type file xls, xlsx, and csv to import data !');
                    break;
            }

            $spreadsheet = $reader->load($path);
            $worksheet = $spreadsheet->getActiveSheet();

            $dataKeys = collect(['owner_name', 'owner_address', 'owner_identity_number', 'car_plat_number', 'car_type', 'car_frame_number', 'car_machine_number', 'car_rute']);
            $data = collect([]);

            // Looping data from sheet xls data
            foreach ($worksheet->getRowIterator() as $row) {
                $dataValues = collect([]);

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE);

                // Looping row data xls
                foreach ($cellIterator as $cell) {
                    // dump($cell->getValue());
                    $dataValues->push($cell->getValue()); // Save value data to collection 
                }
                $data->push($dataKeys->combine($dataValues)); // combine key and value to be one collection and push to new collection
            }

            $temp = collect([]);
            if($data->count()){

                // Looping collection data
                foreach ($data as $key => $value) {
                    $ownerID = $value['owner_identity_number'];
                    $carID = $value['car_plat_number'];
                    $existOwner = $this->checkOwnerExist(intval($ownerID)); // Check Owner Data in database
                    $existCar = $this->checkCarExist($carID); // Check Car Data in database
                    $array = collect([]);

                    if ($existOwner == null) { 
                        // Save New Owner to new Collection
                        $array->push($value['owner_name']);
                        $array->push($value['owner_address']);
                        $array->push($value['owner_identity_number']);

                        if ($existCar == null) {
                            // Save New Car to new Collection
                            $array->push($value['car_plat_number']);
                            $array->push($value['car_type']);
                            $array->push($value['car_frame_number']);
                            $array->push($value['car_machine_number']);
                            $array->push($value['car_rute']);
                        }
                        $temp->push($dataKeys->combine($array)); // combine key and value to be one collection and push to new collection
                    }    
                }

                if ($temp->count() != 0) { // Check new data
                    // Insert Data
                    foreach ($temp as $key => $value) {
                        $owners = new Owner();
                        $owners->owner_name = $value['owner_name'];
                        $owners->owner_address = $value['owner_address'];
                        $owners->owner_identity_number = $value['owner_identity_number'];
                        $owners->save();
    
                        $cars = $owners->cars()->create([
                            'car_plat_number' => $value['car_plat_number'],
                            'car_type' => $value['car_type'],
                            'car_frame_number' => $value['car_frame_number'],
                            'car_machine_number' => $value['car_machine_number'],
                            'car_rute' => $value['car_rute'],
                            'owner_id' => $owners->id,
                        ]);
                    }      
                    
                    return redirect()->back()->with('alert-success', 'Update Succesfully !');


                } else { 
                    // empty new data
                    return redirect()->back()->with('alert-success', 'Database is already update !');

                }
                
            }
        }

        return redirect()->back()->with('alert-danger', 'Request data does not have any files to import !');
        // echo "<script type='text/javascript'>alert('Request data does not have any files to import !')</script>";
    } 
}
