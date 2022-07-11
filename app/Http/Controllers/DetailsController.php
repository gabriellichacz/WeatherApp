<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;

class DetailsController extends Controller
{
    public function details(City $city)
    {
        return view('details', compact('city'));
    }
}
