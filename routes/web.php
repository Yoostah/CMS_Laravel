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

Route::get('/', 'Site\HomeController@index')->name('site.home');

Route::prefix('admin')->group(function(){
    Route::get('/', 'Admin\HomeController@index')->name('admin.home');
    Route::get('login', 'Admin\Auth\LoginController@index')->name('login');
});