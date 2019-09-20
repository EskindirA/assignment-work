<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[
    'uses'=>'HomeController@index',
    'as'=>'welcome'
]);

Route::get('/searchcity',[
    'uses'=>'GeoNamesController@search',
    'as'=>'city.search'
]);

Route::get('/placeid',[
    'uses'=>'MapEmbedApiController@getPlaceId',
    'as'=>'place.id'
]);

Route::get('/search/location',[
    'uses'=>'GeoNamesController@searchLocation',
    'as'=>'location.search'
]);

Route::get('/google/placeid',[
    'uses'=>'MapEmbedApiController@getGooglePlaceId',
    'as'=>'google.place.id'
]);
