<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function choose()
    {
        return view('choose');
    }

    public function APIcall()
    {
        // Data
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
        /*$data_strings = ['temp','feels_like','temp_min','temp_max','pressure','humidity'];

        for ($i = 0; $i <= count($data_strings)-1; $i++) {
            $data_weather[$i] = $data-> main -> $data_strings[$i]; // Array to string conversion ERROR
        }
        */

        //dd($data_weather); // dump data
        return ([
            'temp' => $data_weather[0],
            'humidity' => $data_weather[1],
        ]);
    }

    public function store(Request $request)
    {
        // How many "followed" cities we want
        $max_values_selected = 3;

        // Putting values from CitySelector[] form to selectValues array
        $selectValues = [];
        for ($i = 0; $i <= $max_values_selected-1; $i++) {
            $selectValues[$i] = request()->CitySelector[$i];
        }
    
        dd($selectValues);
    }
}
