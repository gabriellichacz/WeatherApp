<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Weather;

class HistoryChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public function data_for_chart_temp()
    {
        // All needed cities's IDs
        $cities = DB::table('cities') -> pluck('CityID');

        for($n = 0; $n <= count($cities)-1; $n++){
            // All data
            $dataa = Weather::select('id', 'Temp') -> where('CityID', $cities[$n]) -> get() -> toArray();

            // Structuring data set for chartJS
            $structuredData[$n] = array_map(function($item){
                return ['x' => $item['id'], 'y' => $item['Temp']];
            }, $dataa);
        }

        return($structuredData);
    }

    public function handler(Request $request): Chartisan
    {
        $citiesNames = DB::table('cities') -> pluck('name');
        $data_temp = $this -> data_for_chart_temp();
        
        return Chartisan::build()
            ->dataset($citiesNames[0], $data_temp[0])
            ->dataset($citiesNames[1], $data_temp[1])
            ->dataset($citiesNames[2], $data_temp[2]);
    }
}