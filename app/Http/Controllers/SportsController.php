<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SportsController extends Controller
{
    //
    public function index(Request $request)
    {
        
        $curl = curl_init();

        curl_setopt_array($curl, [
	CURLOPT_URL => "https://api-football-v1.p.rapidapi.com/v3/fixtures/events?fixture=215662",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: api-football-v1.p.rapidapi.com",
		"x-rapidapi-key: 6986e36a93msh1b417aeb5b2e40ap135983jsn556d8d01fed2"
	],
]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
	        echo "cURL Error #:" . $err;
        } else {
	        //echo $response;
	        $json = json_decode($response);
	        echo '<pre>' .print_r($json,true).'</pre>';
        }
        return view('sports.index');
    }
}
