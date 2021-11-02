<?php

namespace App\Http\Controllers;
use App\Models\WeatherKyiv;

class WeatherForecastKyiv extends Controller
{
    public function getWeatherKyiv(){

        $out = WeatherKyiv::getFormattedWeather();
        include_once('/home/forestman/srv/http/beetroot/laravel/laravel-app/resources/views/weatherForecastKyiv.blade.php');
    }
}
