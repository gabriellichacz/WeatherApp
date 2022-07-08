<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    // Corresponding table
    protected $table = 'weather';

    protected $fillable = [
        'CityID',
        'Temp',
        'Humidity',
    ];
}