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

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/change', 'Auth\ChangePasswordController@showChangeForm')->name('password.change_form');
Route::post('password/change', 'Auth\ChangePasswordController@change')->name('password.change');

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth', 'admin']], function () {
    
    Route::get('users', 'UserController@index')->name('users.index');
    Route::post('users', 'UserController@store')->name('users.store');
    Route::get('users/create', 'UserController@create')->name('users.create');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::put('users/{user}', 'UserController@update')->name('users.update');
    Route::delete('users/{user}', 'UserController@destroy')->name('users.delete');

});

Route::group(['middleware' => ['auth', 'approver']], function () {

    Route::get('teams/{team}', 'TeamController@show')->name('teams.show');

});

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('teams', 'TeamController@index')->name('teams.index');
    Route::get('teams/create', 'TeamController@create')->name('teams.create');
    Route::post('teams', 'TeamController@store')->name('teams.store');
    Route::get('teams/{team}/edit', 'TeamController@edit')->name('teams.edit');
    Route::put('teams/{team}', 'TeamController@update')->name('teams.update');
    Route::delete('teams/{team}', 'TeamController@destroy')->name('teams.delete');

});
