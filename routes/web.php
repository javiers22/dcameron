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
    return view('welcome');
});

Route::get("index","App\Http\Controllers\AppController@listado");
Route::get("habitaciones","App\Http\Controllers\AppController@habitaciones_por_hotel");
Route::get("inserthotel","App\Http\Controllers\AppController@insertar_hotel");
Route::get("gettipos","App\Http\Controllers\AppController@get_tipos");
Route::get("inserthab","App\Http\Controllers\AppController@insertar_habitacion");