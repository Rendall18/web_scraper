<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Prueba;

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

Route::get('prueba', [Prueba::class,'index']);
Route::get('betfair', [Prueba::class,'betfair']);
Route::get('url', [Prueba::class,'getUrlPartidosLive']);