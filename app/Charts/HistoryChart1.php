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
    
    public function data_for_chart_hum()
    {
        // All needed cities's IDs
        $cities = DB::table('cities') -> where('Chosen', 1) -> pluck('CityID');

        for($n = 0; $n <= count($cities)-1; $n++){
            // All data
            $dataa = Weather::select('id', 'Humidity') -> where('CityID', $cities[$n]) -> get() -> toArray();

            // Structuring data set for chartJS
            $structuredData[$n] = array_map(function($item){
                return ['x' => $item['id'], 'y' => $item['Humidity']];
            }, $dataa);
        }

        return($structuredData);
    }

    public function handler(Request $request): Chartisan
    {
        $data_hum = $this -> data_for_chart_hum();
        
        return Chartisan::build()
            ->dataset('Wilgotność1', $data_hum[0])
            ->dataset('Wilgotność2', $data_hum[1])
            ->dataset('Wilgotność3', $data_hum[2]);
    }
}