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
        Route::get('/create', 'LanguagesController@create')->name('admin.languages.create');
        Route::post('/store', 'LanguagesController@store')->name('admin.languages.store');
        Route::get('/edit/{id}', 'LanguagesController@edit')->name('admin.languages.edit');
        Route::post('/update/{id}', 'LanguagesController@update')->name('admin.languages.update');
        Route::get('/delete/{id}', 'LanguagesController@destroy')->name('admin.languages.delete');
    });

    /**
     * Main Categories Routes
     */

    Route::group(['prefix' => 'main-categories'], function () {
        Route::get('/', 'MainCategoriesController@index')->name('admin.categories');
        Route::get('/create', 'MainCategoriesController@create')->name('admin.categories.create');
        Route::post('/store', 'MainCategoriesController@store')->name('admin.categories.store');
        Route::get('/edit/{id}', 'MainCategoriesController@edit')->name('admin.categories.edit');
        Route::post('/update/{id}', 'MainCategoriesController@update')->name('admin.categories.update');
        Route::get('/delete/{id}', 'MainCategoriesController@destroy')->name('admin.categories.delete');
        Route::get('/change-status/{id}', 'MainCategoriesController@changeStatus')->name('admin.categories.changeStatus');
    });

    /**
     * Vendors Routes
     */

    Route::group(['prefix' => 'vendors'], function () {
        Route::get('/', 'VendorController@index')->name('admin.vendors');
        Route::get('/create', 'VendorController@create')->name('admin.vendors.create');
        Route::post('/store', 'VendorController@store')->name('admin.vendors.store');
        Route::get('/edit/{id}', 'VendorController@edit')->name('admin.vendors.edit');
        Route::post('/update/{id}', 'VendorController@update')->name('admin.vendors.update');
        Route::get('/delete/{id}', 'VendorController@destroy')->name('admin.vendors.delete');
        Route::get('/change-status/{id}', 'VendorController@changeStatus')->name('admin.vendors.changeStatus');
    });

    Route::group(['prefix' => 'sub-categories'], function () {
        Route::get('/', 'SubCategoryController@index')->name('admin.subcategories');
        Route::get('/create', 'SubCategoryController@create')->name('admin.subcategories.create');
    });
});


Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/login', 'Admin\LoginController@getLogin')->name('admin.getLogin');
    Route::post('/login', 'Admin\LoginController@postLogin')->name('admin.Login');
});
