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

    Route::get('budgets', 'API\BudgetsController@index');
    Route::post('budgets', 'API\BudgetsController@store');
    Route::post('budgets/{id}', 'API\BudgetsController@update');
    Route::post('budgets/{id}/spend', 'API\BudgetsController@spend');
    Route::post('budgets/{id}/reset', 'API\BudgetsController@reset');
    Route::delete('budgets/{id}', 'API\BudgetsController@destroy');

});


