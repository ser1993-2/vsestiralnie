<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StatValues extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'stat_values';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    public static function getDateLastMounthByStatsId($id)
    {
        return StatValues::where('stat_id', $id)
            ->whereDate('created_at', '>=' , Carbon::today()->subDays(30))
            ->orderBy('created_at')
            ->limit(30)
            ->pluck('created_at');
    }

    public static function getValueLastMounthByStatsId($id)
    {
        return StatValues::where('stat_id', $id)
            ->whereDate('created_at', '>=' , Carbon::today()->subDays(30))
            ->orderBy('created_at')
            ->limit(30)
            ->pluck('value');
    }

    public static function convertDate($dates)
    {
        foreach ($dates as $key=>$date) {
            $date = Carbon::parse($date);
            $dates[$key] = $date->format('M d Y');
        }

        return $dates;
    }

    public static function storeValue($statId,$value)
    {
        StatValues::insert([
            'stat_id' => $statId,
            'value' => $value,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
