<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DataTables;

class GeoNamesController extends Controller
{

    public $username = 'eskindir';
    public $fcode1 ='PPL';
    public $fcode2 ='PPLC';
    public $fcode3 ='PPLX';
    public $cities = 'cities1000';
    public $isNameRequired = true;

    public function search(Request $request){
        $client = new Client();

        $response = $client->request('GET', 'http://api.geonames.org/searchJSON?name='.$request->city.'&username='.$this->username.'&featureCode='.$this->fcode1.'&featureCode='.$this->fcode2.'&featureCode='.$this->fcode3.'&cities='.$this->cities.'&isNameRequired='.$this->isNameRequired);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        $data = json_decode($body,true);

        return DataTables::of($data['geonames'])->make(true);
    }


    /**
     * returns a json with list of search result
     */
    public function searchLocation(Request $request){
        $client = new Client();

        if(!$request->city){
            return json_encode(array(
                'message' => 'city is required'
                ));
        }

        $response = $client->request('GET', 'http://api.geonames.org/searchJSON?name='.$request->city.'&username='.$this->username.'&featureCode='.$this->fcode1.'&featureCode='.$this->fcode2.'&cities='.$this->cities.'&isNameRequired='.$this->isNameRequired);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        $data = json_decode($body,true);

        return $data['geonames'];
    }


}
