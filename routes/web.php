<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
	return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// TESTING IDEAS
Route::get('/test', 'TestController@index')->name('test.index');
Route::get('/test/upload', 'TestController@showImageUpload')->name('test.get.upload');
Route::post('/test/upload', 'TestController@imageUpload')->name('test.post.upload');

// DOCUMENTATION
Route::get('/docs', 'DocsController@index')->name('docs.index');
Route::get('/docs/api', 'DocsController@apiRef')->name('docs.api.ref');
Route::get('/docs/schema', 'DocsController@dbSchema')->name('docs.db.schema');

// verification
Route::get('/email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('/email/resend', 'Auth\VerificationController@resend')->name('verification.resend');