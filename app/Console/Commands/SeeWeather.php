<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SeeWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SeeWeather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'See Weather';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ipKey = '9d89d5c6ce96a901bfc509826b60e2dc';
        $city = $this->ask('What is your city?');
$request = Http::get('https://api.openweathermap.org/data/2.5/weather?q=' . $city . '&appid=' . $ipKey);
    // if ($request->clientError()) {
    //     $this->error("Error performing request: ".$request->getStatusCode());
    // } elseif ($request->serverError()) {
    //     $this->error("Error from Server: ".$request->getStatusCode());
    // } else {
    //     $this->error("Error! ".$request->getStatusCode());
    // }
        if ($request->successful()){
            $j = $request->json();
        }
  
        $result = $j['main']['temp'] - 272;
        echo 'The temperature in ' . $city . ' is ' . $result;
    }
}

