<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
//use App\Models\Weather;
use App\Models\City;

class HomeController extends Controller
{
    // Authentication required
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Livesearch list from json file
    public function selectSearch(Request $request)
    {
    	$cities = [];
        if($request -> has('q')){
            $search = $request->q;

            // calling function 'JsonRead'
            $MainDataArrayCities =  $this -> JsonRead(); // it contains IDs and Names

            // Getting 'name' column from data
            $CityNames = array_column(array_merge($MainDataArrayCities), 'name');

            // Filtering array (SELECT city_name FROM cities WHERE city_name LIKE search)
            $cities = preg_grep('~' . $search . '~i', $CityNames);

            // Converting array to format I need for this method to work
            $citiesConverted = array_chunk($cities, 1);

            // Converted to 1-d array
            foreach ($citiesConverted as $arr) {
                $options[] = current($arr);  
            }
            
            // Filter $MainDataArrayCities and obtain those results for which ['name'] value matches with one of the values contained in $options
            $result = array_filter($MainDataArrayCities, function($v) use ($options) {
                return in_array($v['name'], $options);
            });
        }
        return response()-> json($result);
    }

    // Calling OpenWeather API
    public function api($CitiesIDs, $CitiesNames, $j) // j - index for chosing city
    {
        $API_Key = ''; // YOUR API KEY
        $city_id = $CitiesIDs[$j];
        //$city_name = $CitiesNames[$j];
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

    public function JsonRead()
    {
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

        return ($MainDataArrayCities);
    }

    // Home view with weather dashboard
    public function index()
    {
        $max_values_selected = 10;

        $MainDataArrayCities =  $this -> JsonRead(); // calling function 'JsonRead'

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
            for ($i = 0; $i <= count($chosenCitiesIDs)-1; $i++) {
                $data_array[$i] = $this -> api($chosenCitiesIDs, $chosenCitiesNames, $i); // calling function 'api'
            }

            return view('home', [
                'data_array' => $data_array,
                'max_values_selected' => $max_values_selected,
                'Cities' => $CitiesNames,
                'CitiesIDs' => $CitiesIDs,
                'chosenCitiesIDs' => $chosenCitiesIDs
            ]);
        }
    }

    // Storing new "followed" city in database (data from form CitySelector)
    public function store(Request $request)
    {
        // Putting values from CitySelector[] form to selectValues array and separating IDs and Names
        $selectValues = request() -> livesearch;
        
        // Reading json
        $MainDataArrayCities =  $this -> JsonRead(); // it contains IDs and Names

        // Extracting name and id column
        $Cityids = array_column(array_merge($MainDataArrayCities), 'id');
        $Citynames = array_column(array_merge($MainDataArrayCities), 'name');

        // Searching for index of selected value in IDs column 
        $index = array_search($selectValues, $Cityids);

        // Chosing name from name column with previously found index
        $chosenname = $Citynames[$index];

        // Retriving already chosen cities from table to check how much of them there are and if there are no duplicates
        $chosenCitiesIDs = DB::table('cities') -> pluck('CityID') -> toArray();

        // 10 is a maximum number of followed cities
        if(count($chosenCitiesIDs) < 10 && !in_array($selectValues, $chosenCitiesIDs))
        {
            // Inserting new chosen city
            $city = City::create([
                'CityID' => $selectValues,
                'Name' => $chosenname,
                'Chosen' => '0',
            ]);
            $city -> save();

            return redirect('/home')->with('status', "Dodano $chosenname do obserowanych");
        }
        else 
        {
            return redirect('/home')->with('status', "Maksymalna liczba miast osiągnięta lub $chosenname jest już na liście obserowanych");
        }
    }

    // Deleting "followed" city from cities table
    public function delete($CityID)
    {
        // Name for displaying status
        $name = DB::table('cities') -> where('CityID', '=', $CityID) -> pluck('name');

        // Deleting
        $deleted = DB::table('cities') -> where('CityID', '=', $CityID); // select statement
        $deleted -> delete(); // delete selected item

        return redirect('/home')->with('status', "Usunięto $name[0] z obserowanych");
    }
}