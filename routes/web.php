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
    return redirect('reports');
});
Route::get('/reports', 'ReportsController@store')->name('reports.store');
Route::get('/reports/create', 'ReportsController@create')->name('reports.create');
Route::get('/reports/{report}', 'ReportsController@show')->name('reports.show');

Route::get('/entries/{entry}', 'EntriesController@show')->name('entries.show');
