<?php

use App\Http\Controllers\Admin\LanguagesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {

    Route::get('/', 'DashboardController@index')->name('admin.dashboard');
    Route::get('/logout', 'DashboardController@logout')->name('admin.logout');

    /**
     * Languages Group Routes
     */

    Route::group(['prefix' => 'languages'], function () {
        Route::get('/', 'LanguagesController@index')->name('admin.languages');
        Route::get('/create','LanguagesController@create')->name('admin.languages.create');
        Route::post('/store','LanguagesController@store')->name('admin.languages.store');
        Route::get('/edit/{id}','LanguagesController@edit')->name('admin.languages.edit');
        Route::post('/update/{id}','LanguagesController@update')->name('admin.languages.update');
        Route::get('/delete/{id}','LanguagesController@destroy')->name('admin.languages.delete');

    });
});


Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/login', 'Admin\LoginController@getLogin')->name('admin.getLogin');
    Route::post('/login', 'Admin\LoginController@postLogin')->name('admin.Login');
});
