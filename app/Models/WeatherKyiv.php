<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class WeatherKyiv extends Model
{
    use HasFactory;
    public function weatherInKyiv(): void
    {
        $weatherDetails = $this->getWeatherDetails();
        $formattedWeather = $this->getFormattedWeather();

    }

    private function getFormattedWeather(): string
    {
        $out = "Weather in {$this->argument('city')}:\n";
        $out .= "Temperature: {$weatherDetails['main']['temp']}\n";
        $out .= "Humidity: {$weatherDetails['main']['humidity']}\n";
        $out .= "Pressure: {$weatherDetails['main']['pressure']}\n";
        $out .= "Wind: {$weatherDetails['wind']['speed']}\n";

        return $out;
    }


    private function getWeatherDetails(): array
    {
        $url = 'api.openweathermap.org/data/2.5/weather?q=kyiv&appid=9d89d5c6ce96a901bfc509826b60e2dc&units=metric';

        $response = Http::get($url);
        if ($response->status() !== ResponseAlias::HTTP_OK) {
            throw new \Exception("Invalid response: {$response->body()}");
        }

        $decodedResponse = json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);
        $decodedResponse['main'] = array_map('initial', $decodedResponse['main']);
        $decodedResponse['wind'] = array_map('initial', $decodedResponse['wind']);

        return $decodedResponse;
    }
}
