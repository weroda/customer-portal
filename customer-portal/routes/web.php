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

Route::get('/dashboard/toggle-card', 'AccountsController@toggleCard');

Route::Get('/', 'PagesController@index');
Route::Get('/about', 'PagesController@about');

/**
 * * Creates all routes for Tickets
 */
Route::resource('tickets', 'TicketsController');
Auth::routes();

/**
 * * Creates all routes for Accounts
 */
Route::resource('accounts', 'AccountsController');

/**
 * * Creates all routes for Invoices
 */
Route::resource('invoices', 'InvoicesController');

Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/{filter}', 'DashboardController@index');
Route::post('/dashboard', 'DashboardController@index');

Route::get('/account', 'AccountsController@index');