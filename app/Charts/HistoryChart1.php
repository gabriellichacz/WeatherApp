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
        // Id of needed City (taken from route)
        $id = request() -> id;

        // Getting data from database
        $cityIDchart = DB::table('cities') -> where('cityID', $id) -> pluck('CityID');
        $cityIDname = DB::table('cities') -> where('cityID', $id) -> pluck('name');
        $dataa = Weather::select('id', 'Humidity') -> where('CityID', $cityIDchart) -> get() -> toArray(); // main data

        // Structuring data to correct array format
        $structuredData = array_map(function($item){
            return ['x' => $item['id'], 'y' => $item['Humidity']];
        }, $dataa);

        // Labels
        $DataLabels = DB::table('weather') -> where('CityID', $cityIDchart) -> pluck('created_at') -> toArray();

        return Chartisan::build()
            ->labels($DataLabels)
            ->dataset($cityIDname[0], $structuredData);
    }
}