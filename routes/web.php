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

Route::get('/', 'WorkspacesController@index');
Route::resource('workspaces', 'WorkspacesController');

// 会員登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login.get');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');


// お気に入り登録／解除
Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'workspaces/{id}'], function(){
        Route::post('favorite', 'UserFavoriteController@store')->name('workspace.favorite');
        Route::delete('unfavorite', 'UserFavoriteController@destroy')->name('workspace.unfavorite');

    });

});