<?php

declare(strict_types = 1);

namespace App\Charts;

use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */

    public function data_for_chart()
    {
        // All needed cities's IDs
        $cities = DB::table('cities') -> where('Chosen', 1) -> pluck('CityID');

        // Data
        $data_big = array();
        for($n = 0; $n <= count($cities)-1; $n++){
            $data_big[$n][0] = DB::table('weather') -> where('CityID', $cities[$n]) -> pluck('CityID');
            $data_big[$n][1] = DB::table('weather') -> where('CityID', $cities[$n]) -> pluck('created_at');
            $data_big[$n][2] = DB::table('weather') -> where('CityID', $cities[$n]) -> pluck('Temp');
            $data_big[$n][3] = DB::table('weather') -> where('CityID', $cities[$n]) -> pluck('Humidity');
        }

        return($data_big);
    }

    public function handler(Request $request): Chartisan
    {
        $data = $this -> data_for_chart(); // calling function 'data_for_chart'
        $labels1 = $data[0][1];

        return Chartisan::build()
            ->labels([$labels1
            ])
            ->dataset('Sample', [$data[0][1], $data[0][2]]);
    }
}