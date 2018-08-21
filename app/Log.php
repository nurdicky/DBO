<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Log extends Model
{
    protected $fillable = [
        'car_id',
        'owner_id',
        'driver_id',
        'status',
    ];

    public static function filterByDateBetween($start, $end){
        return Log::select(DB::raw('GROUP_CONCAT(status) as status'), 'car_id', 'owner_id', DB::raw('GROUP_CONCAT(created_at) as tgl'))
                    ->where(DB::raw('DATE(created_at)'), ">=", $start)
                    ->where(DB::raw('DATE(created_at)'), "<=", $end)
                    ->groupBy('car_id', 'owner_id')
                    ->with('cars', 'owners')
                    ->get();
    }

    public function cars()
    {
        return $this->belongsTo('App\Car', 'car_id');
    }

    public function owners()
    {
        return $this->belongsTo('App\Owner', 'owner_id');
    }

    public function drivers()
    {
        return $this->belongsTo('App\Driver', 'driver_id');
    }
}
