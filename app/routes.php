<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', array('as' => 'home', 'uses' => 'HomeController@home'));
Route::post('/login', array('as' => 'login', 'uses' => 'HomeController@login'));
Route::get('/logout', function(){
	Auth::logout();
	return Redirect::to('/');
});
Route::get('/user', array('as' => 'user', 'uses' => 'UserController@index'));
Route::post('/user/new', array('as' => 'userNew', 'uses' => 'UserController@newUser'));
Route::get('/user/search', array('as' => 'searchUser', 'uses' => 'UserController@searchUser'));
Route::post('/user/update', array('as' => 'updateUser', 'uses' => 'UserController@updateUser'));
Route::post('/user/delete', array('as' => 'deleteUser', 'uses' => 'UserController@deleteUser'));
Route::get('/surat', array('as' => 'surat', 'uses' => 'SuratController@index'));
Route::get('/surat/new', array('as' => 'suratNew', 'uses' => 'SuratController@newSurat'));
Route::post('/surat/newSurat', array('as' => 'suratNew', 'uses' => 'SuratController@addSurat'));
Route::get('/surat/search', array('as' => 'searchSurat', 'uses' => 'SuratController@searchSurat'));
Route::post('/surat/update', array('as' => 'updateSurat', 'uses' => 'SuratController@updateSurat'));
Route::post('/surat/delete', array('as' => 'deleteSurat', 'uses' => 'SuratController@deleteSurat'));
Route::post('/surat/getLast', array('as' => 'getLast', 'uses' => 'SuratController@getLast'));
Route::post('/surat/generate', array('as' => 'generate', 'uses' => 'SuratController@generate'));
Route::post('/surat/tracking', array('as' => 'tracking', 'uses' => 'SuratController@tracking'));
Route::get('/surat/getFormat', array('as' => 'getFormat', 'uses' => 'SuratController@getFormat'));
#Route for add data
Route::get('/addUser', function(){
	$user = new User;
	$user->email = 'user@rpl.com';
	$user->password = Hash::make('123');
	$user->role_id = '2';
	$user->name = 'Nuraini';
	$user->save();

	return "yuhuu";
});
Route::get('/addFormat', function(){
	$format = new Format;
	$format->tipe = 'YEAR';
	$format->keterangan = 'Tahun Sekarang';
	$format->save();

	return "yuhuu";
});
// Route::get('/surat/testing', array('as' => 'testing', 'uses' => 'SuratController@testing'));