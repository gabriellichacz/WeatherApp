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

    public function data_for_chart()
    {
        // All needed cities's IDs
        $cities = DB::table('cities') -> where('Chosen', 1) -> pluck('CityID');

        // All data
        $dataa = Weather::select('id', 'Temp') -> where('CityID', $cities[0]) -> get() -> toArray();

        // Structuring data set
        $structuredData = array_map(function($item){
            return ['x' => $item['id'], 'y' => $item['Temp']];
        }, $dataa);

        return($structuredData);
    }

    public function handler(Request $request): Chartisan
    {
        $data_all = $this -> data_for_chart();
        
        return Chartisan::build()
            ->dataset('Temperatura', $data_all);
    }
}
//$data[0][1], $data[0][2]