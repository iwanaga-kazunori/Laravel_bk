<?php

namespace App\Http\Controllers\Football;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class TeamController extends Controller
{
    //
    private $api_token = '';
    public function __construct()
    {
        $this->api_token = config('services.sports_api_token.api_token');
    }
    public function detail($id)
    {
        \Log::debug(__LINE__.' '.__METHOD__.' ========== ');
        $uri = 'http://api.football-data.org/v2/teams/' . $id;
        $header = array('headers' => array('X-Auth-Token' => $this->api_token));
        $cache_key = 'api.football-data.org/v2/teams/' . $id;
        //Cache::pull($cache_key);
        $teams = '';
        $client = new Client();
        if (Cache::has($cache_key)) {
            $body_encoded = Cache::get($cache_key);
            $body_decoded = json_decode($body_encoded);
            \Log::debug(__LINE__.' '.__METHOD__.' キャッシュあり ');
            \log::debug(print_r($body_decoded,true));
        } else {
            $response = $client->get($uri, $header);
            $body = $response->getBody();
            $body_decoded = json_decode($body,false);
            //dd($body_decoded);
            
            //$matches = json_decode($matches, true);
            Cache::put($cache_key, json_encode($body_decoded), 3600);
            \Log::debug(__LINE__.' '.__METHOD__.' キャッシュなし ');
            \log::debug(print_r($body_decoded,true));
            
        }
        //dd($matches);
        // $teams_decoded = json_decode($teams, true);
        // echo '<pre>' .print_r($teams_decoded,true).'</pre>';
        return view('teams.detail', ['team' => $body_decoded]);
    }
}
