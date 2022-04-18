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
Route::get('workspaces/show/{id?}/{date?}/{mov?}', 'WorkspacesController@show')->name('workspaces.show');

// ワークスペース画像のアップロード
Route::get('upload_images', 'WorkspacesController@upload_images');
Route::post('upload', 'WorkspacesController@store_images');

// 会員登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// ログイン
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login.get');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');


// ログイン後のルート
Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'workspaces/{id}'], function(){
        // お気に入り登録関連
        Route::post('favorite', 'UserFavoriteController@store')->name('workspace.favorite');
        Route::delete('unfavorite', 'UserFavoriteController@destroy')->name('workspace.unfavorite');
        // 予約関連
        Route::get('reserve/{date}', 'WorkspacesController@reserve')->name('workspace.reserve');
        Route::post('reserve/{date}', 'WorkspacesController@reserve_store')->name('reserve.store');
        Route::get('edit/{date}', 'WorkspacesController@edit')->name('workspace.edit');
        Route::post('update/{date}', 'WorkspacesController@update')->name('reserve.update');
        Route::delete('unreserve/{date}', 'WorkspacesController@destroy')->name('reserve.destroy');

    });

});