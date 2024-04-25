<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebAPI;

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
Route::get('/get-weather', [WebAPI::class, 'get_weather']);
Route::get('/get-category', [WebAPI::class, 'get_category']);
Route::get('/get-news-list', [WebAPI::class, 'get_news_list']);