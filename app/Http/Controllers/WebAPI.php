<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class WebAPI extends Controller
{
    public function get_weather()
    {   
        if($_SERVER['REMOTE_ADDR'] == "127.0.0.1")
            $q = "New Delhi";
        else{
            $q = $_SERVER['REMOTE_ADDR'];
        }

        $response = Http::get('http://api.weatherapi.com/v1/current.json', [

            'key' => '497bbe3effae4d6799050929241804',
            'q' => $q,
        ]);
        
        if ($response->successful()) 
        {
            $weatherData = $response->json();
            $weatherData['location']['date'] = date("D, j M Y");
            $weatherData['current']['condition']['icon'] = str_replace("//","",$weatherData['current']['condition']['icon']);

            // dd($weatherData);

            return json_encode($weatherData);
        }else {
            $error = $response->status();
            // dd("Error occurred: $error");
        }
    }
    public function get_data(){
        echo "Kartik";
    }
}
