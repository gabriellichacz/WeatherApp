<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Weather;

class HistoryChart1 extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    
    public function handler(Request $request): Chartisan
    {
        $id = request() -> id;
        $cityIDchart = DB::table('cities') -> where('cityID', $id) -> pluck('CityID');
        $cityIDname = DB::table('cities') -> where('cityID', $id) -> pluck('name');
        $dataa = Weather::select('id', 'Humidity') -> where('CityID', $cityIDchart) -> get() -> toArray();

        $structuredData = array_map(function($item){
            return ['x' => $item['id'], 'y' => $item['Humidity']];
        }, $dataa);

        return Chartisan::build()
            ->dataset($cityIDname[0], $structuredData);
    }
}