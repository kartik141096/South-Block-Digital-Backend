<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WebAPI;

// Auth Routes
Route::POST('/register', [AuthController::class, 'register']);
Route::POST('/login', [AuthController::class, 'login']);
Route::POST('/logout', [AuthController::class, 'logout']);
Route::POST('/forgot-password', [AuthController::class, 'forgotpassword']);
Route::POST('/is-loged-in', [AuthController::class, 'is_loged_in']);

// Weather Routes
Route::GET('/get-weather', [WebAPI::class, 'get_weather']);


// Category Routes
Route::GET('/get-category', [WebAPI::class, 'get_category']);
Route::POST('/add-category', [WebAPI::class, 'add_category']);
Route::POST('/add-sub-category', [WebAPI::class, 'add_sub_category']);
Route::POST('/update-category', [WebAPI::class, 'update_category']);
Route::POST('/update-sub-category', [WebAPI::class, 'update_sub_category']);



// News Routes
Route::GET('/get-news-list', [WebAPI::class, 'get_news_list']);
Route::POST('/add-news', [WebAPI::class, 'add_news']);
