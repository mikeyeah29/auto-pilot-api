<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\ShoppingList;
use App\ShoppingListItem;

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

    // Money

    Route::get('budgets', 'API\BudgetsController@index');
    Route::post('budgets', 'API\BudgetsController@store');
    Route::post('budgets/{id}', 'API\BudgetsController@update');
    Route::post('budgets/{id}/spend', 'API\BudgetsController@spend');
    Route::post('budgets/{id}/reset', 'API\BudgetsController@reset');
    Route::delete('budgets/{id}', 'API\BudgetsController@destroy');

    Route::get('transactions/ins', 'API\TransactionsController@ins');
    Route::get('transactions/outs', 'API\TransactionsController@outs');
    Route::post('transactions', 'API\TransactionsController@store');
    Route::post('transactions/{id}', 'API\TransactionsController@update');
    Route::delete('transactions/{id}', 'API\TransactionsController@destroy');

    Route::get('debts', 'API\DebtsController@index');
    Route::post('debts', 'API\DebtsController@store');
    Route::post('debts/{id}', 'API\DebtsController@update');
    Route::post('debts/{id}/pay', 'API\DebtsController@pay');
    Route::delete('debts/{id}', 'API\DebtsController@destroy');

    // Shopping

    Route::get('groceries', 'API\GroceriesController@index');
    Route::post('groceries', 'API\GroceriesController@store');
    Route::post('groceries/{id}', 'API\GroceriesController@update');
    Route::post('groceries/{id}/status', 'API\GroceriesController@toggleStatus');
    Route::delete('groceries/{id}', 'API\GroceriesController@destroy');

    Route::get('shopping-lists', 'API\ShoppingListsController@index');
    Route::post('shopping-lists', 'API\ShoppingListsController@store');
    Route::get('shopping-lists/{id}', 'API\ShoppingListsController@show');
    Route::delete('shopping-lists/{id}', 'API\ShoppingListsController@destroy');
    Route::post('shopping-lists/{id}/{grocery_id}', 'API\ShoppingListsController@addItem');
    Route::delete('shopping-lists/{id}/{item_id}', 'API\ShoppingListsController@removeItem');

    // Schedule

});

Route::get('/test', function() {

    $things = ['something', 'other hting'];

    // $list = ShoppingList::find(4)->with('items')->get();

    $list = ShoppingList::with('items.grocery')->findOrFail(4);

    // $list->items = $list->items();

    // foreach ($list->items as $item) {
    //     $item->grocery = $item->grocery();
    // }

    // dd($list);

    return response()->json(['things' => $list]);

});



