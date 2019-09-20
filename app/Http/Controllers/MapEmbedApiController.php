<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MapEmbedApiController extends Controller
{
    public function getPlaceId(Request $request){
        $client = new Client();

        $lat = $request->latitude;
        $lng = $request->longitude;

        $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?key=AIzaSyBy458TdFkra6QkOkgOzrs4NCi4_DkLA3E&input='.$request->toponymName.','.$request->countryName.'&inputtype=textquery', ['verify' => false]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        //decode the received json data
        $data = json_decode($body,true);

        //filter the data for population > 0
        return $data['candidates'][0]['place_id'];

    }

    /**
     * returns a json with a list of search result
     */
    public function getGooglePlaceId(Request $request){
        $client = new Client();


        if(!$request->city){
            return json_encode(array(
                'message' => 'toponymName is required'
                ));
        }

        $lat = $request->latitude;
        $lng = $request->longitude;

        $response = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/findplacefromtext/json?key=AIzaSyBy458TdFkra6QkOkgOzrs4NCi4_DkLA3E&input='.$request->toponymName.'&inputtype=textquery&locationbias=circle:2000@'.$lat.','.$lng, ['verify' => false]);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        //decode the received json data
        $data = json_decode($body,true);

        //filter the data for population > 0
        return $data['candidates'][0]['place_id'];

    }
}
