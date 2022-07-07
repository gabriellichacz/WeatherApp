<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
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
        $data_weather[0] = $city_name;
        $data_weather[1] = $data->main->temp;
        $data_weather[1] = round($data_weather[1], 0, PHP_ROUND_HALF_UP); // Rounding temperature
        $data_weather[2] = $data->main->humidity;
        $data_weather[3] = $city_id;

        return($data_weather);
    }

    public function HistoryAPI()
    {
        $CitiesIDsALL = DB::table('cities') -> pluck('CityID'); // Getting all cities' IDs
        $CitiesNamesALL = DB::table('cities') -> pluck('CityID'); // Getting all cities' IDs
        date_default_timezone_set('Europe/Warsaw'); // timezone for saving created_at

        // Checking if table in database is empty
        if($CitiesIDsALL -> isEmpty()) {
            return 0;
        } else {
            // Inserting current data to database for all cities
            for ($LoopCityIndex = 0; $LoopCityIndex <= count($CitiesIDsALL)-1; $LoopCityIndex++) {
                $data = $this -> api($CitiesIDsALL, $CitiesNamesALL, $LoopCityIndex); // Calling function 'api'
                DB::table('weather') -> insert([ // Inserting
                    'CityID' => $data[3],
                    'Temp' => $data[1],
                    'Humidity' => $data[2],
                    'created_at' => date('Y/m/d H:i:s'),
                ]);
            }
        }
    }

    // Home view with weather dashboard
    public function index()
    {
        // Data
        $CitiesIDs = DB::table('cities') -> where('Chosen', '1') -> pluck('CityID'); // Getting chosen cities
        $CitiesNames = DB::table('cities') -> where('Chosen', '1') -> pluck('Name');
        $max_values_selected = 3;

        // Checking if table in database is empty
        if($CitiesNames -> isEmpty()) {
            return view('home', [
                'data_array' => 0,
                'max_values_selected' => 0,
            ]);
        } else {
            // Putting data from api call to array
            $data_array = array();
            for ($i = 0; $i <= $max_values_selected-1; $i++) {
                $data_array[$i] = $this -> api($CitiesIDs, $CitiesNames, $i); // calling function 'api'
            }

            $this -> HistoryAPI(); // calling function 'HistoryAPI'

            return view('home', [
                'data_array' => $data_array,
                'max_values_selected' => $max_values_selected,
            ]);
        }
    }

    // View with cities
    public function choose()
    {
        $CitiesNames = DB::table('cities') -> pluck('Name'); // selecting column with cities names

        return view('choose', [
            'Cities' => $CitiesNames
        ]);
    }

    // Storing "followed" cities in database (data from form CitySelector)
    public function store(Request $request)
    {
        // How many "followed" cities we want
        $max_values_selected = 3;

        // Putting values from CitySelector[] form to selectValues array
        $selectValues = [];
        for ($i = 0; $i <= $max_values_selected-1; $i++) {
            $selectValues[$i] = request()-> CitySelector[$i];
        }

        // Updating database 'Chosen' column
        DB::table('cities') -> update(array('Chosen' => 0)); // Empty column
        for ($k = 0; $k <= count($selectValues)-1; $k++) {
            DB::table('cities') -> where('Name', $selectValues[$k]) -> limit(1) -> update(array('Chosen' => 1)); // Write indexes for chosen cities
        }
        
        return redirect('home');
    }
}