<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class DetailsController extends Controller
{
    public function details($cityID)
    {
        return view('details', [
            'cityID' => $cityID
        ]);
    }
}
