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

Route::Get('/', 'PagesController@index');
Route::Get('/about', 'PagesController@about');

/**
 * * Creates all routes for Tickets
 */
Route::resource('tickets', 'TicketsController');
Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/{filter}', 'DashboardController@index');