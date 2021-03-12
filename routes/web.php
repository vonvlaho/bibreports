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
    return view('index');
})->name('index');

Route::get('/reports', 'ReportsController@store')->name('reports.store');
Route::get('/reports/{report}', 'ReportsController@show')->name('reports.show');
Route::get('/reports/{report}/keywords', 'ReportsController@showKeywords')->name('reports.show.keywords');
Route::get('/reports/{report}/people', 'ReportsController@showPeople')->name('reports.show.people');
Route::get('/reports/{report}/places', 'ReportsController@showPlaces')->name('reports.show.places');

Route::get('/entries/{entry}', 'EntriesController@show')->name('entries.show');

Route::get('/search/', 'SearchController@searchEntries')->name('search.search');

Route::get('/analytics', function () {
    return view('analytics');
})->name('analytics');

Route::get('/keywords', 'KeywordsController@store')->name('keywords.store');
Route::get('/keywords/data', 'KeywordsController@data')->name('keywords.data');
Route::get('/keywords/download', 'KeywordsController@download')->name('keywords.download');
Route::get('/keywords/{keyword}', 'KeywordsController@show')->name('keywords.show');

Route::get('/people', 'PeopleController@store')->name('people.store');
Route::get('/people/data', 'PeopleController@data')->name('people.data');
Route::get('/people/download', 'PeopleController@download')->name('people.download');
Route::get('/people/{people}', 'PeopleController@show')->name('people.show');

Route::get('/places', 'PlacesController@store')->name('places.store');
Route::get('/places/data', 'PlacesController@data')->name('places.data');
Route::get('/places/download', 'PlacesController@download')->name('places.download');
Route::get('/places/{places}', 'PlacesController@show')->name('places.show');
