<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityCoords extends Model
{
    use HasFactory;

    protected $fillable = ['city_name', 'latitude', 'longitude'];
}
