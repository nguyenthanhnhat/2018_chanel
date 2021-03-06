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

Route::get('/api/category/all', 'API\CategoryAPIController@getAll')->name('category.all');

Route::get('/reader', 'ReaderController@index');
Route::get('/social/{provider}/redirect', 'Auth\LoginController@redirect')->name('auth.social.redirect');
Route::get('/social/{provider}/callback', 'Auth\LoginController@callback')->name('auth.social.callback');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboard/horizon', 'HomeController@horizon')->name('dashboard.horizon');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('users', 'UserController');
    });

    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::post('/profile', 'ProfileController@update')->name('profile.update');

    Route::resource('categories', 'CategoryController');

    Route::get('chanels/create/{id}', 'ChanelController@create')->name('chanels.create');
    Route::resource('chanels', 'ChanelController');

    Route::resource('banners', 'BannerController');
});


Route::resource('chanels', 'ChanelController');