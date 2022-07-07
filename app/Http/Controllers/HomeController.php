<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Data
        $CitiesIDs = DB::table('cities') -> where('Chosen', '1') -> pluck('CityID'); // Getting chosen cities
        $CitiesNames = DB::table('cities') -> where('Chosen', '1') -> pluck('Name');
        $city_id = $CitiesIDs[1]; // to be changed
        $API_Key = 'f7df02ae6a92e103bdc3996cbf4099a5';

        // Calling API
        $apiData = @file_get_contents('https://api.openweathermap.org/data/2.5/weather?id='.$city_id.'&appid='.$API_Key.'');
        if($apiData) {
            $data = json_decode($apiData); 
        }
        else { // if data is not found
            echo 'Invalid API key or invalid city ID.'; 
        }

        // Extracting data - static
        $data_weather = [];
        $data_weather[0] = $data->main->temp;
        $data_weather[1] = $data->main->humidity;

        //dd($CitiesNames);
        return view('home', [
            'CityName' => $CitiesNames[1], // to be changed
            'temp' => $data_weather[0],
            'humidity' => $data_weather[1],
        ]);
    }

    public function choose()
    {
        $CitiesNames = DB::table('cities') -> pluck('Name'); // select statement

        return view('choose', [
            'Cities' => $CitiesNames
        ]);
    }

    /*public function APIcall()
    {
        // Data
        $CitiesNames = DB::table('cities') -> where('Chosen', '1') -> pluck('CityID'); // Getting chosen cities

        $city_id = "3247463"; // will be dynamic
        $API_Key = 'f7df02ae6a92e103bdc3996cbf4099a5';

        // Calling API
        $apiData = @file_get_contents('https://api.openweathermap.org/data/2.5/weather?id='.$city_id.'&appid='.$API_Key.'');
        if($apiData) {
            $data = json_decode($apiData); 
        }
        else { // if data is not found
            echo 'Invalid API key or invalid city ID.'; 
        }

        // Extracting data - static
        $data_weather = [];
        $data_weather[0] = $data->main->temp;
        $data_weather[1] = $data->main->humidity;

        // Extracting data - array
        //$data_strings = ['temp', 'humidity'];
        //for ($i = 0; $i <= count($data_strings)-1; $i++) {
        //    $data_weather[$i] = $data-> main -> $data_strings[$i]; // Array to string conversion --ERROR--
        //}
        

        //dd($CitiesNames);
        return ([
            'temp' => $data_weather[0],
            'humidity' => $data_weather[1],
        ]);
    }*/

    public function store(Request $request)
    {
        // How many "followed" cities we want
        $max_values_selected = 3;

        // Putting values from CitySelector[] form to selectValues array
        $selectValues = [];
        for ($i = 0; $i <= $max_values_selected-1; $i++) {
            $selectValues[$i] = request()-> CitySelector[$i];
        }

        // Updating database Chosen column
        for ($i = 0; $i <= $max_values_selected-1; $i++) {
            DB::table('cities') -> where('Name', $selectValues[$i]) -> limit(1) -> update(array('Chosen' => 1));
        }
        
        //dd($selectValues);
        return redirect('home');
    }
}
