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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/view/{name}', 'DashboardController@dash');
Route::get('/plan/{name}', 'CategoryController@viewCategories');
Route::post('/planned/{name}', 'CategoryController@getCategories');
Route::post('/saved', 'SavedController@saveitenerary');
Route::get('/saved/trips/{name}', 'SavedController@showSavedTrips');
Route::get('/view/{name}/{placename}', 'PlaceViewController@view');
Route::get('/plot/{name}', 'PlotController@plot');
Route::get('/saved/itenerary', 'SavedController@saved');
Route::get('/viewtrip/{name}', 'SavedController@viewtrips');
Route::get('/plan/delete/{id}','SavedController@delete');
Route::get('/plan',function(){
	return redirect('/home');
});
Route::get('/planned/{name}', function($name){
	return redirect('/plan/'.$name);
});
Route::get('/planned', function(){
	return redirect('/home');
});
