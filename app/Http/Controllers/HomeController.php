<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Weather;
use App\Models\City;

class HomeController extends Controller
{
    // Authentication required
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Calling OpenWeather API
    public function api($CitiesIDs, $CitiesNames, $j) // j - index for chosing city
    {
        $API_Key = 'f7df02ae6a92e103bdc3996cbf4099a5';
        $city_id = $CitiesIDs[$j];
        $city_name = $CitiesNames[$j];
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
        $data_weather[0] = $data->name;
        $data_weather[1] = $data->main->temp;
        $data_weather[1] = round($data_weather[1], 0, PHP_ROUND_HALF_UP); // Rounding temperature
        $data_weather[2] = $data->main->humidity;
        $data_weather[3] = $data->id;

        return($data_weather);
    }

    // Home view with weather dashboard
    public function index()
    {
        $max_values_selected = 3;

        // Reading from json
        $datafile_json = file_get_contents("json_data/city.list.json");
        $data_json = json_decode($datafile_json, true);

        // Filtering json (we want only ["country"] == 'PL')
        $filtered_data = [];
        for($i = 0; $i < count($data_json); $i++){
            $item = $data_json[$i];
            if($item["country"] == 'PL') 
            {
                $filtered_data[$i] = array(
                    "id" => $item["id"],
                    "name" => $item["name"]
                );
            }
        }

        // Reindexing
        $MainDataArrayCities = array_combine(
            range(0, count($filtered_data) + (0-1)), array_values($filtered_data)
        );

        // Splitting data (IDs and CitiesNames)
        $CitiesIDs = [];
        $CitiesNames = [];
        for($i = 0; $i < count($MainDataArrayCities); $i++){
            $CitiesIDs[$i] = $MainDataArrayCities[$i]['id'];
            $CitiesNames[$i] = $MainDataArrayCities[$i]['name'];
        }

        // Checking if table in database is empty
        if(empty($CitiesNames)) 
        {
            return view('home', [
                'data_array' => 0,
                'max_values_selected' => 0,
            ]);
        } 
        else 
        {
            // 'Followed' cities
            $chosenCitiesIDs = DB::table('cities') -> pluck('CityID');
            $chosenCitiesNames = DB::table('cities') -> pluck('name');
            
            // Putting data from api call to array
            $data_array = array();
            for ($i = 0; $i <= $max_values_selected-1; $i++) {
                $data_array[$i] = $this -> api($chosenCitiesIDs, $chosenCitiesNames, $i); // calling function 'api'
            }

            return view('home', [
                'data_array' => $data_array,
                'max_values_selected' => $max_values_selected,
                'Cities' => $CitiesNames,
                'CitiesIDs' => $CitiesIDs
            ]);
        }
    }

    // Storing "followed" cities in database (data from form CitySelector)
    public function store(Request $request)
    {
        // How many "followed" cities we want
        $max_values_selected = 3;

        // Putting values from CitySelector[] form to selectValues array and separating IDs and Names
        $selectValues = [];
        $result_array = [];
        for ($i = 0; $i <= $max_values_selected-1; $i++) {
            $selectValues[$i] = request() -> CitySelector[$i];
            $result_array[$i] = explode('|', $selectValues[$i]);
        }

        // Truncating tables
        City::truncate();
        Weather::truncate();

        // Inserting new chosen cities
        for ($i = 0; $i <= $max_values_selected-1; $i++) {
            $city = City::create([
                'CityID' => $result_array[$i][0],
                'Name' => $result_array[$i][1],
                'Chosen' => '0',
            ]);
            $city -> save();
        }

        return redirect('home');
    }
}