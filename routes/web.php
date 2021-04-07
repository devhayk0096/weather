<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\SearchController;

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


Route::get('/', [PagesController::class, 'home'])->name('home');
Route::get('results', [PagesController::class, 'results'])->name('results');

Route::get('autocomplete-search', [SearchController::class, 'autoCompleteSearch'])->name('autocomplete.search');
Route::get('searched-results', [SearchController::class, 'searchedResults'])->name('searched.results');
Route::post('city-weather', [SearchController::class, 'getStoreCityWeather'])->name('city.weather');
