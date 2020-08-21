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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
  'prefix' => 'admin',
  'as' => 'admin.',
  'namespace' => 'Admin',
],
  function () {
//    Route::get('/', 'AdminController@login')->name('showLoginForm');
    Route::get('/', 'AdminController@login')->name('login');
    Route::post('/', 'AdminController@login')->name('login');

    Route::group(['middleware' => 'admin'], function () {
      Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
      Route::get('logout', 'AdminController@logout')->name('logout');
      Route::match(['get', 'post'],'settings', 'AdminController@settings')->name('settings');
      Route::post('check-current-password', 'AdminController@check_current_password');
    });
  }
);
