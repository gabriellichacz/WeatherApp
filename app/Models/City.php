<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    // Corresponding table
    protected $table = 'cities';

    protected $fillable = [
        'Chosen',
    ];
}
