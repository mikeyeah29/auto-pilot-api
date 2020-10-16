<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('login', 'API\AuthController@login');
    Route::post('signup', 'API\AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {

        Route::get('logout', 'API\AuthController@logout');
        Route::get('user', 'API\AuthController@user');
        
    });

});

Route::group([
  'middleware' => 'auth:api',
], function() {

    // Route::get('gigs', 'API\GigsController@index');
    // Route::post('gigs', 'API\GigsController@store');
    // Route::delete('gigs/{id}', 'API\GigsController@destroy');

    // Route::get('unavailable', 'API\UnavailableController@index');
    // Route::post('unavailable', 'API\UnavailableController@store');
    // Route::delete('unavailable/{id}', 'API\UnavailableController@destroy');

});


