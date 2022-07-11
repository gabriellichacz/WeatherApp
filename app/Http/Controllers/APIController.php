<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\City;

class APIController extends HomeController
{
    public function __invoke()
    {
        $CitiesIDsALL = DB::table('cities') -> pluck('CityID');
        $CitiesNamesALL = DB::table('cities') -> pluck('name');
        date_default_timezone_set('Europe/Warsaw'); // timezone for saving created_at

        // Checking if table in database is empty
        if($CitiesIDsALL -> isEmpty()) 
        {
            return 0;
        } 
        else 
        {
            // Inserting current data to database for all cities
            for ($LoopCityIndex = 0; $LoopCityIndex <= count($CitiesIDsALL)-1; $LoopCityIndex++) {
                
                $API_Key = 'f7df02ae6a92e103bdc3996cbf4099a5';
                $city_id = $CitiesIDsALL[$LoopCityIndex];
                $city_name = $CitiesNamesALL[$LoopCityIndex];
                $units = 'metric';

                // Calling API
                $apiData = @file_get_contents('https://api.openweathermap.org/data/2.5/weather?id='.$city_id.'&appid='.$API_Key.'&units='.$units.'');
                if($apiData) {
                    $data = json_decode($apiData); 
                } else { // if data is not found
                    echo 'Invalid API key or invalid city ID.'; 
                }
            
                // Extracting data - static
                $data_weather = [];
                $data_weather[0] = $city_name;
                $data_weather[1] = $data->main->temp;
                $data_weather[1] = round($data_weather[1], 0, PHP_ROUND_HALF_UP); // Rounding temperature
                $data_weather[2] = $data->main->humidity;
                $data_weather[3] = $city_id;

                DB::table('weather') -> insert([ // Inserting
                    'CityID' => $data_weather[3],
                    'Temp' => $data_weather[1],
                    'Humidity' => $data_weather[2],
                    'created_at' => date('Y/m/d H:i:s'),
                ]);
            }
        }
    }
}