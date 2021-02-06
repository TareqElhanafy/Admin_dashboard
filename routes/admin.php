<?php

use Illuminate\Support\Facades\Auth;
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

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
});


Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/login', 'Admin\LoginController@getLogin')->name('admin.getLogin');
    Route::post('/login', 'Admin\LoginController@postLogin')->name('admin.Login');
});
